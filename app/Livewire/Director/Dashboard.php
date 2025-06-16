<?php

namespace App\Livewire\Director;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedDateRange = 'today';
    public $selectedDepartment = null;

    // Real-time data properties
    public $readyToLoad = false;

    protected $listeners = [
        'refreshDashboard' => '$refresh'
    ];

    public function mount()
    {
        $this->readyToLoad = true;
    }

    public function getInOfficeStatsProperty()
    {
        if (!$this->readyToLoad) {
            return [
                'current' => 0,
                'total' => 0,
                'percentage' => 0
            ];
        }

        $today = Carbon::today();

        // Get total active employees
        $totalEmployees = User::whereNull('deleted_at')->count();

        // Get employees currently in office (checked in but not checked out today)
        $currentlyInOffice = Attendance::whereDate('date', $today)
            ->whereNotNull('check_in')
            ->whereNull('check_out')
            ->count();

        return [
            'current' => $currentlyInOffice,
            'total' => $totalEmployees,
            'percentage' => $totalEmployees > 0 ? round(($currentlyInOffice / $totalEmployees) * 100, 1) : 0
        ];
    }

    public function getPendingApprovalsProperty()
    {
        if (!$this->readyToLoad) {
            return [
                'total' => 0,
                'urgent' => 0,
                'regular' => 0
            ];
        }

        // Get leave requests pending director approval
        $pendingLeaves = LeaveRequest::where('status', LeaveRequest::STATUS_PENDING_DIRECTOR)->count();

        // Consider urgent as requests submitted more than 3 days ago
        $urgentLeaves = LeaveRequest::where('status', LeaveRequest::STATUS_PENDING_DIRECTOR)
            ->where('created_at', '<=', Carbon::now()->subDays(3))
            ->count();

        return [
            'total' => $pendingLeaves,
            'urgent' => $urgentLeaves,
            'regular' => $pendingLeaves - $urgentLeaves
        ];
    }

    public function getCompanyHealthScoreProperty()
    {
        if (!$this->readyToLoad) {
            return [
                'score' => 0,
                'rating' => 0,
                'status' => 'Loading...'
            ];
        }

        // Calculate company health based on multiple factors
        $attendanceRate = $this->getAttendanceRate();
        $leaveApprovalRate = $this->getLeaveApprovalRate();
        $productivityScore = $this->getProductivityScore();

        // Weighted average
        $healthScore = ($attendanceRate * 0.4) + ($leaveApprovalRate * 0.3) + ($productivityScore * 0.3);
        $rating = round($healthScore / 10, 1);

        $status = match (true) {
            $rating >= 8.0 => 'Excellent',
            $rating >= 7.0 => 'Good',
            $rating >= 6.0 => 'Fair',
            default => 'Needs Attention'
        };

        return [
            'score' => round($healthScore, 1),
            'rating' => $rating,
            'status' => $status
        ];
    }

    public function getTodayAttendanceProperty()
    {
        if (!$this->readyToLoad) {
            return [];
        }

        $today = Carbon::today();

        $attendances = Attendance::with(['user.department'])
            ->whereDate('date', $today)
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'user' => [
                        'name' => $attendance->user->name,
                        'position' => $this->getUserPosition($attendance->user),
                        'initials' => $this->getInitials($attendance->user->name),
                        'department' => $attendance->user->department->name ?? 'No Department'
                    ],
                    'check_in' => $attendance->check_in ? $attendance->check_in->format('H:i A') : null,
                    'check_out' => $attendance->check_out ? $attendance->check_out->format('H:i A') : null,
                    'status' => $attendance->status,
                    'working_hours' => $attendance->working_hours ? number_format($attendance->working_hours, 1) . 'h' : '0h',
                    'late_duration' => $this->getLateDuration($attendance),
                    'status_color' => $this->getStatusColor($attendance->status),
                    'department_color' => $this->getDepartmentColor($attendance->user->department->name ?? 'default')
                ];
            });

        // Add absent employees
        $presentUserIds = $attendances->pluck('user.id')->toArray();
        $absentUsers = User::with('department')
            ->whereNotIn('id', $presentUserIds)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => null,
                    'user' => [
                        'name' => $user->name,
                        'position' => $this->getUserPosition($user),
                        'initials' => $this->getInitials($user->name),
                        'department' => $user->department->name ?? 'No Department'
                    ],
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 'absent',
                    'working_hours' => '0h',
                    'late_duration' => null,
                    'status_color' => $this->getStatusColor('absent'),
                    'department_color' => $this->getDepartmentColor($user->department->name ?? 'default'),
                    'absence_reason' => $this->getAbsenceReason($user)
                ];
            });

        return $attendances->concat($absentUsers);
    }

    public function getAttendanceStatsProperty()
    {
        if (!$this->readyToLoad) {
            return [
                'total_present' => 0,
                'total_late' => 0,
                'total_absent' => 0,
                'on_time_rate' => 0,
                'avg_check_in' => '--',
                'chart_data' => [35, 7, 5, 5]
            ];
        }

        $today = Carbon::today();

        $totalPresent = Attendance::whereDate('date', $today)
            ->where('status', 'present')
            ->count();

        $totalLate = Attendance::whereDate('date', $today)
            ->where('status', 'late')
            ->count();

        $totalEmployees = User::whereNull('deleted_at')->count();
        $totalAbsent = $totalEmployees - ($totalPresent + $totalLate);

        $onTimeRate = $totalEmployees > 0 ? round((($totalPresent) / $totalEmployees) * 100, 1) : 0;

        // Calculate average check-in time
        $avgCheckIn = Attendance::whereDate('date', $today)
            ->whereNotNull('check_in')
            ->selectRaw('AVG(TIME_TO_SEC(TIME(check_in))) as avg_seconds')
            ->first();

        $avgCheckInTime = '--';
        if ($avgCheckIn && $avgCheckIn->avg_seconds) {
            $hours = floor($avgCheckIn->avg_seconds / 3600);
            $minutes = floor(($avgCheckIn->avg_seconds % 3600) / 60);
            $avgCheckInTime = sprintf('%02d:%02d', $hours, $minutes);
        }

        return [
            'total_present' => $totalPresent,
            'total_late' => $totalLate,
            'total_absent' => $totalAbsent,
            'on_time_rate' => $onTimeRate,
            'avg_check_in' => $avgCheckInTime,
            'chart_data' => [$totalPresent, $totalLate, $totalAbsent, max(0, $totalEmployees - $totalPresent - $totalLate - $totalAbsent)]
        ];
    }

    public function getCheckinDistributionProperty()
    {
        if (!$this->readyToLoad) {
            return [2, 8, 15, 12, 7, 3, 0, 0];
        }

        $today = Carbon::today();

        $checkinData = Attendance::whereDate('date', $today)
            ->whereNotNull('check_in')
            ->selectRaw('
                SUM(CASE WHEN TIME(check_in) BETWEEN "07:00:00" AND "07:29:59" THEN 1 ELSE 0 END) as slot_1,
                SUM(CASE WHEN TIME(check_in) BETWEEN "07:30:00" AND "07:59:59" THEN 1 ELSE 0 END) as slot_2,
                SUM(CASE WHEN TIME(check_in) BETWEEN "08:00:00" AND "08:29:59" THEN 1 ELSE 0 END) as slot_3,
                SUM(CASE WHEN TIME(check_in) BETWEEN "08:30:00" AND "08:59:59" THEN 1 ELSE 0 END) as slot_4,
                SUM(CASE WHEN TIME(check_in) BETWEEN "09:00:00" AND "09:29:59" THEN 1 ELSE 0 END) as slot_5,
                SUM(CASE WHEN TIME(check_in) BETWEEN "09:30:00" AND "09:59:59" THEN 1 ELSE 0 END) as slot_6,
                SUM(CASE WHEN TIME(check_in) BETWEEN "10:00:00" AND "10:29:59" THEN 1 ELSE 0 END) as slot_7,
                SUM(CASE WHEN TIME(check_in) >= "10:30:00" THEN 1 ELSE 0 END) as slot_8
            ')
            ->first();

        return [
            $checkinData->slot_1 ?? 0,
            $checkinData->slot_2 ?? 0,
            $checkinData->slot_3 ?? 0,
            $checkinData->slot_4 ?? 0,
            $checkinData->slot_5 ?? 0,
            $checkinData->slot_6 ?? 0,
            $checkinData->slot_7 ?? 0,
            $checkinData->slot_8 ?? 0,
        ];
    }

    public function getWeeklyTrendProperty()
    {
        if (!$this->readyToLoad) {
            return [
                'present' => [49, 50, 48, 49, 44, 13, 8],
                'late' => [3, 2, 4, 3, 8, 2, 1]
            ];
        }

        $weekStart = Carbon::now()->startOfWeek();
        $dates = collect(range(0, 6))->map(fn($i) => $weekStart->copy()->addDays($i));

        $weekData = $dates->map(function ($date) {
            $present = Attendance::whereDate('date', $date)
                ->where('status', 'present')
                ->count();

            $late = Attendance::whereDate('date', $date)
                ->where('status', 'late')
                ->count();

            return ['present' => $present, 'late' => $late];
        });

        return [
            'present' => $weekData->pluck('present')->toArray(),
            'late' => $weekData->pluck('late')->toArray()
        ];
    }

    public function getDepartmentPerformanceProperty()
    {
        if (!$this->readyToLoad) {
            return [];
        }

        $today = Carbon::today();

        return Department::with(['users'])
            ->get()
            ->map(function ($department) use ($today) {
                $totalEmployees = $department->users->count();

                if ($totalEmployees === 0) {
                    return null;
                }

                $attendanceData = Attendance::whereDate('date', $today)
                    ->whereHas('user', function ($query) use ($department) {
                        $query->where('department_id', $department->id);
                    })
                    ->selectRaw('
                        COUNT(*) as total_attendance,
                        SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count,
                        AVG(working_hours) as avg_hours
                    ')
                    ->first();

                $attendanceRate = $totalEmployees > 0 ?
                    round(($attendanceData->present_count / $totalEmployees) * 100) : 0;

                $performance = match (true) {
                    $attendanceRate >= 95 => ['label' => 'Excellent', 'color' => 'green', 'score' => 5],
                    $attendanceRate >= 90 => ['label' => 'Good', 'color' => 'yellow', 'score' => 4],
                    $attendanceRate >= 80 => ['label' => 'Fair', 'color' => 'orange', 'score' => 3],
                    default => ['label' => 'Needs Attention', 'color' => 'red', 'score' => 2]
                };

                return [
                    'name' => $department->name,
                    'attendance_rate' => $attendanceRate,
                    'team_size' => $totalEmployees,
                    'avg_hours' => $attendanceData->avg_hours ? number_format($attendanceData->avg_hours, 1) : '0.0',
                    'performance' => $performance,
                    'icon' => $this->getDepartmentIcon($department->name)
                ];
            })
            ->filter()
            ->values();
    }

    // Helper methods
    private function getAttendanceRate()
    {
        $today = Carbon::today();
        $totalEmployees = User::whereNull('deleted_at')->count();
        $presentEmployees = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'late'])
            ->count();

        return $totalEmployees > 0 ? ($presentEmployees / $totalEmployees) * 100 : 0;
    }

    private function getLeaveApprovalRate()
    {
        $totalRequests = LeaveRequest::whereMonth('created_at', Carbon::now()->month)->count();
        $approvedRequests = LeaveRequest::whereMonth('created_at', Carbon::now()->month)
            ->where('status', LeaveRequest::STATUS_APPROVED)
            ->count();

        return $totalRequests > 0 ? ($approvedRequests / $totalRequests) * 100 : 100;
    }

    private function getProductivityScore()
    {
        $today = Carbon::today();
        $avgWorkingHours = Attendance::whereDate('date', $today)
            ->whereNotNull('working_hours')
            ->avg('working_hours') ?? 0;

        // Normalize to 100 (assuming 8 hours = 100%)
        return min(100, ($avgWorkingHours / 8) * 100);
    }

    private function getUserPosition($user)
    {
        // You can extend this based on your user model structure
        return match ($user->role) {
            'director' => 'Director',
            'manager' => 'Manager',
            'admin' => 'Administrator',
            default => 'Staff'
        };
    }

    private function getInitials($name)
    {
        $nameParts = explode(' ', $name);
        $initials = '';
        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
            if (strlen($initials) >= 2)
                break;
        }
        return $initials ?: 'U';
    }

    private function getLateDuration($attendance)
    {
        if ($attendance->status !== 'late' || !$attendance->late_hours) {
            return null;
        }

        $hours = floor($attendance->late_hours);
        $minutes = round(($attendance->late_hours - $hours) * 60);

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }
        return "{$minutes}m";
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'present' => 'green',
            'late' => 'red',
            'early_leave' => 'yellow',
            'absent' => 'gray',
            default => 'gray'
        };
    }

    private function getDepartmentColor($departmentName)
    {
        return match (strtolower($departmentName)) {
            'digital marketing' => 'blue',
            'sydital' => 'teal',
            'detax' => 'purple',
            'hr' => 'indigo',
            default => 'gray'
        };
    }

    private function getDepartmentIcon($departmentName)
    {
        return match (strtolower($departmentName)) {
            'digital marketing' => 'fas fa-bullhorn',
            'sydital' => 'fas fa-code',
            'detax' => 'fas fa-calculator',
            'hr' => 'fas fa-users',
            default => 'fas fa-building'
        };
    }

    private function getAbsenceReason($user)
    {
        // Check if user has approved leave today
        $today = Carbon::today();
        $leave = LeaveRequest::where('user_id', $user->id)
            ->where('status', LeaveRequest::STATUS_APPROVED)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();

        if ($leave) {
            return ucfirst($leave->type) . ' Leave';
        }

        return 'Not Checked In';
    }

    public function render()
    {
        return view('livewire.director.dashboard', [
            'inOfficeStats' => $this->inOfficeStats,
            'pendingApprovals' => $this->pendingApprovals,
            'companyHealthScore' => $this->companyHealthScore,
            'todayAttendance' => $this->todayAttendance,
            'attendanceStats' => $this->attendanceStats,
            'checkinDistribution' => $this->checkinDistribution,
            'weeklyTrend' => $this->weeklyTrend,
            'departmentPerformance' => $this->departmentPerformance,
        ])->layout('layouts.director', ['title' => 'Executive Dashboard']);
    }
}