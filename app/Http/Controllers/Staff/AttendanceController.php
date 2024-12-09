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
        // Get today's attendance and schedule
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', Carbon::today())
            ->first();

        $schedule = Schedule::where('day_of_week', strtolower(Carbon::now()->format('l')))
            ->first();

        // Set schedule times with default values
        $scheduleStart = $schedule ? Carbon::parse($schedule->start_time) : Carbon::parse('09:00');
        $scheduleEnd = $schedule ? Carbon::parse($schedule->end_time) : Carbon::parse('17:00');
        $regularWorkHours = max($scheduleStart->diffInHours($scheduleEnd), 1); // Ensure minimum 1 hour

        // Set break times
        $breakStart = Carbon::parse('12:00');
        $breakEnd = Carbon::parse('13:00');

        // Check for schedule exceptions
        $scheduleException = ScheduleException::query()
            ->where('date', now()->toDateString())
            ->where(function ($query) {
                $query->where('department_id', auth()->user()->department_id)
                    ->orWhereNull('department_id');
            })
            ->first();

        // Adjust work hours for special schedules
        if ($scheduleException && $scheduleException->status === 'halfday') {
            $regularWorkHours = max($regularWorkHours / 2, 1); // Ensure minimum 1 hour even for half days
        }

        // Initialize default values
        $workDuration = '0h 0m';
        $currentProgress = 0;
        $remainingTime = 'Not started';

        if ($todayAttendance && $todayAttendance->check_in) {
            $startTime = Carbon::parse($todayAttendance->check_in);
            $endTime = $todayAttendance->check_out
                ? Carbon::parse($todayAttendance->check_out)
                : Carbon::now();

            // Calculate duration excluding break time
            $durationInMinutes = $startTime->diffInMinutes($endTime);

            // Only subtract break time if the work period spans the break
            if ($startTime->lt($breakStart) && $endTime->gt($breakEnd)) {
                $durationInMinutes -= $breakStart->diffInMinutes($breakEnd);
            }

            // Format duration
            $hours = floor($durationInMinutes / 60);
            $minutes = $durationInMinutes % 60;
            $workDuration = "${hours}h ${minutes}m";

            // Calculate progress with zero division protection
            $totalWorkMinutes = $regularWorkHours * 60;
            $currentProgress = $totalWorkMinutes > 0
                ? min(100, round(($durationInMinutes / $totalWorkMinutes) * 100))
                : 0;

            // Calculate remaining time if not checked out
            if (!$todayAttendance->check_out) {
                try {
                    $remainingTime = now()->diffForHumans($scheduleEnd, [
                        'parts' => 1,
                        'syntax' => Carbon::DIFF_RELATIVE_TO_NOW
                    ]);
                } catch (\Exception $e) {
                    $remainingTime = 'Time calculation error';
                }
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
            'remainingTime',
            'workDuration',
            'regularWorkHours'
        ));
    }
}