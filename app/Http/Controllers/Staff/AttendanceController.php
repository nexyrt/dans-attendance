<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\ScheduleException;
use Cake\Chronos\Chronos;
use Exception;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index()
    {
        try {
            $todayAttendance = Attendance::where('user_id', auth()->id())
                ->whereDate('date', Chronos::today()->toDateString())
                ->first();

            $schedule = Schedule::where('day_of_week', strtolower(Chronos::now()->format('l')))
                ->first();

            // Set schedule times
            $scheduleStart = $schedule ? 
                Chronos::parse($schedule->start_time) : 
                Chronos::parse('09:00');

            $scheduleEnd = $schedule ? 
                Chronos::parse($schedule->end_time) : 
                Chronos::parse('17:00');

            $regularWorkHours = $scheduleStart->diffInHours($scheduleEnd);

            // Set break times
            $breakStart = Chronos::parse('12:00');
            $breakEnd = Chronos::parse('13:00');

            // Check for schedule exceptions
            $scheduleException = $this->getScheduleException();

            // Adjust work hours for special schedules
            if ($scheduleException?->status === 'halfday') {
                $regularWorkHours /= 2;
            }

            // Calculate work metrics
            $workMetrics = $this->calculateWorkMetrics(
                $todayAttendance,
                $breakStart,
                $breakEnd,
                $regularWorkHours,
                $scheduleEnd
            );

            return view('staff.attendance.index', [
                'todayAttendance' => $todayAttendance,
                'schedule' => $schedule,
                'scheduleStart' => $scheduleStart,
                'scheduleEnd' => $scheduleEnd,
                'breakStart' => $breakStart,
                'breakEnd' => $breakEnd,
                'scheduleException' => $scheduleException,
                'currentProgress' => $workMetrics['currentProgress'],
                'remainingTime' => $workMetrics['remainingTime'],
                'workDuration' => $workMetrics['workDuration'],
                'regularWorkHours' => $regularWorkHours
            ]);

        } catch (Exception $e) {
            Log::error('Error in attendance index: ' . $e->getMessage());
            return view('staff.attendance.index')->with('error', 'Unable to load attendance data.');
        }
    }

    protected function getScheduleException()
    {
        return ScheduleException::query()
            ->where('date', Chronos::now()->toDateString())
            ->where(function ($query) {
                $query->where('department_id', auth()->user()->department_id)
                    ->orWhereNull('department_id');
            })
            ->first();
    }

    protected function calculateWorkMetrics($attendance, $breakStart, $breakEnd, $regularWorkHours, $scheduleEnd)
    {
        $workDuration = '0h 0m';
        $currentProgress = 0;
        $remainingTime = 'Not started';

        if ($attendance?->check_in) {
            $startTime = Chronos::parse($attendance->check_in);
            $endTime = $attendance->check_out
                ? Chronos::parse($attendance->check_out)
                : Chronos::now();

            $durationInMinutes = $this->calculateWorkDuration(
                $startTime,
                $endTime,
                $breakStart,
                $breakEnd
            );

            $workDuration = $this->formatWorkDuration($durationInMinutes);
            $currentProgress = $this->calculateProgress($durationInMinutes, $regularWorkHours);

            if (!$attendance->check_out) {
                $remainingTime = $this->calculateRemainingTime($scheduleEnd);
            }
        }

        return [
            'workDuration' => $workDuration,
            'currentProgress' => $currentProgress,
            'remainingTime' => $remainingTime
        ];
    }

    protected function calculateWorkDuration(Chronos $startTime, Chronos $endTime, Chronos $breakStart, Chronos $breakEnd)
    {
        $durationInMinutes = $startTime->diffInMinutes($endTime);

        if ($startTime->lessThan($breakStart) && $endTime->greaterThan($breakEnd)) {
            $durationInMinutes -= $breakStart->diffInMinutes($breakEnd);
        }

        return $durationInMinutes;
    }

    protected function formatWorkDuration($durationInMinutes)
    {
        $hours = floor($durationInMinutes / 60);
        $minutes = $durationInMinutes % 60;
        return sprintf('%dh %dm', $hours, $minutes);
    }

    protected function calculateProgress($durationInMinutes, $regularWorkHours)
    {
        $totalWorkMinutes = $regularWorkHours * 60;

        if ($totalWorkMinutes <= 0) {
            return 100;
        }

        return min(100, round(($durationInMinutes / $totalWorkMinutes) * 100));
    }

    protected function calculateRemainingTime(Chronos $scheduleEnd)
    {
        try {
            return Chronos::now()->diffForHumans($scheduleEnd, false);
        } catch (Exception $e) {
            Log::error('Error calculating remaining time: ' . $e->getMessage());
            return 'Shift ended';
        }
    }
}