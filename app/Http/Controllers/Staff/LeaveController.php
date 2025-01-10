<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Schedule;
use App\Models\ScheduleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Cake\Chronos\Chronos;
use Carbon\Carbon;
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
        $currentYear = now()->year;

        return view('staff.leaves.index', [
            'leaveRequests' => LeaveRequest::with(['approvedBy'])  // Eager load relationships
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10),

            'leaveBalance' => LeaveBalance::firstOrCreate(
                ['user_id' => $user->id, 'year' => $currentYear],
                [
                    'total_balance' => 12, // Default annual leave balance
                    'used_balance' => 0,
                    'remaining_balance' => 12
                ]
            ),

            'pendingCount' => LeaveRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),

            'recentActivity' => LeaveRequest::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get()
        ]);
    }

    /**
     * Store a new leave request
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:' . implode(',', LeaveRequest::TYPES)],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'max:1000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,png,jpg,jpeg', 'max:10240'],
        ]);

        try {
            return DB::transaction(function () use ($request, $validated) {
                $user = auth()->user();
                $startDate = Carbon::parse($validated['start_date']);
                $endDate = Carbon::parse($validated['end_date']);
                
                // Check for overlapping leave requests
                $overlappingRequest = $this->checkOverlappingRequests($user->id, $startDate, $endDate);
                if ($overlappingRequest) {
                    return redirect()
                        ->route('staff.leave.index')
                        ->with('error', $this->formatOverlappingError($overlappingRequest));
                }

                // Check leave balance for annual leave
                if ($validated['type'] === 'annual') {
                    $durationInDays = $this->calculateWorkingDays($startDate, $endDate);
                    $leaveBalance = LeaveBalance::where('user_id', $user->id)
                        ->where('year', now()->year)
                        ->first();

                    if (!$leaveBalance || $leaveBalance->remaining_balance < $durationInDays) {
                        return redirect()
                            ->route('staff.leave.index')
                            ->with('error', 'Insufficient leave balance.');
                    }
                }

                // Create leave request
                $leaveRequest = new LeaveRequest();
                $leaveRequest->fill([
                    'user_id' => $user->id,
                    'type' => $validated['type'],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'reason' => $validated['reason'],
                    'status' => 'pending'
                ]);

                // Handle file upload
                if ($request->hasFile('attachment')) {
                    $leaveRequest->attachment_path = $this->handleFileUpload($request->file('attachment'));
                }

                $leaveRequest->save();

                return redirect()
                    ->route('staff.leave.index')
                    ->with('success', 'Leave request submitted successfully.');
            });
        } catch (\Exception $e) {
            // Log the error for debugging
            logger()->error('Leave request creation failed:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'request_data' => $request->except(['attachment'])
            ]);

            return redirect()
                ->route('staff.leave.index')
                ->with('error', 'An error occurred while submitting your leave request. Please try again.');
        }
    }

    /**
     * Cancel a leave request
     */
    public function cancel(LeaveRequest $leaveRequest): RedirectResponse
    {
        try {
            if ($leaveRequest->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            if ($leaveRequest->status !== 'pending') {
                return back()->with('error', 'Only pending leave requests can be cancelled.');
            }

            DB::transaction(function () use ($leaveRequest) {
                // Delete attachment if exists
                if ($leaveRequest->attachment_path) {
                    Storage::disk('public')->delete($leaveRequest->attachment_path);
                }

                $leaveRequest->update(['status' => 'cancel']);
            });

            return redirect()
                ->route('staff.leave.index')
                ->with('success', 'Leave request cancelled successfully.');
        } catch (\Exception $e) {
            logger()->error('Leave cancellation failed:', [
                'error' => $e->getMessage(),
                'leave_request_id' => $leaveRequest->id
            ]);

            return back()->with('error', 'Failed to cancel leave request. Please try again.');
        }
    }

    /**
     * Download leave request attachment
     */
    public function downloadAttachment(LeaveRequest $leaveRequest): BinaryFileResponse|RedirectResponse
    {
        try {
            if ($leaveRequest->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            if (!$leaveRequest->attachment_path || !Storage::disk('public')->exists($leaveRequest->attachment_path)) {
                return back()->with('error', 'Attachment not found.');
            }

            return response()->download(
                storage_path('app/public/' . $leaveRequest->attachment_path),
                $this->generateAttachmentFilename($leaveRequest)
            );
        } catch (\Exception $e) {
            logger()->error('Attachment download failed:', [
                'error' => $e->getMessage(),
                'leave_request_id' => $leaveRequest->id
            ]);

            return back()->with('error', 'Failed to download attachment. Please try again.');
        }
    }

    /**
     * Check for overlapping leave requests
     */
    private function checkOverlappingRequests(int $userId, Carbon $startDate, Carbon $endDate): ?LeaveRequest
    {
        return LeaveRequest::where('user_id', $userId)
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
    }

    /**
     * Calculate working days between two dates (excluding weekends and holidays)
     */
    private function calculateWorkingDays(Carbon $startDate, Carbon $endDate): int
    {
        $days = 0;
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            // Skip weekends
            if (!$currentDate->isWeekend()) {
                // Check for holidays or schedule exceptions
                $isHoliday = ScheduleException::where('date', $currentDate->format('Y-m-d'))
                    ->where('status', 'holiday')
                    ->exists();

                if (!$isHoliday) {
                    $days++;
                }
            }
            $currentDate->addDay();
        }

        return $days;
    }

    /**
     * Handle file upload for leave request attachments
     */
    private function handleFileUpload($file): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('leave-attachments', $fileName, 'public');
    }

    /**
     * Generate a friendly filename for attachment downloads
     */
    private function generateAttachmentFilename(LeaveRequest $leaveRequest): string
    {
        $extension = pathinfo($leaveRequest->attachment_path, PATHINFO_EXTENSION);
        return "leave_attachment_{$leaveRequest->id}.{$extension}";
    }

    /**
     * Format error message for overlapping leave requests
     */
    private function formatOverlappingError(LeaveRequest $overlappingRequest): string
    {
        return sprintf(
            'Leave request cannot be created. You already have a %s leave request from %s to %s.',
            $overlappingRequest->status,
            Carbon::parse($overlappingRequest->start_date)->format('M d, Y'),
            Carbon::parse($overlappingRequest->end_date)->format('M d, Y')
        );
    }
}