<?php

namespace App\Livewire\Manager;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Leave extends Component
{
    use WithPagination;
    
    // Filter variables
    public $status = '';
    public $departmentId = '';
    public $searchTerm = '';
    public $dateRange = '';
    
    // Signature variables
    public $signature;
    public $currentLeaveId;
    
    // UI state
    public $isModalOpen = false;
    public $rejectionReason = '';
    public $actionType = '';

    public function mount()
    {
        // Set manager's department as default filter
        $this->departmentId = Auth::user()->department_id;
    }
    
    /**
     * Opens approval modal for the selected leave request
     */
    public function openApprovalModal($leaveId)
    {
        $this->currentLeaveId = $leaveId;
        $this->actionType = 'approve';
        $this->signature = null;
        $this->isModalOpen = true;
    }
    
    /**
     * Opens rejection modal for the selected leave request
     */
    public function openRejectionModal($leaveId)
    {
        $this->currentLeaveId = $leaveId;
        $this->actionType = 'reject';
        $this->rejectionReason = '';
        $this->isModalOpen = true;
    }
    
    /**
     * Close modal and reset all form fields
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->currentLeaveId = null;
        $this->signature = null;
        $this->rejectionReason = '';
        $this->actionType = '';
    }

    /**
     * Approve the leave request with manager's signature
     */
    public function approveLeave()
    {
        // Validate signature
        $this->validate([
            'signature' => 'required',
        ], [
            'signature.required' => 'Your signature is required to approve this leave request',
        ]);

        try {
            $leaveRequest = LeaveRequest::findOrFail($this->currentLeaveId);
            
            // Check if this user is authorized to approve (must be manager of the employee's department)
            $employee = User::findOrFail($leaveRequest->user_id);
            $manager = Auth::user();
            
            if ($employee->department_id != $manager->department_id) {
                session()->flash('error', 'You are not authorized to approve leaves for employees outside your department');
                $this->closeModal();
                return;
            }
            
            // Save manager's signature
            $image_data = base64_decode(Str::of($this->signature)->after(','));
            $filename = Str::slug("manager, {$manager->name}, {$manager->id}") . '.png';
            
            // Define the path where the image will be stored
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
            $leaveRequest->status = 'pending_hr';
            $leaveRequest->manager_id = $manager->id;
            $leaveRequest->manager_approved_at = now();
            $leaveRequest->manager_signature = $signature_path;
            $leaveRequest->save();
            
            session()->flash('message', 'Leave request approved successfully. It has been forwarded to HR for review.');
            $this->closeModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to approve leave request: ' . $e->getMessage());
            $this->closeModal();
        }
    }
    
    /**
     * Reject the leave request with reason
     */
    public function rejectLeave()
    {
        // Validate rejection reason
        $this->validate([
            'rejectionReason' => 'required|min:5',
        ], [
            'rejectionReason.required' => 'Please provide a reason for rejection',
            'rejectionReason.min' => 'Rejection reason must be at least 5 characters',
        ]);

        try {
            $leaveRequest = LeaveRequest::findOrFail($this->currentLeaveId);
            
            // Check if this user is authorized to reject (must be manager of the employee's department)
            $employee = User::findOrFail($leaveRequest->user_id);
            $manager = Auth::user();
            
            if ($employee->department_id != $manager->department_id) {
                session()->flash('error', 'You are not authorized to reject leaves for employees outside your department');
                $this->closeModal();
                return;
            }
            
            // Update leave request
            $leaveRequest->status = 'rejected_manager';
            $leaveRequest->manager_id = $manager->id;
            $leaveRequest->rejection_reason = $this->rejectionReason;
            $leaveRequest->save();
            
            session()->flash('message', 'Leave request has been rejected');
            $this->closeModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reject leave request: ' . $e->getMessage());
            $this->closeModal();
        }
    }
    
    /**
     * Generate PDF for the leave request
     */
    public function generatePdf($leaveId)
    {
        $leave = LeaveRequest::with([
            'user', 
            'user.department',
            'manager',
            'hr',
            'director'
        ])
        ->findOrFail($leaveId);

        // Check if user has permission to generate this PDF (must be manager of the department)
        $manager = Auth::user();
        if ($leave->user->department_id !== $manager->department_id) {
            session()->flash('error', 'You do not have permission to access this document');
            return;
        }

        $pdf = Pdf::loadView('livewire.staff.leave-pdf', [
            'leave' => $leave
        ]);

        // Set paper size to A4
        $pdf->setPaper('a4', 'portrait');
        
        // Configure PDF settings for better quality with proper margins
        $pdf->setOption('dpi', 300);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        
        // Generate a filename with user information
        $filename = 'leave_request_' . $leaveId . '_' . Str::slug($leave->user->name) . '.pdf';

        // Return the PDF as download
        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
    }

    /**
     * Reset all filters
     */
    public function resetFilters()
    {
        $this->status = '';
        $this->searchTerm = '';
        $this->dateRange = '';
        $this->resetPage();
    }
    
    /**
     * Get the leave requests for manager's department
     */
    public function getLeaveRequestsProperty()
    {
        $manager = Auth::user();
        
        // Base query - only show requests from manager's department
        $query = LeaveRequest::with(['user', 'user.department'])
            ->whereHas('user', function($q) use ($manager) {
                $q->where('department_id', $manager->department_id);
            })
            ->orderBy('created_at', 'desc');
        
        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        // Apply search filter
        if ($this->searchTerm) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        // Apply date range filter
        if ($this->dateRange) {
            $dates = explode(' to ', $this->dateRange);
            if (count($dates) == 2) {
                $startDate = Carbon::parse($dates[0])->startOfDay();
                $endDate = Carbon::parse($dates[1])->endOfDay();
                
                $query->where(function($q) use ($startDate, $endDate) {
                    $q->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
                });
            }
        }
        
        return $query->paginate(10);
    }

    public function render()
    {
        return view('livewire.manager.leave', [
            'leaveRequests' => $this->leaveRequests,
        ])->layout('layouts.manager', ['title' => 'Leave Approval']);
    }
}