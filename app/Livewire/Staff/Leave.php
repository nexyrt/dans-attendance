<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LeaveRequest;
use Livewire\Attributes\On;
use Cake\Chronos\Chronos;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Leave extends Component
{
    use WithFileUploads;

    // Form properties
    public $type;
    public $startDate;
    public $endDate;
    public $reason = '';
    public $attachment;

    // View states
    public $activeView = 'requests';
    public $activeTab = 'pending';
    public $previewingAttachment = false;
    public $currentAttachment = null;
    public $previewUrl = null;
    public $previewType = null;
    public $showPreview = false;

    protected $rules = [
        'type' => 'required|in:sick,annual,important,other',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'reason' => 'required|string|min:10|max:500',
        'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240'
    ];

    protected $messages = [
        'type.required' => 'Please select a leave type.',
        'type.in' => 'Invalid leave type selected.',
        'startDate.required' => 'Start date is required.',
        'startDate.date' => 'Invalid start date format.',
        'endDate.required' => 'End date is required.',
        'endDate.date' => 'Invalid end date format.',
        'endDate.after_or_equal' => 'End date must be after or equal to start date.',
        'reason.required' => 'Please provide a reason for your leave.',
        'reason.min' => 'Reason must be at least 10 characters.',
        'reason.max' => 'Reason cannot exceed 500 characters.',
        'attachment.mimes' => 'Attachment must be a PDF, Word document, or image file.',
        'attachment.max' => 'Attachment size cannot exceed 10MB.'
    ];

    public function mount()
    {
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    #[On('date-range-selected')]
    public function handleDateRangeSelected($data)
    {
        $this->startDate = $data['startDate'];
        $this->endDate = $data['endDate'];

        try {
            $this->validateLeaveBalance();
            $this->validateDateOverlap();
        } catch (ValidationException $e) {
            $this->addError('dates', $e->getMessage());
        }
    }

    protected function validateLeaveBalance()
    {
        $duration = $this->calculateDuration();
        $balance = $this->leaveBalance->remaining_balance;

        if ($duration > $balance) {
            throw ValidationException::withMessages([
                'dates' => "Insufficient leave balance. You have {$balance} days remaining but requested {$duration} days."
            ]);
        }
    }

    protected function validateDateOverlap()
    {
        $overlappingLeave = auth()->user()->leaveRequests()
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('start_date', '<=', $this->startDate)
                        ->where('end_date', '>=', $this->startDate);
                })->orWhere(function ($q) {
                    $q->where('start_date', '<=', $this->endDate)
                        ->where('end_date', '>=', $this->endDate);
                })->orWhere(function ($q) {
                    $q->where('start_date', '>=', $this->startDate)
                        ->where('end_date', '<=', $this->endDate);
                });
            })
            ->whereNotIn('status', [
                LeaveRequest::STATUS_REJECTED_MANAGER,
                LeaveRequest::STATUS_REJECTED_HR,
                LeaveRequest::STATUS_REJECTED_DIRECTOR,
                LeaveRequest::STATUS_CANCEL
            ])
            ->first();

        if ($overlappingLeave) {
            $start = Chronos::parse($overlappingLeave->start_date)->format('M j, Y');
            $end = Chronos::parse($overlappingLeave->end_date)->format('M j, Y');
            throw ValidationException::withMessages([
                'dates' => "Date range overlaps with existing {$overlappingLeave->status} leave request ({$start} - {$end})."
            ]);
        }
    }

    protected function calculateDuration()
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }

        $start = Chronos::parse($this->startDate);
        $end = Chronos::parse($this->endDate);
        $duration = 0;

        $date = $start;
        while ($date->lessThanOrEquals($end)) {
            if (!$date->isWeekend()) {
                $duration++;
            }
            $date = $date->addDays(1);
        }

        return $duration;
    }

    public function submitLeave()
    {
        $this->validate();

        try {
            // Validate leave balance and date overlap before proceeding
            $this->validateLeaveBalance();
            $this->validateDateOverlap();
            
            $leaveRequest = new LeaveRequest([
                'user_id' => auth()->id(),
                'type' => $this->type,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'reason' => $this->reason,
                'status' => LeaveRequest::STATUS_PENDING_MANAGER
            ]);

            if ($this->attachment) {
                try {
                    $uploadPath = public_path('leave-attachments');
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $this->attachment->getClientOriginalName());
                    $tempPath = $this->attachment->getRealPath();
                    File::move($tempPath, $uploadPath . DIRECTORY_SEPARATOR . $filename);
                    
                    $leaveRequest->attachment_path = 'leave-attachments/' . $filename;
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage());
                    session()->flash('error', 'File upload failed. Please try again.');
                    return;
                }
            }

            auth()->user()->leaveRequests()->save($leaveRequest);

            $this->reset(['type', 'startDate', 'endDate', 'reason', 'attachment']);
            $this->activeView = 'requests';
            session()->flash('message', 'Leave request submitted successfully.');

        } catch (ValidationException $e) {
            $this->addError('dates', $e->getMessage());
        }
    }

    public function cancelRequest($id)
    {
        $leaveRequest = auth()->user()->leaveRequests()->findOrFail($id);
        if ($leaveRequest->canBeCancelled()) {
            $leaveRequest->cancel();
            session()->flash('message', 'Leave request cancelled successfully.');
        }
    }

    public function previewAttachment($requestId)
    {
        $request = auth()->user()->leaveRequests()->findOrFail($requestId);
        if ($request->attachment_path) {
            $this->previewUrl = asset($request->attachment_path);

            // Get file extension
            $extension = pathinfo($request->attachment_path, PATHINFO_EXTENSION);
            $this->previewType = strtolower($extension);

            $this->showPreview = true;
        }
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->previewUrl = null;
        $this->previewType = null;
    }

    public function getLeaveRequestsProperty()
    {
        return auth()->user()->leaveRequests()
            ->when($this->activeTab === 'pending', function ($query) {
                $query->whereIn('status', [
                    LeaveRequest::STATUS_PENDING_MANAGER,
                    LeaveRequest::STATUS_PENDING_HR,
                    LeaveRequest::STATUS_PENDING_DIRECTOR
                ]);
            })
            ->when($this->activeTab === 'approved', fn($query) =>
                $query->where('status', LeaveRequest::STATUS_APPROVED))
            ->when($this->activeTab === 'rejected', function ($query) {
                $query->whereIn('status', [
                    LeaveRequest::STATUS_REJECTED_MANAGER,
                    LeaveRequest::STATUS_REJECTED_HR,
                    LeaveRequest::STATUS_REJECTED_DIRECTOR
                ]);
            })
            ->when($this->activeTab === 'cancelled', fn($query) =>
                $query->where('status', LeaveRequest::STATUS_CANCEL))
            ->with(['manager', 'hr', 'director'])
            ->latest()
            ->get();
    }

    public function getLeaveBalanceProperty()
    {
        return auth()->user()->currentLeaveBalance();
    }

    public function getStatusBadgeClass($status)
    {
        return match ($status) {
            LeaveRequest::STATUS_PENDING_MANAGER,
            LeaveRequest::STATUS_PENDING_HR,
            LeaveRequest::STATUS_PENDING_DIRECTOR => 'bg-yellow-100 text-yellow-800',

            LeaveRequest::STATUS_APPROVED => 'bg-green-100 text-green-800',

            LeaveRequest::STATUS_REJECTED_MANAGER,
            LeaveRequest::STATUS_REJECTED_HR,
            LeaveRequest::STATUS_REJECTED_DIRECTOR => 'bg-red-100 text-red-800',

            LeaveRequest::STATUS_CANCEL => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getDurationProperty()
    {
        return $this->calculateDuration();
    }

    public function getPendingCountProperty()
    {
        return auth()->user()->leaveRequests()
            ->whereIn('status', [
                LeaveRequest::STATUS_PENDING_MANAGER,
                LeaveRequest::STATUS_PENDING_HR,
                LeaveRequest::STATUS_PENDING_DIRECTOR
            ])->count();
    }
    public function getApprovalStatus($request)
    {
        $status = match ($request->status) {
            LeaveRequest::STATUS_PENDING_MANAGER => 'Pending Manager Approval',
            LeaveRequest::STATUS_PENDING_HR => 'Pending HR Approval',
            LeaveRequest::STATUS_PENDING_DIRECTOR => 'Pending Director Approval',
            LeaveRequest::STATUS_APPROVED => 'Approved',
            LeaveRequest::STATUS_REJECTED_MANAGER => 'Rejected by Manager',
            LeaveRequest::STATUS_REJECTED_HR => 'Rejected by HR',
            LeaveRequest::STATUS_REJECTED_DIRECTOR => 'Rejected by Director',
            LeaveRequest::STATUS_CANCEL => 'Cancelled',
            default => 'Unknown Status'
        };

        $details = [];

        if ($request->manager_approved_at) {
            $details[] = "Manager: " . ($request->manager ? $request->manager->name : 'Unknown') .
                " on " . $request->manager_approved_at->format('M j, Y');
        }

        if ($request->hr_approved_at) {
            $details[] = "HR: " . ($request->hr ? $request->hr->name : 'Unknown') .
                " on " . $request->hr_approved_at->format('M j, Y');
        }

        if ($request->director_approved_at) {
            $details[] = "Director: " . ($request->director ? $request->director->name : 'Unknown') .
                " on " . $request->director_approved_at->format('M j, Y');
        }

        return [
            'status' => $status,
            'details' => $details
        ];
    }

    public function getApprovedCountProperty()
    {
        return auth()->user()->leaveRequests()
            ->where('status', LeaveRequest::STATUS_APPROVED)
            ->count();
    }

    public function getRejectedCountProperty()
    {
        return auth()->user()->leaveRequests()
            ->whereIn('status', [
                LeaveRequest::STATUS_REJECTED_MANAGER,
                LeaveRequest::STATUS_REJECTED_HR,
                LeaveRequest::STATUS_REJECTED_DIRECTOR
            ])->count();
    }

    public function getCancelledCountProperty()
    {
        return auth()->user()->leaveRequests()
            ->where('status', LeaveRequest::STATUS_CANCEL)
            ->count();
    }

    protected function getLastLeave()
    {
        return auth()->user()->leaveRequests()
            ->where('status', LeaveRequest::STATUS_APPROVED)
            ->latest('end_date')
            ->first();
    }

    public function render()
    {
        $this->dispatch('refresh-preline');
        return view('livewire.staff.leave', [
            'leaveRequests' => $this->leaveRequests,
            'leaveBalance' => $this->leaveBalance,
            'leaveTypes' => LeaveRequest::TYPES,
            'duration' => $this->duration
        ])->layout('layouts.staff', ['title' => 'Leave Management']);
    }
}