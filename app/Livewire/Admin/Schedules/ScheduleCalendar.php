<?php

namespace App\Livewire\Admin\Schedules;

use App\Models\ScheduleException;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;

class ScheduleCalendar extends LivewireCalendar
{
    public $schedule = false;
    public function onEventDropped($eventId, $year, $month, $day)
    {
        ScheduleException::where('id', $eventId)
            ->update([
                'date' => $year . '-' . $month . '-' . $day
            ]);
    }

    public function onEventClick($eventId)
    {
        // This event is triggered when an event card is clicked
        // You will be given the event id that was clicked
        $schedule = ScheduleException::find($eventId);
        $this->dispatchBrowserEvent('schedule-selected', $schedule);
    }

    public function selectSchedule($schedule)
    {
        // Dispatch a browser event with the schedule data
    }

    public function nextMonth()
    {
        $this->goToNextMonth();
    }

    public function prevMonth()
    {
        $this->goToPreviousMonth();
    }



    public function events(): Collection
    {

        return ScheduleException::query()
            ->get()
            ->map(function (ScheduleException $model) {
                return [
                    'id' => $model->id,
                    'title' => $model->status,
                    'description' => $model->note,
                    'date' => $model->date,
                ];
            });
    }
}
