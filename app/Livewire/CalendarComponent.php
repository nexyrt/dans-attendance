<?php

namespace App\Livewire;

use Cake\Chronos\Chronos;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\LeaveRequest;
use App\Models\ScheduleException;

class CalendarComponent extends Component
{
    public $currentDateString;
    public $selectedDate = null;
    public $calendar = [];
    public $todaySchedule = null;
    public $selectedDateEvents = [];
    public $formattedSelectedDate = null;
    public $selectedDayName = null;

    public function mount()
    {
        $this->currentDateString = now()->format('Y-m-d');
        $this->generateCalendar();
    }

    protected function getCurrentDate(): Chronos
    {
        return new Chronos($this->currentDateString);
    }

    public function selectDate($date)
    {
        $dayOfWeek = strtolower(Chronos::parse($date)->format('l'));
        $this->todaySchedule = Schedule::where('day_of_week', $dayOfWeek)->first();
        $this->selectedDate = $date;
        $chronosDate = new Chronos($date);
        $this->formattedSelectedDate = $chronosDate->format('F j, Y');
        $this->selectedDayName = $chronosDate->format('l');
        $this->selectedDateEvents = $this->getEventsForDate($chronosDate);
        $this->generateCalendar();
    }

    public function nextMonth()
    {
        $currentDate = $this->getCurrentDate();
        $this->currentDateString = $currentDate->modify('+1 month')->format('Y-m-d');
        $this->generateCalendar();
    }

    public function previousMonth()
    {
        $currentDate = $this->getCurrentDate();
        $this->currentDateString = $currentDate->modify('-1 month')->format('Y-m-d');
        $this->generateCalendar();
    }

    public function getCurrentMonthProperty()
    {
        return $this->getCurrentDate()->format('F Y');
    }

    public function generateCalendar()
    {
        $currentDate = $this->getCurrentDate();
        $firstOfMonth = $currentDate->modify('first day of this month');
        $start = $firstOfMonth->modify('last sunday');
        $lastOfMonth = $currentDate->modify('last day of this month');
        $end = $lastOfMonth->modify('next saturday');

        $this->calendar = [];
        $week = [];

        $date = new Chronos($start);

        while ($date <= $end) {
            if (count($week) === 7) {
                $this->calendar[] = $week;
                $week = [];
            }

            $week[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('j'),
                'isCurrentMonth' => $date->format('m') === $currentDate->format('m'),
                'isToday' => $date->format('Y-m-d') === now()->format('Y-m-d'),
                'isSelected' => $this->selectedDate === $date->format('Y-m-d'),
                'events' => $this->getEventsForDate($date)
            ];

            $date = $date->modify('+1 day');
        }

        if (!empty($week)) {
            $this->calendar[] = $week;
        }
    }

    protected function getEventsForDate(Chronos $date)
    {
        $events = collect();

        // Regular schedule
        $schedule = Schedule::where('day_of_week', strtolower($date->format('l')))->first();
        if ($schedule) {
            $events->push([
                'type' => 'schedule',
                'title' => 'Regular Schedule',
                'time' => Chronos::parse($schedule->start_time)->format('H:i') . ' - ' . Chronos::parse($schedule->end_time)->format('H:i'),
                'order' => 1
            ]);
        }

        // Schedule exceptions (including holidays)
        $exception = ScheduleException::whereDate('date', $date->format('Y-m-d'))->first();
        if ($exception) {
            $events->push([
                'type' => $exception->status === 'holiday' ? 'holiday' : 'exception',
                'title' => $exception->title ?? $this->getExceptionTitle($exception->status),
                'status' => str($exception->status)->headline(),
                'note' => $exception->note,
                'time' => $exception->start_time
                    ? Chronos::parse($exception->start_time)->format('H:i') . ' - ' . Chronos::parse($exception->end_time)->format('H:i')
                    : null,
                'description' => $exception->note,
                'order' => $exception->status === 'holiday' ? 2 : 3
            ]);
        }

        // Leave requests
        $leave = LeaveRequest::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $date->format('Y-m-d'))
            ->whereDate('end_date', '>=', $date->format('Y-m-d'))
            ->first();
        if ($leave) {
            $events->push([
                'type' => 'leave',
                'title' => ucfirst($leave->type) . ' Leave',
                'description' => $leave->reason,
                'order' => 4
            ]);
        }

        return $events->sortBy('order')->values()->all();
    }

    public function goToToday()
    {
        $this->currentDateString = now()->format('Y-m-d');
        $this->selectedDate = $this->currentDateString;
        $this->selectDate($this->selectedDate);
        $this->generateCalendar();
    }

    protected function getExceptionTitle($status)
    {
        return match ($status) {
            'wfh' => 'Work From Home',
            'halfday' => 'Half Day',
            'holiday' => 'Holiday',
            default => 'Regular Schedule'
        };
    }

    public function render()
    {
        return view('livewire.calendar-component');
    }
}