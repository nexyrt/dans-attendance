<?php

namespace App\Livewire\Manager;

use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Leave extends Component
{
    use WithPagination;
    
    public $search = '';
    public $typeFilter = '';

    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update([
            'status' => 'pending_hr',
            'manager_id' => auth()->id(),
            'manager_approved_at' => now(),
        ]);

        session()->flash('message', 'Leave request approved successfully.');
    }

    public function reject($id, $reason = '')
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update([
            'status' => 'rejected_manager',
            'manager_id' => auth()->id(),
            'rejection_reason' => $reason,
        ]);

        session()->flash('message', 'Leave request rejected.');
    }

    public function render()
    {
        $pendingRequests = LeaveRequest::where('status', 'pending_manager')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('reason', 'like', '%' . $this->search . '%');
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->with(['user', 'user.department'])
            ->latest()
            ->paginate(10);

        return view('livewire.manager.leave', [
            'pendingRequests' => $pendingRequests
        ])->layout('layouts.manager', ['title' => 'Leave Management']);
    }
}