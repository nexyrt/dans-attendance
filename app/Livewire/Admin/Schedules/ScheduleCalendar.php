<?php

namespace App\Livewire\Admin\Schedules;

use App\Models\ScheduleException;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;

class ScheduleCalendar extends LivewireCalendar
{
    public function onEventDropped($eventId, $year, $month, $day)
    {
        ScheduleException::where('id', $eventId)
        ->update([
            'date' => $year . '-' . $month . '-' . $day
        ]);
    }

    public function nextMonth(){
        $this->goToNextMonth();
    }

    public function prevMonth(){
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
