<?php

namespace App\Livewire\Staff;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Leave extends Component
{
    use WithFileUploads;

    // Form inputs
    public $type = 'annual';
    public $start_date;
    public $end_date;
    public $reason;
    public $attachment;
    public $signature;

    // UI states
    public $activeTab = 'apply';
    public $leaveRequests = [];
    public $leaveBalance;
    public $calculatedDays = 0;

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->loadLeaveRequests();
        $this->loadLeaveBalance();
    }

    public function loadLeaveRequests()
    {
        $this->leaveRequests = LeaveRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function loadLeaveBalance()
    {
        $currentYear = date('Y');
        $this->leaveBalance = LeaveBalance::where('user_id', Auth::id())
            ->where('year', $currentYear)
            ->first();
    }

    public function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $this->calculatedDays = $end->diffInDays($start) + 1; // Include both start and end days
        } else {
            $this->calculatedDays = 0;
        }
    }

    public function updatedStartDate()
    {
        $this->calculateDays();
    }

    public function updatedEndDate()
    {
        $this->calculateDays();
    }

    public function updatedActiveTab($value)
    {
        if ($value === 'history') {
            $this->loadLeaveRequests();
        } else if ($value === 'balance') {
            $this->loadLeaveBalance();
        }
    }

    public function submit()
    {
        $this->validate([
            'type' => 'required|in:sick,annual,important,other',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|min:10',
            'signature' => 'required',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ], [
            'signature.required' => 'Please sign your leave request',
            'start_date.after_or_equal' => 'Leave must start from today or a future date',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
        ]);
        
        // Check if leave balance is sufficient for annual leave
        if ($this->type === 'annual' && $this->leaveBalance) {
            if ($this->calculatedDays > $this->leaveBalance->remaining_balance) {
                session()->flash('error', 'Insufficient leave balance');
                return;
            }
        }

        try {
            // Get user info
            $user = auth()->user();
            
            // Save signature in document_path
            $image_data = base64_decode(Str::of($this->signature)->after(','));
            
            // Create a unique filename
            $filename = Str::slug("{$user->role}, {$user->name}, {$user->id}") . '.png';
            
            // Define the path where the image will be stored
            $directory = public_path('signatures');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Save the image
            file_put_contents("{$directory}/{$filename}", $image_data);
            $signature_path = 'signatures/' . $filename;
            
            // Save attachment if provided
            $attachmentPath = null;
            if ($this->attachment) {
                $attachmentPath = $this->attachment->store('leave-attachments', 'public');
            }
            
            // Create leave request
            $leaveRequest = new LeaveRequest();
            $leaveRequest->user_id = Auth::id();
            $leaveRequest->type = $this->type;
            $leaveRequest->start_date = $this->start_date;
            $leaveRequest->end_date = $this->end_date;
            $leaveRequest->reason = $this->reason;
            $leaveRequest->status = 'pending_manager';
            $leaveRequest->attachment_path = $attachmentPath;
            $leaveRequest->document_path = $signature_path; // Store signature in document_path
            $leaveRequest->save();
            
            // Reset form
            $this->reset(['type', 'reason', 'attachment', 'signature']);
            $this->start_date = Carbon::now()->format('Y-m-d');
            $this->end_date = Carbon::now()->format('Y-m-d');
            $this->calculatedDays = 0;
            
            // Update leave requests list
            $this->loadLeaveRequests();
            
            // Show success message
            session()->flash('success', 'Leave request submitted successfully');
            
            // Switch to history tab
            $this->activeTab = 'history';
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to submit leave request: ' . $e->getMessage());
        }
    }

    public function cancelLeaveRequest($id)
    {
        try {
            $leaveRequest = LeaveRequest::findOrFail($id);
            
            // Only allow cancellation if status is still pending
            if (in_array($leaveRequest->status, ['pending_manager', 'pending_hr', 'pending_director'])) {
                $leaveRequest->status = 'cancel';
                $leaveRequest->save();
                
                session()->flash('success', 'Leave request cancelled successfully');
                $this->loadLeaveRequests();
            } else {
                session()->flash('error', 'Cannot cancel this leave request');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to cancel leave request');
        }
    }

    public function render()
    {
        return view('livewire.staff.leave')->layout('layouts.staff', ['title' => 'Leave Management']);
    }
}