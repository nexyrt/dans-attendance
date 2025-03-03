<?php

namespace App\Livewire\Director;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedDateRange = 'this month';
    public $selectedDepartment = null;
    public $showDataLabels = true;

    // Cards animation
    public $readyToLoad = false;

    // Tab for mobile view
    public $activeTab = 'attendance';

    protected $listeners = [
        'refreshDashboard' => '$refresh'
    ];

    public function mount()
    {
        // Simulate loading time for animations
        $this->readyToLoad = true;
    }

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getAttendanceStats()
    {
        if (!$this->readyToLoad) {
            return [];
        }

        $query = Attendance::query();

        if ($this->selectedDateRange === 'this month') {
            $query->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        } elseif ($this->selectedDateRange === 'last month') {
            $query->whereMonth('date', now()->subMonth()->month)
                ->whereYear('date', now()->subMonth()->year);
        } elseif ($this->selectedDateRange === 'this year') {
            $query->whereYear('date', now()->year);
        }

        if ($this->selectedDepartment) {
            $query->whereHas('user', function ($q) {
                $q->where('department_id', $this->selectedDepartment);
            });
        }

        return [
            'total_present' => $query->where('status', 'present')->count(),
            'total_late' => $query->where('status', 'late')->count(),
            'total_early_leave' => $query->where('status', 'early_leave')->count(),
            'average_working_hours' => round($query->whereNotNull('working_hours')
                ->avg('working_hours'), 1),
            'by_department' => User::select(
                'departments.name',
                \DB::raw('COUNT(attendances.id) as attendance_count')
            )
                ->join('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('attendances', 'users.id', '=', 'attendances.user_id')
                ->groupBy('departments.name')
                ->get()
        ];
    }

    public function getLeaveStats()
    {
        if (!$this->readyToLoad) {
            return [];
        }

        $query = LeaveRequest::query();

        if ($this->selectedDateRange === 'this month') {
            $query->whereMonth('start_date', now()->month)
                ->whereYear('start_date', now()->year);
        } elseif ($this->selectedDateRange === 'last month') {
            $query->whereMonth('start_date', now()->subMonth()->month)
                ->whereYear('start_date', now()->subMonth()->year);
        } elseif ($this->selectedDateRange === 'this year') {
            $query->whereYear('start_date', now()->year);
        }

        if ($this->selectedDepartment) {
            $query->whereHas('user', function ($q) {
                $q->where('department_id', $this->selectedDepartment);
            });
        }

        return [
            'pending_requests' => $query->where('status', 'pending_director')->count(),
            'approved_requests' => $query->where('status', 'approved')->count(),
            'rejected_requests' => $query->whereIn('status', [
                'rejected_manager',
                'rejected_hr',
                'rejected_director'
            ])->count(),
            'by_type' => $query->select('type', \DB::raw('count(*) as count'))
                ->groupBy('type')
                ->get(),
            'by_department' => $query->select(
                'departments.name',
                \DB::raw('COUNT(*) as leave_count')
            )
                ->join('users', 'leave_requests.user_id', '=', 'users.id')
                ->join('departments', 'users.department_id', '=', 'departments.id')
                ->groupBy('departments.name')
                ->get()
        ];
    }

    public function getStaffStats()
    {
        if (!$this->readyToLoad) {
            return [];
        }

        $query = User::query();

        if ($this->selectedDepartment) {
            $query->where('department_id', $this->selectedDepartment);
        }

        return [
            'total_employees' => $query->count(),
            'role_distribution' => $query->select('role', \DB::raw('count(*) as count'))
                ->groupBy('role')
                ->get(),
            'department_distribution' => $query->select(
                'departments.name',
                \DB::raw('COUNT(*) as employee_count'),
                \DB::raw('AVG(users.salary) as avg_salary')
            )
                ->join('departments', 'users.department_id', '=', 'departments.id')
                ->groupBy('departments.name')
                ->get(),
            'salary_ranges' => [
                'min' => $query->min('salary') ?? 0,
                'max' => $query->max('salary') ?? 0,
                'avg' => round($query->avg('salary') ?? 0, 2)
            ]
        ];
    }

    public function getCurrentMonthPerformance()
    {
        if (!$this->readyToLoad) {
            return [];
        }

        $totalUsers = User::count();
        if ($totalUsers === 0) {
            return [
                'attendance_rate' => 0,
                'leave_utilization' => 0,
                'avg_working_hours' => 0
            ];
        }

        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        if ($this->selectedDateRange === 'last month') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } elseif ($this->selectedDateRange === 'this year') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
        }

        $workingDays = Carbon::parse($startDate)->diffInDaysFiltered(function (Carbon $date) {
            return !$date->isWeekend();
        }, Carbon::parse($endDate));

        $attendanceDays = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'present')
            ->count();

        return [
            'attendance_rate' => $workingDays > 0 ? round(($attendanceDays / ($totalUsers * $workingDays)) * 100, 1) : 0,
            'leave_utilization' => LeaveRequest::whereBetween('start_date', [$startDate, $endDate])
                ->where('status', 'approved')
                ->count(),
            'avg_working_hours' => round(Attendance::whereBetween('date', [$startDate, $endDate])
                ->whereNotNull('working_hours')
                ->avg('working_hours') ?? 0, 1)
        ];
    }

    // Chart for Attendance Status
    public function getAttendanceStatusChart()
    {
        $stats = $this->getAttendanceStats();

        return (new PieChartModel())
            ->setTitle('Attendance Status')
            ->addSlice('Present', $stats['total_present'], '#10B981')
            ->addSlice('Late', $stats['total_late'], '#F59E0B')
            ->addSlice('Early Leave', $stats['total_early_leave'], '#EF4444')
            ->withDataLabels($this->showDataLabels);
    }

    // Chart for Leave Requests by Type
    public function getLeaveTypeChart()
    {
        $stats = $this->getLeaveStats();

        $chart = new PieChartModel();
        $chart->setTitle('Leave Types');

        // Check if there's data available
        $hasData = false;

        foreach ($stats['by_type'] as $type) {
            $hasData = true;
            $color = match ($type->type) {
                'sick' => '#EF4444',
                'annual' => '#3B82F6',
                'important' => '#F59E0B',
                'other' => '#6B7280',
                default => '#9333EA',
            };

            $chart->addSlice(ucfirst($type->type), $type->count, $color);
        }

        // If no data, add a placeholder
        if (!$hasData) {
            $chart->addSlice('No Data', 1, '#D1D5DB');
        }

        return $chart->withDataLabels($this->showDataLabels);
    }

    // Chart for Role Distribution
    public function getRoleDistributionChart()
    {
        $stats = $this->getStaffStats();

        $chart = new PieChartModel();
        $chart->setTitle('Role Distribution');

        foreach ($stats['role_distribution'] as $role) {
            $color = match ($role->role) {
                'admin' => '#9333EA',
                'manager' => '#3B82F6',
                'staff' => '#10B981',
                'director' => '#F59E0B',
                default => '#6B7280',
            };

            $chart->addSlice(ucfirst($role->role), $role->count, $color);
        }

        return $chart->withDataLabels($this->showDataLabels);
    }

    // Chart for Department Distribution
    public function getDepartmentDistributionChart()
    {
        $stats = $this->getStaffStats();

        $chart = new ColumnChartModel();
        $chart->setTitle('Department Distribution');

        $colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#9333EA', '#6B7280'];
        $i = 0;

        foreach ($stats['department_distribution'] as $dept) {
            $color = $colors[$i % count($colors)];
            $i++;

            $chart->addColumn($dept->name, $dept->employee_count, $color);
        }

        return $chart->withDataLabels($this->showDataLabels);
    }

    // Chart for Monthly Attendance Trend
    public function getMonthlyAttendanceTrendChart()
    {
        if ($this->selectedDateRange === 'this year') {
            $chart = new LineChartModel();
            $chart->setTitle('Monthly Attendance Trend');

            $months = [];

            // Get last 12 months
            for ($i = 11; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $months[] = [
                    'name' => $month->format('M'),
                    'date' => $month->format('Y-m')
                ];
            }

            // Get attendance data for each month
            foreach ($months as $month) {
                $query = Attendance::whereYear('date', substr($month['date'], 0, 4))
                    ->whereMonth('date', substr($month['date'], 5, 2));

                if ($this->selectedDepartment) {
                    $query->whereHas('user', function ($q) {
                        $q->where('department_id', $this->selectedDepartment);
                    });
                }

                $present = $query->where('status', 'present')->count();
                $late = $query->where('status', 'late')->count();

                $chart->addPoint($month['name'], $present, '#10B981');
                $chart->addPoint($month['name'] . ' (Late)', $late, '#F59E0B');
            }

            return $chart;
        }

        return null;
    }

    public function render()
    {
        $departments = Department::all();
        $this->dispatch('refresh-preline');
        return view('livewire.director.dashboard', [
            'departments' => $departments,
            'attendanceStats' => $this->getAttendanceStats(),
            'leaveStats' => $this->getLeaveStats(),
            'staffStats' => $this->getStaffStats(),
            'monthlyPerformance' => $this->getCurrentMonthPerformance(),
            'attendanceStatusChart' => $this->getAttendanceStatusChart(),
            'leaveTypeChart' => $this->getLeaveTypeChart(),
            'roleDistributionChart' => $this->getRoleDistributionChart(),
            'departmentDistributionChart' => $this->getDepartmentDistributionChart(),
            'monthlyAttendanceTrendChart' => $this->getMonthlyAttendanceTrendChart(),
        ])->layout('layouts.director', ['title' => 'Dashboard']);
    }
}
