<?php

namespace App\Livewire\Staff;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use Cake\Chronos\Chronos;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Leave extends Component
{
    use WithPagination;
    use WithFileUploads;

    // For Main Leave
    public $activeTab = 'requests';

    // For Table
    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $perPage = 10;

    // For Form
    public $type = '';
    public $start_date = '';
    public $end_date = '';
    public $reason = '';
    public $attachment;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'type' => 'required|string',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|min:10',
        'attachment' => 'nullable|file|max:5120', // 5MB Max
    ];

    public function mount()
    {
        $this->dateFilter = 'current_month';
    }

    public function render()
    {
        $leaveBalance = LeaveBalance::where('user_id', auth()->id())
            ->where('year', Chronos::now()->year)
            ->first();

        $leaveRequests = LeaveRequest::query()
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where('reason', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->with('approvedBy')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.staff.leave', [
            'leaveBalance' => $leaveBalance,
            'leaveRequests' => $leaveRequests,
        ])->layout('layouts.staff', ['title' => 'Leave Management']);
    }

    // For Main Leave Page
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetForm();
    }

    // For Table
    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'typeFilter']);
    }

    public function cancelLeave($leaveId)
    {
        $leave = LeaveRequest::where('user_id', auth()->id())->findOrFail($leaveId);

        if ($leave->canBeCancelled()) {
            $leave->cancel();
            $this->dispatch('leave-cancelled', 'Leave request cancelled successfully');
        }
    }

    // For Form
    public function submitForm()
    {
        $this->validate();

        try {
            $leaveData = [
                'type' => $this->type,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
                'status' => LeaveRequest::STATUS_PENDING,
                'user_id' => auth()->id(),
            ];

            // Handle file upload if attachment exists
            if ($this->attachment) {
                $path = $this->attachment->store('leave-attachments', 'public');
                $leaveData['attachment_path'] = $path;
            }

            // Calculate duration to check against leave balance
            $leaveRequest = new LeaveRequest($leaveData);
            $duration = $leaveRequest->getDurationInDays();

            // Check leave balance
            $leaveBalance = auth()->user()->currentLeaveBalance();
            if (!$leaveBalance || $leaveBalance->remaining_balance < $duration) {
                $this->addError('general', 'Insufficient leave balance for this request.');
                return;
            }

            LeaveRequest::create($leaveData);

            $this->dispatch('leave-requested', 'Leave request submitted successfully');
            $this->resetForm();
            $this->activeTab = 'requests';

        } catch (\Exception $e) {
            $this->addError('general', 'An error occurred while submitting your request.');
        }
    }

    public function resetForm()
    {
        $this->reset(['type', 'start_date', 'end_date', 'reason', 'attachment']);
        $this->resetErrorBag();
    }
}