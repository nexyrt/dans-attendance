<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\ScheduleException;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        // Get today's attendance for the authenticated user
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', Carbon::today())
            ->first();

        // Get regular schedule for today
        $schedule = Schedule::where('day_of_week', strtolower(Carbon::now()->format('l')))
            ->first();

        // If no schedule is found, set default values
        $scheduleStart = $schedule ? Carbon::parse($schedule->start_time) : Carbon::parse('09:00');
        $scheduleEnd = $schedule ? Carbon::parse($schedule->end_time) : Carbon::parse('17:00');

        // Set break times (you can modify these default values)
        $breakStart = Carbon::parse('12:00');
        $breakEnd = Carbon::parse('13:00');

        // Check for any schedule exceptions for today
        $scheduleException = ScheduleException::query()
            ->where('date', now()->toDateString())
            ->where(function ($query) {
                $query->where('department_id', auth()->user()->department_id)
                    ->orWhereNull('department_id');
            })
            ->first();

        // Calculate current progress if checked in
        $currentProgress = 0;
        $remainingTime = 'Not started';

        if ($todayAttendance && $todayAttendance->check_in) {
            $startTime = Carbon::parse($todayAttendance->check_in);
            $endTime = $scheduleEnd;
            $totalMinutes = $startTime->diffInMinutes($endTime);
            $elapsedMinutes = $startTime->diffInMinutes(now());

            $currentProgress = min(100, round(($elapsedMinutes / $totalMinutes) * 100));

            if (!$todayAttendance->check_out) {
                $remainingTime = now()->diffForHumans($scheduleEnd, [
                    'parts' => 1,
                    'syntax' => Carbon::DIFF_RELATIVE_TO_NOW
                ]);
            }
        }

        return view('staff.attendance.index', compact(
            'todayAttendance',
            'schedule',
            'scheduleStart',
            'scheduleEnd',
            'breakStart',
            'breakEnd',
            'scheduleException',
            'currentProgress',
            'remainingTime'
        ));
    }
}
