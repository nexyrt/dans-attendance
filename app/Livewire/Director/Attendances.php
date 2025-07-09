<?php

namespace App\Livewire\Director;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Session;

class Attendances extends Component
{
    use WithPagination;
    
    // Filters
    public $selectedDepartment = '';
    public $selectedStatus = '';
    public $startDate = '';
    public $endDate = '';
    public $searchTerm = '';
    
    // Selected attendance for details modal
    public $selectedAttendance = null;
    
    // For note addition
    public $attendanceNote = '';
    public $selectedAttendanceId = null;
    
    protected $queryString = [
        'selectedDepartment' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'searchTerm' => ['except' => ''],
    ];
    
    protected $listeners = [
        'date-range-selected' => 'updateDateRange'
    ];
    
    protected $rules = [
        'attendanceNote' => 'required|min:3',
    ];
    
    public function mount()
    {
        // Initialize with current date as default
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }
    
    public function updateDateRange($dateRange)
    {
        $this->startDate = $dateRange['startDate'];
        $this->endDate = $dateRange['endDate'];
        $this->resetPage();
    }
    
    public function updatedSelectedDepartment()
    {
        $this->resetPage();
    }
    
    public function updatedSelectedStatus()
    {
        $this->resetPage();
    }
    
    public function updatedSearchTerm()
    {
        $this->resetPage();
    }
    
    public function viewAttendanceDetails($attendanceId)
    {
        $this->selectedAttendance = Attendance::with(['user', 'user.department', 'checkInOffice', 'checkOutOffice'])
            ->find($attendanceId);
            
        $this->dispatch('open-modal', 'attendance-details');
    }
    
    public function openAddNoteModal($attendanceId)
    {
        $this->selectedAttendanceId = $attendanceId;
        
        // Get the current note content if editing
        $attendance = Attendance::find($attendanceId);
        $this->attendanceNote = $attendance && $attendance->notes ? $attendance->notes : '';
        
        $this->dispatch('open-modal', 'add-note-modal');
    }
    
    public function addNote()
    {
        $this->validate([
            'attendanceNote' => 'required|min:3',
        ]);
        
        $attendance = Attendance::find($this->selectedAttendanceId);
        
        if (!$attendance) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Attendance record not found'
            ]);
            return;
        }
        
        $attendance->update([
            'notes' => $this->attendanceNote
        ]);
        
        $this->dispatch('close-modal', 'add-note-modal');
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Note added successfully'
        ]);
        
        // Refresh the selected attendance if viewing details
        if ($this->selectedAttendance && $this->selectedAttendance->id === $this->selectedAttendanceId) {
            $this->selectedAttendance = Attendance::with(['user', 'user.department', 'checkInOffice', 'checkOutOffice'])
                ->find($this->selectedAttendanceId);
        }

        Session::flash('message', 'Berhasil menambahkan notes!');
        
        $this->reset(['attendanceNote', 'selectedAttendanceId']);
    }
    
    public function approveAttendance($attendanceId)
    {
        $attendance = Attendance::find($attendanceId);
        
        if (!$attendance) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Attendance record not found'
            ]);
            return;
        }
        
        if ($attendance->status !== 'pending present') {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'This attendance record is not pending approval'
            ]);
            return;
        }
        
        $attendance->update([
            'status' => 'present'
        ]);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Attendance approved successfully'
        ]);
        
        // Close the modal if it was open
        if ($this->selectedAttendance && $this->selectedAttendance->id === $attendanceId) {
            $this->dispatch('close-modal', 'attendance-details');
            $this->selectedAttendance = null;
        }
    }
    
    public function export()
    {
        try {
            // Generate filename based on current filters
            $filename = 'attendance-report-' . now()->format('Y-m-d-H-i-s');
            
            // Add filter info to filename
            if ($this->selectedDepartment) {
                $filename .= '-' . \Str::slug($this->selectedDepartment);
            }
            if ($this->selectedStatus) {
                $filename .= '-' . \Str::slug($this->selectedStatus);
            }
            if ($this->startDate && $this->endDate) {
                $filename .= '-' . $this->startDate . '-to-' . $this->endDate;
            }
            
            $filename .= '.xlsx';

            // Use Director AttendanceExport with all current filters
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\Director\AttendanceExport(
                    $this->startDate ?: now()->format('Y-m-d'), 
                    $this->endDate ?: now()->format('Y-m-d'), 
                    $this->selectedDepartment ?: '',
                    $this->selectedStatus ?: '',
                    $this->searchTerm ?: ''
                ), 
                $filename
            );

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Export failed: ' . $e->getMessage()
            ]);
            
            // Log the error for debugging
            \Log::error('Attendance export failed: ' . $e->getMessage(), [
                'filters' => [
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                    'selectedDepartment' => $this->selectedDepartment,
                    'selectedStatus' => $this->selectedStatus,
                    'searchTerm' => $this->searchTerm,
                ],
                'user_id' => auth()->id()
            ]);
        }
    }
    
    public function clearFilters()
    {
        $this->selectedDepartment = '';
        $this->selectedStatus = '';
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->searchTerm = '';
        $this->resetPage();
    }
    
    private function getAttendances()
    {
        $query = Attendance::with(['user', 'user.department'])
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc');
        
        // Apply date filter - now using date range
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->where('date', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->where('date', '<=', $this->endDate);
        }
        
        // Apply department filter - FIXED
        if ($this->selectedDepartment) {
            $departmentId = Department::where('name', $this->selectedDepartment)->value('id');
            if ($departmentId) {
                $query->whereHas('user', function ($q) use ($departmentId) {
                    $q->where('department_id', $departmentId);
                });
            }
        }
        
        // Apply status filter
        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);
        }
        
        // Apply search term
        if ($this->searchTerm) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        return $query->paginate(10);
    }
    
    // Helper method to get dashboard statistics
    private function getDashboardStats()
    {
        $today = now()->format('Y-m-d');
        
        $todayCheckInsCount = Attendance::whereDate('date', $today)
            ->whereNotNull('check_in')
            ->count();
            
        $presentCount = Attendance::whereDate('date', $today)
            ->where('status', 'present')
            ->count();
            
        $lateCount = Attendance::whereDate('date', $today)
            ->where('status', 'late')
            ->count();
            
        $pendingApprovalCount = Attendance::where('status', 'pending present')
            ->count();
            
        return compact('todayCheckInsCount', 'presentCount', 'lateCount', 'pendingApprovalCount');
    }
    
    public function render()
    {
        $attendances = $this->getAttendances();
        $departments = Department::all()->pluck('name');
        $dashboardStats = $this->getDashboardStats();
        
        $this->dispatch('refresh-preline');
        
        return view('livewire.director.attendances', array_merge([
            'attendances' => $attendances,
            'departments' => $departments,
            'statuses' => ['present', 'late', 'early_leave', 'holiday', 'pending present']
        ], $dashboardStats))->layout('layouts.director', ['title' => 'Attendance Management']);
    }
}