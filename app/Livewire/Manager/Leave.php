<?php

namespace App\Livewire\Manager;

use App\Models\LeaveRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\Component;

class Leave extends Component
{
    // Leave data
    public $leaveRequests = [];
    public $selectedLeave = null;
    public $signature = null;
    public $rejectionReason = '';
    public $rejectId = null;
    
    // UI states
    public $filter = 'pending';
    public $searchQuery = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    protected $listeners = ['refreshLeaveRequests' => '$refresh'];
    
    protected $rules = [
        'signature' => 'required',
        'rejectionReason' => 'required_if:rejectId,!=,null|min:10'
    ];
    
    protected $messages = [
        'signature.required' => 'Your signature is required to approve this leave request',
        'rejectionReason.required_if' => 'You must provide a reason for rejecting this request',
        'rejectionReason.min' => 'The rejection reason must be at least 10 characters'
    ];

    public function mount()
    {
        $this->loadLeaveRequests();
    }
    
    public function loadLeaveRequests()
    {
        $user = Auth::user();
        $query = LeaveRequest::query()
            ->with(['user', 'user.department'])
            ->whereHas('user.department', function($query) use ($user) {
                // Filter by departments where the current user is the manager
                $query->where('manager_id', $user->id);
            });
        
        // Apply active filter
        switch($this->filter) {
            case 'pending':
                $query->where('status', 'pending_manager');
                break;
            case 'approved':
                $query->where('status', 'approved')
                    ->orWhere('status', 'pending_hr')
                    ->orWhere('status', 'pending_director');
                break;
            case 'rejected':
                $query->where('status', 'rejected_manager');
                break;
            case 'all':
                // No additional filtering
                break;
        }
        
        // Apply search if provided
        if ($this->searchQuery) {
            $query->whereHas('user', function($subquery) {
                $subquery->where('name', 'like', "%{$this->searchQuery}%");
            })->orWhere('id', 'like', "%{$this->searchQuery}%");
        }
        
        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);
        
        $this->leaveRequests = $query->get();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        
        $this->loadLeaveRequests();
    }
    
    public function updateFilter($filter) 
    {
        $this->filter = $filter;
        $this->loadLeaveRequests();
    }
    
    public function viewLeave($id)
    {
        $this->selectedLeave = LeaveRequest::with(['user', 'user.department'])->findOrFail($id);
        $this->dispatch('open-modal', 'view-leave-modal');
    }
    
    public function prepareForRejection($id)
    {
        $this->rejectId = $id;
        $this->rejectionReason = '';
        $this->dispatch('open-modal', 'reject-leave-modal');
    }
    
    public function approveLeave()
    {
        if (!$this->selectedLeave) {
            return;
        }
        
        $this->validate([
            'signature' => 'required',
        ]);
        
        try {
            // Save signature
            $user = auth()->user();
            $image_data = base64_decode(Str::of($this->signature)->after(','));
            $filename = 'manager_' . Str::slug("{$user->role}, {$user->name}, {$user->id}") . '.png';
            
            // Create directory if it doesn't exist
            $directory = public_path('signatures');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Save the image with transparency preserved
            $img = imagecreatefromstring($image_data);
            imagesavealpha($img, true);
            imagepng($img, "{$directory}/{$filename}", 0);
            imagedestroy($img);
            
            $signature_path = 'signatures/' . $filename;
            
            // Update leave request
            $leave = LeaveRequest::findOrFail($this->selectedLeave->id);
            $leave->status = 'pending_hr';
            $leave->manager_id = Auth::id();
            $leave->manager_approved_at = Carbon::now();
            $leave->manager_signature = $signature_path;
            $leave->save();
            
            $this->dispatch('close-modal', 'view-leave-modal');
            $this->dispatch('leave-approved');
            session()->flash('message', 'Leave request has been approved successfully');
            
            $this->loadLeaveRequests();
            $this->selectedLeave = null;
            $this->signature = null;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to approve leave request: ' . $e->getMessage());
        }
    }
    
    public function rejectLeave()
    {
        $this->validate([
            'rejectionReason' => 'required|min:10',
        ]);
        
        try {
            $leave = LeaveRequest::findOrFail($this->rejectId);
            $leave->status = 'rejected_manager';
            $leave->rejection_reason = $this->rejectionReason;
            $leave->manager_id = Auth::id();
            $leave->manager_approved_at = Carbon::now();
            $leave->save();
            
            $this->dispatch('close-modal', 'reject-leave-modal');
            session()->flash('message', 'Leave request has been rejected');
            
            $this->loadLeaveRequests();
            $this->rejectId = null;
            $this->rejectionReason = '';
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reject leave request: ' . $e->getMessage());
        }
    }
    
    public function cancelViewLeave()
    {
        $this->selectedLeave = null;
        $this->signature = null;
        $this->dispatch('close-modal', 'view-leave-modal');
    }
    
    public function cancelRejection()
    {
        $this->rejectId = null;
        $this->rejectionReason = '';
        $this->dispatch('close-modal', 'reject-leave-modal');
    }
    
    public function search()
    {
        $this->loadLeaveRequests();
    }

    public function render()
    {
        return view('livewire.manager.leave')->layout('layouts.manager', ['title' => 'Leave Management']);
    }
}