<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now();

        // Get today's attendance and schedule
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        $schedule = Schedule    ::where('day_of_week', strtolower($today->format('l')))
            ->first();

        // Calculate weekly statistics
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $weekAttendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->get();

        // Calculate working hours
        $todayHours = $this->calculateTodayHours($todayAttendance);
        $weekTotal = $this->calculateWeekTotal($weekAttendances);
        $overtime = $this->calculateOvertime($weekAttendances, $schedule);

        // Calculate progress percentages for charts
        $stats = [
            'todayProgress' => min(($todayHours / 8) * 100, 100), // Assuming 8-hour workday
            'weekProgress' => min(($weekTotal / (40)) * 100, 100), // Assuming 40-hour workweek
            'overtimeProgress' => min(($overtime / 10) * 100, 100), // Showing overtime relative to 10 hours max
            'todayHours' => $todayHours,
            'weekTotal' => $weekTotal,
            'overtime' => $overtime
        ];

        return view('staff.dashboard.index', compact(
            'todayAttendance',
            'user',
            'stats',
            'schedule'
        ));
    }

    private function calculateTodayHours($attendance)
    {
        if (!$attendance || !$attendance->check_in) {
            return 0;
        }

        $checkOut = $attendance->check_out ?? now();
        $hours = Carbon::parse($attendance->check_in)
            ->diffInMinutes($checkOut) / 60;

        return round($hours, 1);
    }

    private function calculateWeekTotal($attendances)
    {
        return round($attendances->sum('working_hours') ?? 0, 1);
    }

    private function calculateOvertime($attendances, $schedule)
    {
        if (!$schedule) {
            return 0;
        }

        $standardHours = $attendances->count() * 8; // Assuming 8-hour workday
        $actualHours = $this->calculateWeekTotal($attendances);
        $overtime = max(0, $actualHours - $standardHours);

        return round($overtime, 1);
    }
}
