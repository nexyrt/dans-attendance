<?php

namespace App\Livewire\Manager;

use App\Models\User;
use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class Leave extends Component
{
    use WithFileUploads;

    public $activeTab = 'pending';
    public $showPreview = false;
    public $previewUrl = null;
    public $previewType = null;
    public $showRejectModal = false;
    public $rejectReason = '';
    public $selectedRequest = null;
    public $selectedDepartment = null;

    public function mount()
    {
        $this->selectedDepartment = auth()->user()->department_id;
    }

    public function approveRequest($requestId)
    {
        $request = LeaveRequest::findOrFail($requestId);
        
        if ($request->status !== LeaveRequest::STATUS_PENDING_MANAGER) {
            session()->flash('error', 'This request cannot be approved at this time.');
            return;
        }

        DB::transaction(function () use ($request) {
            $request->update([
                'status' => LeaveRequest::STATUS_PENDING_HR,
                'manager_id' => auth()->id(),
                'manager_approved_at' => now(),
            ]);
        });

        session()->flash('message', 'Leave request approved successfully.');
    }

    public function showRejectModal($requestId)
    {
        $this->selectedRequest = LeaveRequest::findOrFail($requestId);
        $this->showRejectModal = true;
        dump($this->showRejectModal);
    }

    public function rejectRequest()
    {
        $this->validate([
            'rejectReason' => 'required|min:10',
        ]);

        if (!$this->selectedRequest) {
            return;
        }

        DB::transaction(function () {
            $this->selectedRequest->update([
                'status' => LeaveRequest::STATUS_REJECTED_MANAGER,
                'manager_id' => auth()->id(),
                'manager_approved_at' => now(),
                'rejection_reason' => $this->rejectReason
            ]);
        });

        $this->selectedRequest = null;
        $this->rejectReason = '';
        $this->showRejectModal = false;
        
        session()->flash('message', 'Leave request rejected successfully.');
    }

    public function previewAttachment($requestId)
    {
        $request = LeaveRequest::findOrFail($requestId);
        if ($request->attachment_path) {
            $this->previewUrl = asset($request->attachment_path);
            $this->previewType = strtolower(pathinfo($request->attachment_path, PATHINFO_EXTENSION));
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
        return LeaveRequest::query()
            ->where('user_id', '!=', auth()->id())
            ->whereHas('user', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            })
            ->when($this->activeTab === 'pending', function($query) {
                $query->where('status', LeaveRequest::STATUS_PENDING_MANAGER);
            })
            ->when($this->activeTab === 'approved', function($query) {
                $query->whereIn('status', [
                    LeaveRequest::STATUS_PENDING_HR,
                    LeaveRequest::STATUS_PENDING_DIRECTOR,
                    LeaveRequest::STATUS_APPROVED
                ]);
            })
            ->when($this->activeTab === 'rejected', function($query) {
                $query->where('status', LeaveRequest::STATUS_REJECTED_MANAGER);
            })
            ->with(['user' => function($query) {
                $query->with(['department']);
            }])
            ->latest()
            ->get()
            ->map(function($request) {
                // Get current leave balance for the user
                $leaveBalance = $request->user->leaveBalances()
                    ->where('year', now()->year)
                    ->first();
                
                // Add leave balance to the user object
                $request->user->currentLeaveBalance = $leaveBalance;
                
                return $request;
            });
    }

    public function getTeamLeaveBalancesProperty()
    {
        $users = User::where('department_id', $this->selectedDepartment)
            ->where('id', '!=', auth()->id())
            ->with(['leaveRequests' => function($query) {
                $query->whereYear('created_at', now()->year);
            }])
            ->get();

        // Manually load leave balances
        foreach($users as $user) {
            $user->currentLeaveBalance = $user->leaveBalances()
                ->where('year', now()->year)
                ->first();
        }

        return $users;
    }

    public function getPendingCountProperty()
    {
        return $this->getDepartmentRequestsCount(LeaveRequest::STATUS_PENDING_MANAGER);
    }

    public function getApprovedCountProperty()
    {
        return $this->getDepartmentRequestsCount([
            LeaveRequest::STATUS_PENDING_HR,
            LeaveRequest::STATUS_PENDING_DIRECTOR,
            LeaveRequest::STATUS_APPROVED
        ]);
    }

    public function getRejectedCountProperty()
    {
        return $this->getDepartmentRequestsCount(LeaveRequest::STATUS_REJECTED_MANAGER);
    }

    protected function getDepartmentRequestsCount($status)
    {
        return LeaveRequest::query()
            ->where('user_id', '!=', auth()->id())
            ->whereHas('user', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            })
            ->when(is_array($status), function($query) use ($status) {
                $query->whereIn('status', $status);
            }, function($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }

    public function render()
    {
        return view('livewire.manager.leave', [
            'leaveRequests' => $this->leaveRequests,
            'teamBalances' => $this->teamLeaveBalances,
        ])->layout('layouts.manager', ['title' => 'Leave Management']);
    }
}