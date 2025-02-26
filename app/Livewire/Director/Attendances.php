<?php

namespace App\Livewire\Director;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\OfficeLocation;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class Attendances extends Component
{
    use WithPagination;
    
    // Filters
    public $selectedDepartment = '';
    public $selectedStatus = '';
    public $selectedDate = '';
    public $searchTerm = '';
    public $dateRange = [
        'start' => '',
        'end' => ''
    ];
    
    // View mode
    public $viewMode = 'dashboard'; // dashboard, list
    
    // Selected attendance for details modal
    public $selectedAttendance = null;
    
    // For note addition modal
    public $attendanceNote = '';
    public $selectedAttendanceId = null;
    
    // For ApexCharts
    public $chartData = [];
    public $departmentChartData = [];
    public $weeklyChartData = [];
    public $lateHoursChartData = [];
    
    // For custom report
    public $customReport = [
        'title' => '',
        'startDate' => '',
        'endDate' => '',
        'departmentId' => '',
        'format' => 'pdf',
        'delivery' => 'email',
        'includeDetails' => true,
    ];
    
    protected $queryString = [
        'selectedDepartment' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
        'selectedDate' => ['except' => ''],
        'searchTerm' => ['except' => ''],
        'viewMode' => ['except' => 'dashboard'],
    ];
    
    protected $rules = [
        'attendanceNote' => 'required|min:3',
        'customReport.title' => 'required|string|min:3',
        'customReport.startDate' => 'required|date',
        'customReport.endDate' => 'required|date|after_or_equal:customReport.startDate',
    ];
    
    public function mount()
    {
        // Initialize with today's date
        $this->selectedDate = Carbon::today()->format('Y-m-d');
        $this->dateRange['start'] = Carbon::today()->subDays(6)->format('Y-m-d');
        $this->dateRange['end'] = Carbon::today()->format('Y-m-d');
        
        $this->loadChartData();
    }
    
    public function updatedSelectedDepartment()
    {
        $this->resetPage();
        $this->loadChartData();
    }
    
    public function updatedSelectedStatus()
    {
        $this->resetPage();
    }
    
    public function updatedSelectedDate()
    {
        $this->resetPage();
        $this->loadChartData();
    }
    
    public function updatedDateRange()
    {
        $this->loadChartData();
    }
    
    public function updatedSearchTerm()
    {
        $this->resetPage();
    }
    
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'dashboard' ? 'list' : 'dashboard';
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
        
