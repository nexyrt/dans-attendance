<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LeaveRequest;
use Livewire\Attributes\On;

class Leave extends Component
{
    use WithFileUploads;

    // Form properties
    public $showLeaveForm = false;
    public $type = '';
    public $startDate;
    public $endDate;
    public $reason = '';
    public $attachment;

    // Tab state
    public $activeTab = 'pending';

    protected $listeners = [
        'dateRangeSelected' => 'updateDateRange'
    ];

    protected $rules = [
        'type' => 'required|in:sick,annual,important,other',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'reason' => 'required|string|min:10',
        'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
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
    }

    public function submitLeave()
    {
        $this->validate();

        $leaveRequest = new LeaveRequest([
            'type' => $this->type,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'reason' => $this->reason,
            'status' => LeaveRequest::STATUS_PENDING
        ]);

        if ($this->attachment) {
            $path = $this->attachment->store('leave-attachments', 'public');
            $leaveRequest->attachment_path = $path;
        }

        auth()->user()->leaveRequests()->save($leaveRequest);

        $this->reset(['showLeaveForm', 'type', 'startDate', 'endDate', 'reason', 'attachment']);
        $this->dispatch('close-modal');
        session()->flash('message', 'Leave request submitted successfully.');
    }

    public function cancelRequest($id)
    {
        $leaveRequest = auth()->user()->leaveRequests()->findOrFail($id);
        if ($leaveRequest->canBeCancelled()) {
            $leaveRequest->cancel();
            session()->flash('message', 'Leave request cancelled successfully.');
        }
    }

    public function getLeaveRequestsProperty()
    {
        return auth()->user()->leaveRequests()
            ->when($this->activeTab === 'pending', fn($query) => $query->pending())
            ->when($this->activeTab === 'approved', fn($query) => $query->where('status', LeaveRequest::STATUS_APPROVED))
            ->when($this->activeTab === 'rejected', fn($query) => $query->where('status', LeaveRequest::STATUS_REJECTED))
            ->when($this->activeTab === 'cancelled', fn($query) => $query->where('status', LeaveRequest::STATUS_CANCEL))
            ->latest()
            ->get();
    }

    public function getLeaveBalanceProperty()
    {
        return auth()->user()->currentLeaveBalance();
    }

    public function render()
    {
        return view('livewire.staff.leave', [
            'leaveRequests' => $this->leaveRequests,
            'leaveBalance' => $this->leaveBalance,
            'leaveTypes' => LeaveRequest::TYPES
        ])->layout('layouts.staff', ['title' => 'Leave Management']);
    }
}