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
            'type' => ['required', 'in:annual,sick,important,other'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
            'attachment' => ['nullable', 'file', 'max:10240'], // 10MB max
        ]);

        try {
            // Check for overlapping leave requests
            $hasOverlap = LeaveRequest::where('user_id', Auth::id())
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                        ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
                })->exists();

            if ($hasOverlap) {
                return back()->with('error', 'You already have a leave request for these dates.');
            }

            // Handle file upload if present
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('leave-attachments', 'public');
            }

            // Calculate leave duration
            $startDate = Chronos::parse($validated['start_date']);
            $endDate = Chronos::parse($validated['end_date']);
            $duration = 0;

            for ($date = $startDate; $date->lessThanOrEquals($endDate); $date = $date->addDays(1)) {
                if (!$date->isWeekend()) {
                    $duration++;
                }
            }

            // Check leave balance for annual leave
            if ($validated['type'] === 'annual') {
                $leaveBalance = LeaveBalance::where('user_id', Auth::id())
                    ->where('year', now()->year)
                    ->first();

                if (!$leaveBalance || $leaveBalance->remaining_balance < $duration) {
                    return back()->with('error', 'Insufficient annual leave balance.');
                }
            }

            // Create leave request
            $leaveRequest = LeaveRequest::create([
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'reason' => $validated['reason'],
                'status' => 'pending',
                'attachment_path' => $attachmentPath
            ]);

            return redirect()->route('staff.leave.index')
                ->with('success', 'Leave request submitted successfully.');
        } catch (\Exception $e) {
            // Clean up uploaded file if request creation fails
            if (isset($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }

            return back()->with('error', 'Failed to submit leave request. Please try again.');
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
