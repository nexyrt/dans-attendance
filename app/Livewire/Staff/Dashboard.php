<?php

namespace App\Livewire\Staff;

use App\Models\Schedule;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Cake\Chronos\Chronos;

class Dashboard extends Component
{
    public $todayAttendance;
    public $workingDuration;
    public $formattedCheckIn;
    public $formattedCheckOut;
    public $currentWorkingHours;
    public $progressPercentage;
    public $todaySchedule;
    public $totalWorkHours;
    public $scheduleStart;
    public $scheduleEnd;
    public $scheduleRange;

    public function mount()
    {
        $this->loadTodaySchedule();
        $this->loadTodayAttendance();
    }

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
            $this->workingDuration = '00:00:00';
            $this->currentWorkingHours = 0;
            $this->progressPercentage = 0;
            return;
        }

        $startTime = Chronos::parse($this->todayAttendance->check_in);
        $endTime = $this->todayAttendance->check_out
            ? Chronos::parse($this->todayAttendance->check_out)
            : Chronos::now();

        $duration = $endTime->diff($startTime);

        $hours = str_pad($duration->h + ($duration->days * 24), 2, '0', STR_PAD_LEFT);
        $minutes = str_pad($duration->i, 2, '0', STR_PAD_LEFT);
        $seconds = str_pad($duration->s, 2, '0', STR_PAD_LEFT);

        $this->workingDuration = "{$hours}:{$minutes}:{$seconds}";

        // Calculate working hours and progress
        $this->currentWorkingHours = $duration->h + ($duration->days * 24) + ($duration->i / 60) + ($duration->s / 3600);
        $this->progressPercentage = $this->totalWorkHours > 0
            ? min(round(($this->currentWorkingHours / $this->totalWorkHours) * 100), 100)
            : 0;
    }

    public function render()
    {
        return view('livewire.staff.dashboard')
            ->layout('layouts.staff', ['title' => 'Dashboard']);
    }
}
