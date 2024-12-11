<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\ScheduleException;
use Cake\Chronos\Chronos;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Default work hours if no schedule is found
     */
    private const DEFAULT_START_TIME = '09:00';
    private const DEFAULT_END_TIME = '17:00';
    private const DEFAULT_BREAK_START = '12:00';
    private const DEFAULT_BREAK_END = '13:00';

    /**
     * Display the attendance page
     */
    public function index(): View
    {
        try {
            // Get today's data
            $today = Chronos::now();
            $user = auth()->user();

            // Get attendance and schedule data
            $data = $this->getTodayData($user->id, $today);

            // Calculate work metrics
            $workMetrics = $this->calculateWorkMetrics(
                $data['todayAttendance'],
                $data['breakStart'],
                $data['breakEnd'],
                $data['regularWorkHours'],
                $data['scheduleEnd']
            );

            return view('staff.attendance.index', array_merge($data, $workMetrics));
        } catch (Exception $e) {
            Log::error('Error in attendance index: ' . $e->getMessage());
            return view('staff.attendance.index')->with('error', 'Unable to load attendance data.');
        }
    }

    /**
     * Get all necessary data for today's schedule
     */
    private function getTodayData(int $userId, Chronos $today): array
    {
        // Get attendance record
        $todayAttendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today->toDateString())
            ->first();

        // Get regular schedule
        $schedule = Schedule::where('day_of_week', strtolower($today->format('l')))
            ->first();

        // Get schedule times
        $scheduleStart = $schedule ?
            Chronos::parse($schedule->start_time) :
            Chronos::parse(self::DEFAULT_START_TIME);

        $scheduleEnd = $schedule ?
            Chronos::parse($schedule->end_time) :
            Chronos::parse(self::DEFAULT_END_TIME);

        // Calculate regular work hours
        $regularWorkHours = $scheduleStart->diffInHours($scheduleEnd);

        // Get break times
        $breakStart = Chronos::parse(self::DEFAULT_BREAK_START);
        $breakEnd = Chronos::parse(self::DEFAULT_BREAK_END);

        // Get any schedule exceptions
        $scheduleException = $this->getScheduleException($userId);

        // Adjust work hours for special schedules
        if ($scheduleException && $scheduleException->status === 'halfday') {
            $regularWorkHours /= 2;
            $scheduleEnd = $scheduleStart->addHours($regularWorkHours);
        }

        return compact(
            'todayAttendance',
            'schedule',
            'scheduleStart',
            'scheduleEnd',
            'breakStart',
            'breakEnd',
            'scheduleException',
            'regularWorkHours'
        );
    }

    /**
     * Get schedule exception for today
     */
    private function getScheduleException(int $userId): ?ScheduleException
    {
        return ScheduleException::whereDate('date', Chronos::now()->toDateString())
            ->whereExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('department_schedule_exception')
                    ->whereColumn('schedule_exceptions.id', 'department_schedule_exception.schedule_exception_id')
                    ->where('department_schedule_exception.department_id', function ($subquery) use ($userId) {
                        $subquery->select('department_id')
                            ->from('users')
                            ->where('id', $userId);
                    });
            })
            ->first();
    }

    /**
     * Calculate various work metrics
     */
    private function calculateWorkMetrics(?Attendance $attendance, Chronos $breakStart, Chronos $breakEnd, float $regularWorkHours, Chronos $scheduleEnd): array
    {
        $workDuration = '0h 0m';
        $currentProgress = 0;
        $remainingTime = 'Not started';

        if ($attendance && $attendance->check_in) {
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

        return compact('workDuration', 'currentProgress', 'remainingTime');
    }

    /**
     * Calculate actual working duration excluding break time
     */
    private function calculateWorkDuration(Chronos $startTime, Chronos $endTime, Chronos $breakStart, Chronos $breakEnd): int
    {
        $durationInMinutes = $startTime->diffInMinutes($endTime);

        // Subtract break time if work spans over break period
        if ($startTime->lessThan($breakStart) && $endTime->greaterThan($breakEnd)) {
            $durationInMinutes -= $breakStart->diffInMinutes($breakEnd);
        }

        return $durationInMinutes;
    }

    /**
     * Format duration from minutes to hours and minutes
     */
    private function formatWorkDuration(int $durationInMinutes): string
    {
        $hours = floor($durationInMinutes / 60);
        $minutes = $durationInMinutes % 60;
        return sprintf('%dh %dm', $hours, $minutes);
    }

    /**
     * Calculate work progress percentage
     */
    private function calculateProgress(int $durationInMinutes, float $regularWorkHours): int
    {
        $totalWorkMinutes = $regularWorkHours * 60;
        return $totalWorkMinutes <= 0 ? 100 : min(100, round(($durationInMinutes / $totalWorkMinutes) * 100));
    }

    /**
     * Calculate remaining time until schedule end
     */
    private function calculateRemainingTime(Chronos $scheduleEnd): string
    {
        try {
            if (Chronos::now()->greaterThan($scheduleEnd)) {
                return 'Shift ended';
            }
            // Remove the array and just pass false to get relative format
            return Chronos::now()->diffForHumans($scheduleEnd, false);
        } catch (Exception $e) {
            Log::error('Error calculating remaining time: ' . $e->getMessage());
            return 'Shift ended';
        }
    }
}
