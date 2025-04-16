<?php

namespace App\Livewire\Staff;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Leave extends Component
{
    use WithFileUploads;

    // Form inputs
    public $type;
    public $start_date;
    public $end_date;
    public $reason;
    public $attachment;
    public $signature;

    // UI states
    public $leaveRequests = [];
    public $leaveBalance;
    public $calculatedDays = 0;
    public $dateOverlapError = null;

    protected $listeners = [
        'date-range-selected' => 'updateDateRange'
    ];

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->loadData();
    }
    
    /**
     * Load all necessary data at once
     */
    private function loadData()
    {
        $this->loadLeaveRequests();
        $this->loadLeaveBalance();
        $this->calculateDays();
    }

    public function generatePdf($leaveId)
    {
        $leave = LeaveRequest::with([
            'user', 
            'user.department'
        ])
        ->findOrFail($leaveId);

        // Check if user has permission to generate this PDF
        if ($leave->user_id !== Auth::id()) {
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
        
        // Don't set margins here as we're using CSS @page margins
        
        // Generate a filename with user information
        $filename = 'leave_request_' . $leaveId . '_' . Str::slug($leave->user->name) . '.pdf';

        // Return the PDF as download
        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
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

    /**
     * Update date range from the date picker component
     */
    public function updateDateRange($data)
    {
        $this->start_date = $data['startDate'];
        $this->end_date = $data['endDate'];
        $this->calculateDays();
        
        // Check for overlapping dates and provide feedback immediately
        $this->dateOverlapError = null; // Reset previous error
        $overlapping = $this->checkDateOverlap();
        
        if ($overlapping) {
            $statusMap = [
                'pending_manager' => 'pending manager approval',
                'pending_hr' => 'pending HR approval',
                'pending_director' => 'pending director approval',
                'approved' => 'approved',
            ];
            
            $status = $statusMap[$overlapping['status']] ?? $overlapping['status'];
            $this->dateOverlapError = "Selected dates overlap with an existing leave request ({$overlapping['start']} to {$overlapping['end']}) that is {$status}";
        }
    }

    public function calculateDays()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        
        // Initialize counter for working days
        $workingDays = 0;
        
        // Count only weekdays
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (!in_array($date->dayOfWeek, [0, 6])) { // Skip Saturday (6) and Sunday (0)
                $workingDays++;
            }
        }
        
        $this->calculatedDays = $workingDays;
    }

    /**
     * Check if the selected dates overlap with existing leave requests
     * 
     * @return bool|array Returns false if no overlap, or an array with overlapping request details
     */
    protected function checkDateOverlap()
    {
        $userId = Auth::id();
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        
        // Get any approved or pending leave requests that might overlap
        $overlappingRequests = LeaveRequest::where('user_id', $userId)
            ->whereIn('status', ['approved', 'pending_manager', 'pending_hr', 'pending_director'])
            ->where(function($query) use ($start, $end) {
                // Check for any overlap: (StartA <= EndB) and (EndA >= StartB)
                $query->where('start_date', '<=', $end->format('Y-m-d'))
                      ->where('end_date', '>=', $start->format('Y-m-d'));
            })
            ->first();
        
        if ($overlappingRequests) {
            return [
                'start' => Carbon::parse($overlappingRequests->start_date)->format('M d, Y'),
                'end' => Carbon::parse($overlappingRequests->end_date)->format('M d, Y'),
                'status' => $overlappingRequests->status,
            ];
        }
        
        return false;
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

        // Check for overlapping dates
        $overlapping = $this->checkDateOverlap();
        if ($overlapping) {
            $statusMap = [
                'pending_manager' => 'pending manager approval',
                'pending_hr' => 'pending HR approval',
                'pending_director' => 'pending director approval',
                'approved' => 'approved',
            ];
            
            $status = $statusMap[$overlapping['status']] ?? $overlapping['status'];
            
            session()->flash('error', "Your selected dates overlap with an existing leave request ({$overlapping['start']} to {$overlapping['end']}) that is {$status}.");
            return;
        }

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

            // Save signature in document_path - ensure transparency is preserved
            $image_data = base64_decode(Str::of($this->signature)->after(','));
            $filename = Str::slug("{$user->role}, {$user->name}, {$user->id}") . '.png';
            
            // Define the path where the image will be stored
            $directory = public_path('signatures');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Save the image with transparency preserved
            // Convert to GD image to ensure proper handling of transparency
            $img = imagecreatefromstring($image_data);
            imagesavealpha($img, true); // This preserves transparency
            imagepng($img, "{$directory}/{$filename}", 0); // Max quality to preserve transparency
            imagedestroy($img);
            
            $signature_path = 'signatures/' . $filename;

            // Save attachment if provided
            $attachmentPath = $this->attachment 
                ? $this->attachment->store('leave-attachments', 'public') 
                : null;

            // Create leave request
            LeaveRequest::create([
                'user_id' => Auth::id(),
                'type' => $this->type,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
                'status' => 'pending_manager',
                'attachment_path' => $attachmentPath,
                'document_path' => $signature_path,
            ]);

            session()->flash('message', 'Leave request submitted successfully');
            $this->dispatch('leave-submitted');

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

                session()->flash('message', 'Leave request cancelled successfully');
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