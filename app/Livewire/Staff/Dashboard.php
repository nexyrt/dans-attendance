<?php

namespace App\Livewire\Staff;

use App\Models\Schedule;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Cake\Chronos\Chronos;

class Dashboard extends Component
{
    // For Attendance Section
    public $todayAttendance;
    public $workingDuration;
    public $formattedCheckIn;
    public $formattedCheckOut;
    public $progressPercentage;
    public $scheduleStart;
    public $scheduleEnd;
    public $scheduleRange;
    public $totalWorkHours;
    private $todaySchedule;
    // For Attendance Section

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->loadTodaySchedule();
        $this->loadTodayAttendance();
    }

    // For Attendance Section
    private function loadTodaySchedule()
    {
        $dayOfWeek = strtolower(Chronos::now()->format('l'));
        $this->todaySchedule = Schedule::where('day_of_week', $dayOfWeek)->first();

        if ($this->todaySchedule) {
            $startTime = Chronos::parse($this->todaySchedule->start_time);
            $endTime = Chronos::parse($this->todaySchedule->end_time);

            $this->scheduleStart = $startTime->format('H:i');
            $this->scheduleEnd = $endTime->format('H:i');
            $this->totalWorkHours = $endTime->diffInHours($startTime);
            $this->scheduleRange = "{$this->scheduleStart} - {$this->scheduleEnd} ({$this->totalWorkHours}h)";
        } else {
            $this->scheduleStart = '--:--';
            $this->scheduleEnd = '--:--';
            $this->totalWorkHours = 0;
            $this->scheduleRange = 'No schedule today';
        }
    }

    public function loadTodayAttendance()
    {
        $this->todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('date', Chronos::today())
            ->first();

        $this->formatTimes();
        $this->calculateWorkingDuration();
    }

    private function formatTimes()
    {
        $this->formattedCheckIn = $this->todayAttendance?->check_in
            ? Chronos::parse($this->todayAttendance->check_in)->format('H:i')
            : '--:--';

        $this->formattedCheckOut = $this->todayAttendance?->check_out
            ? Chronos::parse($this->todayAttendance->check_out)->format('H:i')
            : '--:--';
    }

    public function calculateWorkingDuration()
    {
        if (!$this->todayAttendance?->check_in) {
            $this->workingDuration = '00h00m00s';
            $this->progressPercentage = 0;
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

    public function checkOut()
    {
        if ($this->todayAttendance && !$this->todayAttendance->check_out) {
            $this->todayAttendance->update([
                'check_out' => Chronos::now(),
                'working_hours' => $this->currentWorkingHours
            ]);

            $this->loadTodayAttendance();
        }
    }

    public function getListeners()
    {
        return [
            'refresh' => '$refresh',
            'echo:private-attendance.' . Auth::id() . ',AttendanceUpdated' => 'loadTodayAttendance'
        ];
    }
    // For Attendance Section

    public function render()
    {
        return view('livewire.staff.dashboard')
            ->layout('layouts.staff', ['title' => 'Dashboard']);
    }
}
