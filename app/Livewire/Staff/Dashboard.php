<?php

namespace App\Livewire\Staff;

use App\Models\Schedule;
use App\Models\Attendance;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Cake\Chronos\Chronos;

class Dashboard extends Component
{
    /**
     * Component properties
     */
    public $todayAttendance;
    public $workingDuration = '00h00m00s';
    public $progressPercentage = 0;
    public $scheduleRange = 'No schedule today';
    public $monthlyStats = [];

    // Schedule properties
    public $scheduleStart = '--:--';
    public $scheduleEnd = '--:--';
    public $totalWorkHours = 0;

    protected $listeners = [
        'refresh' => '$refresh',
        'echo:private-attendance.{userId},AttendanceUpdated' => 'loadTodayAttendance'
    ];

    /**
     * Component initialization
     */
    public function mount()
    {
        $this->loadTodaySchedule();
        $this->loadTodayAttendance();
        $this->loadMonthlyStats();
    }

    /**
     * Load today's schedule information
     */
    private function loadTodaySchedule()
    {
        $dayOfWeek = strtolower(Chronos::now()->format('l'));
        $schedule = Schedule::where('day_of_week', $dayOfWeek)->first();

        if (!$schedule) {
            return;
        }

        $startTime = Chronos::parse($schedule->start_time);
        $endTime = Chronos::parse($schedule->end_time);

        $this->scheduleStart = $startTime->format('H:i');
        $this->scheduleEnd = $endTime->format('H:i');
        $this->totalWorkHours = $endTime->diffInHours($startTime);
        $this->scheduleRange = "{$this->scheduleStart} - {$this->scheduleEnd} ({$this->totalWorkHours}h)";
    }

    /**
     * Load today's attendance record
     */
    public function loadTodayAttendance()
    {
        $this->todayAttendance = Attendance::with('checkInOffice')->where('user_id', Auth::id())
            ->whereDate('date', Chronos::today())
            ->first();

        $this->calculateWorkingDuration();
    }

    /**
     * Calculate current working duration and progress
     */
    public function calculateWorkingDuration()
    {
        if (!$this->todayAttendance?->check_in) {
            return;
        }

        $startTime = Chronos::parse($this->todayAttendance->check_in);
        $endTime = $this->todayAttendance->check_out
            ? Chronos::parse($this->todayAttendance->check_out)
            : Chronos::now();

        $duration = $endTime->diff($startTime);
        $totalHours = $duration->h + ($duration->days * 24);

        $this->workingDuration = sprintf(
            '%02dh%02dm%02ds',
            $totalHours,
            $duration->i,
            $duration->s
        );

        $workedHours = $totalHours + ($duration->i / 60) + ($duration->s / 3600);
        $this->progressPercentage = $this->totalWorkHours > 0
            ? min(round(($workedHours / $this->totalWorkHours) * 100), 100)
            : 0;
    }

    /**
     * Load monthly attendance statistics
     */
    private function loadMonthlyStats()
    {
        $currentMonth = Chronos::now()->startOfMonth();
        $endOfMonth = Chronos::now()->endOfMonth();

        // Get monthly attendance records
        $monthlyAttendances = Attendance::where('user_id', Auth::id())
            ->whereYear('date', $currentMonth->year)
            ->whereMonth('date', $currentMonth->month)
            ->get();

        // Calculate working days (excluding weekends)
        $workingDays = 0;
        $date = clone $currentMonth;
        while ($date <= $endOfMonth) {
            if (!in_array($date->format('l'), ['Saturday', 'Sunday'])) {
                $workingDays++;
            }
            $date = $date->modify('+1 day');
        }

        // Calculate statistics
        $presentDays = $monthlyAttendances->count();
        $this->monthlyStats = [
            'workingDays' => $workingDays,
            'presentDays' => $presentDays,
            'attendanceRate' => $workingDays > 0 ? round(($presentDays / $workingDays) * 100) : 0,
            'onTime' => $monthlyAttendances->where('status', 'present')->count(),
            'late' => $monthlyAttendances->where('status', 'late')->count(),
            'early' => $monthlyAttendances->where('status', 'early_leave')->count()
        ];
    }

    /**
     * Get user ID for Echo channel
     */
    public function getUserIdProperty()
    {
        return Auth::id();
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.staff.dashboard')
            ->layout('layouts.staff', ['title' => 'Dashboard']);
    }
}