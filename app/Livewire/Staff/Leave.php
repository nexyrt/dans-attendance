<?php

namespace App\Livewire\Staff;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use Cake\Chronos\Chronos;
use Livewire\Component;
use Livewire\WithPagination;

class Leave extends Component
{
    use WithPagination;

    // For Main Leave
    public $activeTab = 'requests';

    // For Table
    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $dateFilter = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->dateFilter = 'current_month';
    }

    public function render()
    {
        $leaveBalance = LeaveBalance::where('user_id', auth()->id())
            ->where('year', now()->year)
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
            ->with('approvedBy')->paginate($this->perPage);

        return view('livewire.staff.leave', [
            'leaveBalance' => $leaveBalance,
            'leaveRequests' => $leaveRequests,
        ])->layout('layouts.staff', ['title' => 'Leave Management']);
    }

    // For Main Leave Page
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // For Table
    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'typeFilter', 'dateFilter']);
    }

    public function cancelLeave($leaveId)
    {
        $leave = LeaveRequest::where('user_id', auth()->id())->findOrFail($leaveId);

        if ($leave->canBeCancelled()) {
            $leave->cancel();
            $this->dispatch('leave-cancelled', 'Leave request cancelled successfully');
        }
    }
}
