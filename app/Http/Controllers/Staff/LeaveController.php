<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Cake\Chronos\Chronos;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LeaveController extends Controller
{
    /**
     * Display the leave management page
     */
    public function index()
    {
        $user = Auth::user();

        return view('staff.leaves.index', [
            // Get paginated leave requests
            'leaveRequests' => LeaveRequest::where('user_id', $user->id)
                ->latest()
                ->paginate(10),

            // Get current year's leave balance
            'leaveBalance' => LeaveBalance::where('user_id', $user->id)
                ->where('year', now()->year)
                ->first(),

            // Count pending requests
            'pendingCount' => LeaveRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),

            // Get recent activity
            'recentActivity' => LeaveRequest::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get()
        ]);
    }

    /**
     * Store a new leave request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:' . implode(',', LeaveRequest::TYPES)],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'max:1000'],
            'attachment' => ['nullable', 'file', 'max:10240'],
        ]);

        $user = auth()->user();
        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];

        // Check for overlapping leave requests
        $overlappingRequest = LeaveRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $startDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $endDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '>=', $startDate)
                        ->where('end_date', '<=', $endDate);
                });
            })
            ->first();

        if ($overlappingRequest) {
            return redirect()
                ->route('staff.leave.index')
                ->with('error', sprintf(
                    'Leave request cannot be created. You already have a %s leave request from %s to %s.',
                    $overlappingRequest->status,
                    Chronos::parse($overlappingRequest->start_date)->format('M d, Y'),
                    Chronos::parse($overlappingRequest->end_date)->format('M d, Y')
                ));
        }

        try {
            $leaveRequest = new LeaveRequest();
            $leaveRequest->user_id = $user->id;
            $leaveRequest->type = $validated['type'];
            $leaveRequest->start_date = $startDate;
            $leaveRequest->end_date = $endDate;
            $leaveRequest->reason = $validated['reason'];
            $leaveRequest->status = 'pending';

            if ($request->hasFile('attachment')) {
                $leaveRequest->attachment_path = $request->file('attachment')->store('leave-attachments', 'public');
            }

            $leaveRequest->save();

            return redirect()
                ->route('staff.leave.index')
                ->with('success', 'Your leave request has been submitted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('staff.leave.index')
                ->with('error', 'An error occurred while submitting your leave request. Please try again.');
        }
    }

    /**
     * Cancel a leave request
     */
    public function cancel(LeaveRequest $leaveRequest)
    {
        try {
            // Check if user owns this leave request
            if ($leaveRequest->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            // Check if leave request can be cancelled
            if ($leaveRequest->status !== 'pending') {
                return back()->with('error', 'Only pending leave requests can be cancelled.');
            }

            // Delete attachment if exists
            if ($leaveRequest->attachment_path) {
                Storage::disk('public')->delete($leaveRequest->attachment_path);
            }

            // Update status to cancelled
            $leaveRequest->update(['status' => 'cancel']);

            return redirect()->route('staff.leave.index')
                ->with('success', 'Leave request has been cancelled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel leave request. Please try again.');
        }
    }

    /**
     * Download leave request attachment
     */
    public function downloadAttachment(LeaveRequest $leaveRequest): BinaryFileResponse|RedirectResponse
    {
        // Check if user owns this leave request
        if ($leaveRequest->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Check if attachment exists
        if (!$leaveRequest->attachment_path || !Storage::disk('public')->exists($leaveRequest->attachment_path)) {
            return back()->with('error', 'Attachment not found.');
        }

        // Get the physical path of the file
        $physicalPath = storage_path('app/public/' . $leaveRequest->attachment_path);

        // Return file download response
        return response()->download($physicalPath);
    }
}