        $this->loadChartData();
    }
    
    public function openCustomReportModal()
    {
        $this->customReport = [
            'title' => 'Attendance Report - ' . now()->format('F Y'),
            'startDate' => $this->dateRange['start'],
            'endDate' => $this->dateRange['end'],
            'departmentId' => $this->selectedDepartment,
            'format' => 'pdf',
            'delivery' => 'email',
            'includeDetails' => true,
        ];
        
        $this->dispatch('open-modal', 'custom-report-modal');
    }
    
    public function generateCustomReport()
    {
        $this->validate([
            'customReport.title' => 'required|string|min:3',
            'customReport.startDate' => 'required|date',
            'customReport.endDate' => 'required|date|after_or_equal:customReport.startDate',
        ]);
        
        // In a real implementation, this would generate and send the report
        // For now, we'll just show a notification
        
        $departmentName = 'All Departments';
        
        if ($this->customReport['departmentId']) {
            $department = Department::find($this->customReport['departmentId']);
            $departmentName = $department ? $department->name : 'Unknown Department';
        }
        
        $this->dispatch('close-modal', 'custom-report-modal');
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Report '{$this->customReport['title']}' for {$departmentName} has been generated and will be delivered to your email."
        ]);
    }
    
    public function export()
    {
        // Logic for exporting data would go here
        // For now, we'll just show a notification
        $this->dispatch('notify', [
            'type' => 'info',
            'message' => 'Export functionality will be implemented soon.'
        ]);
    }
    
    private function loadChartData()
    {
        $this->loadAttendanceStatusChart();
        $this->loadDepartmentComparisonChart();
        $this->loadWeeklyTrendChart();
        $this->loadLateHoursChart();
    }
    
    private function loadAttendanceStatusChart()
    {
        $date = Carbon::parse($this->selectedDate);
        
        // Count total employees
        $usersQuery = User::query();
        if ($this->selectedDepartment) {
            $usersQuery->where('department_id', $this->selectedDepartment);
        }
        $totalEmployees = $usersQuery->count();
        
        // Get attendance data for the selected date
        $attendanceQuery = Attendance::where('date', $date);
        if ($this->selectedDepartment) {
            $attendanceQuery->whereHas('user', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            });
        }
        
        $attendances = $attendanceQuery->get();
        
        $present = $attendances->where('status', 'present')->count();
        $late = $attendances->where('status', 'late')->count();
        $earlyLeave = $attendances->where('status', 'early_leave')->count();
        $pendingPresent = $attendances->where('status', 'pending present')->count();
        $absent = $totalEmployees - $attendances->count();
        
        $this->chartData = [
            'series' => [$present, $late, $earlyLeave, $pendingPresent, $absent],
            'labels' => ['Present', 'Late', 'Early Leave', 'Pending', 'Absent'],
            'colors' => ['#10B981', '#F59E0B', '#EF4444', '#6366F1', '#9CA3AF'],
            'totalEmployees' => $totalEmployees,
            'stats' => [
                'present' => $present,
                'late' => $late,
                'earlyLeave' => $earlyLeave,
                'pending' => $pendingPresent,
                'absent' => $absent,
            ]
        ];
    }
    
    private function loadDepartmentComparisonChart()
    {
        $date = Carbon::parse($this->selectedDate);
        $departments = Department::all();
        
        $departmentNames = [];
        $presentData = [];
        $lateData = [];
        $absentData = [];
        
        foreach ($departments as $department) {
            $departmentNames[] = $department->name;
            
            // Total employees in department
            $totalEmployees = User::where('department_id', $department->id)->count();
            
            // Attendance data
            $attendances = Attendance::whereHas('user', function ($query) use ($department) {
                $query->where('department_id', $department->id);
            })->where('date', $date)->get();
            
            $present = $attendances->where('status', 'present')->count();
            $late = $attendances->where('status', 'late')->count();
            $absent = $totalEmployees - $attendances->count();
            
            // Calculate percentages (avoid division by zero)
            $presentData[] = $totalEmployees > 0 ? round(($present / $totalEmployees) * 100, 1) : 0;
            $lateData[] = $totalEmployees > 0 ? round(($late / $totalEmployees) * 100, 1) : 0;
            $absentData[] = $totalEmployees > 0 ? round(($absent / $totalEmployees) * 100, 1) : 0;
        }
        
        $this->departmentChartData = [
            'categories' => $departmentNames,
            'series' => [
                [
                    'name' => 'Present',
                    'data' => $presentData,
                ],
                [
                    'name' => 'Late',
                    'data' => $lateData,
                ],
                [
                    'name' => 'Absent',
                    'data' => $absentData,
                ],
            ],
        ];
    }
    
    private function loadWeeklyTrendChart()
    {
        $startDate = Carbon::parse($this->dateRange['start']);
        $endDate = Carbon::parse($this->dateRange['end']);
        
        $dateRange = CarbonPeriod::create($startDate, $endDate);
        $dates = [];
        $presentData = [];
        $lateData = [];
        $earlyLeaveData = [];
        $absentData = [];
        
        foreach ($dateRange as $date) {
            $dates[] = $date->format('M d');
            
            $usersQuery = User::query();
            if ($this->selectedDepartment) {
                $usersQuery->where('department_id', $this->selectedDepartment);
            }
            $totalEmployees = $usersQuery->count();
            
            $attendanceQuery = Attendance::where('date', $date->format('Y-m-d'));
            if ($this->selectedDepartment) {
                $attendanceQuery->whereHas('user', function ($query) {
                    $query->where('department_id', $this->selectedDepartment);
                });
            }
            
            $attendances = $attendanceQuery->get();
            
            $present = $attendances->where('status', 'present')->count();
            $late = $attendances->where('status', 'late')->count();
            $earlyLeave = $attendances->where('status', 'early_leave')->count();
            $totalAttendances = $present + $late + $earlyLeave;
            $absent = $totalEmployees - $totalAttendances;
            
            $presentData[] = $present;
            $lateData[] = $late;
            $earlyLeaveData[] = $earlyLeave;
            $absentData[] = $absent;
        }
        
        $this->weeklyChartData = [
            'categories' => $dates,
            'series' => [
                [
                    'name' => 'Present',
                    'data' => $presentData,
                ],
                [
                    'name' => 'Late',
                    'data' => $lateData,
                ],
                [
                    'name' => 'Early Leave',
                    'data' => $earlyLeaveData,
                ],
                [
                    'name' => 'Absent',
                    'data' => $absentData,
                ],
            ],
        ];
    }
    
    private function loadLateHoursChart()
    {
        $startDate = Carbon::parse($this->dateRange['start']);
        $endDate = Carbon::parse($this->dateRange['end']);
        
        $query = DB::table('attendances')
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->select(
                DB::raw('DATE(attendances.date) as date'),
                DB::raw('SUM(CASE WHEN attendances.late_hours IS NOT NULL THEN attendances.late_hours ELSE 0 END) as total_late_hours')
            )
            ->whereBetween('attendances.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            
        if ($this->selectedDepartment) {
            $query->where('users.department_id', $this->selectedDepartment);
        }
        
        $lateHoursData = $query->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $dates = [];
        $lateHours = [];
        
        $dateRange = CarbonPeriod::create($startDate, $endDate);
        foreach ($dateRange as $date) {
            $dates[] = $date->format('M d');
            
            $dateData = $lateHoursData->where('date', $date->format('Y-m-d'))->first();
            $lateHours[] = $dateData ? (float) $dateData->total_late_hours : 0;
        }
        
        $this->lateHoursChartData = [
            'categories' => $dates,
            'series' => [
                [
                    'name' => 'Late Hours',
                    'data' => $lateHours,
                ],
            ],
        ];
    }
    
    private function getAttendances()
    {
        $query = Attendance::with(['user', 'user.department'])
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc');
        
        // Apply date filter
        if ($this->selectedDate) {
            $query->where('date', $this->selectedDate);
        }
        
        // Apply department filter
        if ($this->selectedDepartment) {
            $query->whereHas('user', function ($q) {
                $q->where('department_id', $this->selectedDepartment);
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

    /**
     * Get pending attendance approvals
     */
    private function getPendingApprovals()
    {
        $query = Attendance::with(['user', 'user.department'])
            ->where('status', 'pending present')
            ->orderBy('date', 'desc');
            
        if ($this->selectedDepartment) {
            $query->whereHas('user', function ($q) {
                $q->where('department_id', $this->selectedDepartment);
            });
        }
            
        return $query->take(5)->get();
    }
    
    public function render()
    {
        $attendances = $this->getAttendances();
        $pendingApprovals = $this->getPendingApprovals();
        $departments = Department::all();
        
        return view('livewire.director.attendances', [
            'attendances' => $attendances,
            'pendingApprovals' => $pendingApprovals,
            'departments' => $departments,
            'statuses' => ['present', 'late', 'early_leave', 'holiday', 'pending present']
        ])->layout('layouts.director', ['title' => 'Attendance Management']);
    }
}