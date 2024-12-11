<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\KanbanCard;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\Schedule;
use App\Models\ScheduleException;
use Cake\Chronos\Chronos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Chronos::now();

        // Get today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        // Get schedule and any exceptions
        $schedule = Schedule::where('day_of_week', strtolower($today->format('l')))
            ->first();

        // Get schedule exception through the pivot table
        $scheduleException = ScheduleException::whereDate('date', $today->format('Y-m-d'))
            ->whereExists(function ($query) use ($user) {
                $query->select(DB::raw(1))
                    ->from('department_schedule_exception')
                    ->whereColumn('schedule_exceptions.id', 'department_schedule_exception.schedule_exception_id')
                    ->where('department_schedule_exception.department_id', $user->department_id);
            })
            ->first();

        // Calculate weekly statistics
        $startOfWeek = $today->startOfWeek();
        $endOfWeek = $today->endOfWeek();

        $weekAttendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->get();

        // Get target hours based on schedule or exception
        $targetHours = $this->calculateTargetHours($schedule, $scheduleException);

        // Calculate working hours
        $todayHours = $this->calculateTodayHours($todayAttendance);
        $weekTotal = $this->calculateWeekTotal($weekAttendances);
        $overtime = $this->calculateOvertime($weekAttendances, $targetHours);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($user->id);

        // Get upcoming tasks
        $upcomingTasks = $this->getUpcomingTasks($user->id);

        // Get upcoming holidays
        $upcomingHolidays = $this->getUpcomingHolidays();

        // Get leave information
        $leaveBalance = LeaveBalance::where('user_id', $user->id)
            ->where('year', $today->year)
            ->first();

        $pendingLeaves = LeaveRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('start_date')
            ->take(2)
            ->get();

        // Calculate progress percentages for charts
        $stats = [
            'todayHours' => $todayHours,
            'weekTotal' => $weekTotal,
            'overtime' => $overtime,
            'targetHours' => $targetHours,
            'todayProgress' => min(($todayHours / $targetHours) * 100, 100),
            'weekProgress' => min(($weekTotal / (5 * $targetHours)) * 100, 100),
            'overtimeProgress' => min(($overtime / 10) * 100, 100),
            'leaveBalance' => $leaveBalance ? [
                'total' => $leaveBalance->total_balance,
                'used' => $leaveBalance->used_balance,
                'remaining' => $leaveBalance->remaining_balance,
            ] : null
        ];

        return view('staff.dashboard.index', compact(
            'todayAttendance',
            'user',
            'stats',
            'schedule',
            'scheduleException',
            'recentActivity',
            'upcomingTasks',
            'upcomingHolidays',
            'pendingLeaves'
        ));
    }

    private function calculateTargetHours($schedule, $scheduleException)
    {
        if ($scheduleException) {
            if (!$scheduleException->start_time || !$scheduleException->end_time) {
                return 0;
            }
            $start = Chronos::parse($scheduleException->start_time);
            $end = Chronos::parse($scheduleException->end_time);
            return $end->diffInHours($start);
        }

        if ($schedule) {
            $start = Chronos::parse($schedule->start_time);
            $end = Chronos::parse($schedule->end_time);
            return $end->diffInHours($start);
        }

        return 8; // Default 8-hour workday
    }

    private function calculateTodayHours($attendance)
    {
        if (!$attendance || !$attendance->check_in) {
            return 0;
        }

        $checkOut = $attendance->check_out ?
            Chronos::parse($attendance->check_out) :
            Chronos::now();

        $checkIn = Chronos::parse($attendance->check_in);
        $hours = $checkIn->diffInMinutes($checkOut) / 60;

        return round($hours, 1);
    }

    private function calculateWeekTotal($attendances)
    {
        return round($attendances->sum('working_hours') ?? 0, 1);
    }

    private function calculateOvertime($attendances, $targetHours)
    {
        $standardHours = $attendances->count() * $targetHours;
        $actualHours = $this->calculateWeekTotal($attendances);
        $overtime = max(0, $actualHours - $standardHours);

        return round($overtime, 1);
    }

    private function getRecentActivity($userId)
    {
        return Attendance::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get()
            ->map(function ($attendance) {
                return [
                    'type' => $attendance->check_out ? 'check_out' : 'check_in',
                    'time' => $attendance->check_out ?? $attendance->check_in,
                    'status' => $attendance->status,
                    'working_hours' => $attendance->working_hours,
                    'date' => $attendance->date,
                    'notes' => $attendance->notes,
                    'early_leave_reason' => $attendance->early_leave_reason,
                ];
            });
    }

    private function getUpcomingTasks($userId)
    {
        return KanbanCard::where('assigned_to', $userId)
            ->whereNotNull('due_date')
            ->where('due_date', '>=', Chronos::now())
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->take(3)
            ->get();
    }

    private function getUpcomingHolidays()
    {
        return Holiday::where('start_date', '>=', Chronos::now())
            ->where('start_date', '<=', Chronos::now()->addDays(7))
            ->orderBy('start_date')
            ->take(3)
            ->get();
    }
}
