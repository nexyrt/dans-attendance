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
    public $start_date;
    public $end_date;
    
    // UI state - these are now handled by Alpine.js
    // but we keep them for potential server-side fallbacks

    protected $listeners = [
        'date-range-selected' => 'updateDateRange',
        'refresh' => '$refresh'  // Add refresh listener for Alpine.js integration
    ];

    public function mount()
    {
        // Set manager's department as default filter
        $this->departmentId = Auth::user()->department_id;
        
        // Initialize date range for filter
        $this->start_date = Carbon::now()->subMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    /**
     * Update date range from the date picker component
     */
    public function updateDateRange($data)
    {
        $this->start_date = $data['startDate'];
        $this->end_date = $data['endDate'];
    }

    /**
     * Generate PDF for the leave request
     * This needs to stay in the Livewire component for direct download
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
        $this->start_date = Carbon::now()->subMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
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
        if ($this->start_date && $this->end_date) {
            $startDate = Carbon::parse($this->start_date)->startOfDay();
            $endDate = Carbon::parse($this->end_date)->endOfDay();
            
            $query->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
            });
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