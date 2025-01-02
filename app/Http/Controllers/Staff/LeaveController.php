<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\User;
use App\Services\LeaveBalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    protected $leaveBalanceService;

    public function __construct(LeaveBalanceService $leaveBalanceService)
    {
        $this->leaveBalanceService = $leaveBalanceService;
    }

    public function index(): View
    {
        /** @var User $user */
        $user = auth()->user();

        // Get current user's leave balance for current year
        $currentBalance = LeaveBalance::firstOrCreate(
            [
                'user_id' => $user->id,
                'year' => Carbon::now()->year
            ],
            [
                'total_balance' => 12,
                'used_balance' => 0,
                'remaining_balance' => 12
            ]
        );

        // Get recent leave requests with latest first
        $recentRequests = LeaveRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'type' => ucfirst($request->type),
                    'dates' => $request->formatted_duration,
                    'status' => $request->status,
                    'can_cancel' => $request->canBeCancelled(),
                    'reason' => $request->reason,
                    'duration_type' => $request->duration_type,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'attachment_path' => $request->attachment_path,
                    'status_badge' => $request->status_badge
                ];
            });

        return view('staff.leaves.index', compact('currentBalance', 'recentRequests'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:' . implode(',', LeaveRequest::TYPES),
            'duration_type' => 'required|in:' . implode(',', LeaveRequest::DURATION_TYPES),
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required_if:duration_type,full_day|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = auth()->user();
            
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            // Calculate duration based on duration type
            $duration = $validated['duration_type'] === 'full_day'
                ? Carbon::parse($validated['start_date'])->diffInDays(Carbon::parse($validated['end_date'])) + 1
                : 0.5;

            // Check leave balance for non-sick leave
            if ($validated['type'] !== 'sick' && !$this->leaveBalanceService->checkAvailableBalance($user, $validated['type'], $duration)) {
                return back()
                    ->withErrors(['message' => 'Insufficient leave balance.'])
                    ->withInput();
            }

            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('leave-attachments', 'public');
            }

            // Create leave request
            $leaveRequest = LeaveRequest::create([
                'user_id' => $user->id,
                'type' => $validated['type'],
                'duration_type' => $validated['duration_type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['duration_type'] === 'full_day' 
                    ? $validated['end_date'] 
                    : $validated['start_date'],
                'reason' => $validated['reason'],
                'status' => 'pending',
                'attachment_path' => $attachmentPath
            ]);

            // Update leave balance for non-sick leave
            if ($validated['type'] !== 'sick') {
                $this->leaveBalanceService->updateLeaveBalance($user, $duration);
            }

            DB::commit();

            return redirect()
                ->route('staff.leave.index')
                ->with('success', 'Leave request submitted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Clean up uploaded file if exists
            if (isset($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }
            
            return back()
                ->withErrors(['message' => 'An error occurred while submitting your request.'])
                ->withInput();
        }
    }

    public function cancel(LeaveRequest $leaveRequest)
{
    try {
        DB::beginTransaction();

        // Verify ownership of the request
        if ($leaveRequest->user_id !== auth()->id()) {
            throw new \Exception('Unauthorized action.');
        }

        // Cancel the request
        $leaveRequest->update(['status' => 'cancelled']);

        // Restore leave balance if it was an approved request
        if ($leaveRequest->status === 'approved' && $leaveRequest->type !== 'sick') {
            $this->leaveBalanceService->updateLeaveBalance(
                $leaveRequest->user,
                $leaveRequest->getDurationInDays(),
                'add'
            );
        }

        DB::commit();

        return redirect()->route('staff.leave.index')
            ->with('success', 'Leave request cancelled successfully.');

    } catch (\Exception $e) {
        DB::rollback();
        
        return redirect()->route('staff.leave.index')
            ->withErrors(['message' => 'An error occurred while cancelling your request.']);
    }
}

    public function show(LeaveRequest $leaveRequest): View
    {
        $this->authorize('view', $leaveRequest);
        
        return view('staff.leaves.show', compact('leaveRequest'));
    }
}