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
        $this->attendanceNote = '';
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
        // In a real implementation, this would export attendance data based on current filters
        $this->dispatch('notify', [
            'type' => 'info',
            'message' => 'Attendance data export will be ready for download shortly.'
        ]);
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
        
        // Apply department filter
        if ($this->selectedDepartment) {
            $query->whereHas('user', function ($q) {
                $q->where('department_id', Department::where('name', $this->selectedDepartment)->pluck('id'));
            });
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
    
    public function render()
    {
        $attendances = $this->getAttendances();
        $departments = Department::all()->pluck('name');
        $this->dispatch('refresh-preline');
        
        return view('livewire.director.attendances', [
            'attendances' => $attendances,
            'departments' => $departments,
            'statuses' => ['present', 'late', 'early_leave', 'holiday', 'pending present']
        ])->layout('layouts.director', ['title' => 'Attendance Management']);
    }
}