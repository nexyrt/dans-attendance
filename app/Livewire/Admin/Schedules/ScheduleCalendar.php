<?php

namespace App\Livewire\Admin\Schedules;

use App\Models\ScheduleException;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;

class ScheduleCalendar extends LivewireCalendar
{
    public $schedule = null;



    protected $listeners = [
        'handle-schedule-update' => 'handleScheduleUpdate'
    ];

    public function onEventDropped($eventId, $year, $month, $day)
    {
        ScheduleException::where('id', $eventId)
            ->update([
                'date' => sprintf('%d-%02d-%02d', $year, $month, $day)
            ]);

        // Optional: Notify update success
    }

    public function onEventClick($eventId)
    {
        $schedule = ScheduleException::find($eventId);
        if ($schedule) {
            $this->dispatch('schedule-selected', [
                'id' => $schedule->id,
                'title' => $schedule->status,
                'start_time' => $schedule->start_time?->format('H:i'),
                'end_time' => $schedule->end_time?->format('H:i'),
                'date' => $schedule->date->format('Y-m-d'),
                'description' => $schedule->note,
                'department' => $schedule->department?->name ?? 'All Departments'
            ]);
        }
    }



    public function handleScheduleUpdate($data)
    {
        // Note: $data will now include the event.detail inside a 'data' key

        $this->schedule = $data;

        
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
                    'description' => $model->note ?? 'No description',
                    'date' => $model->date,
                    'backgroundColor' => $this->getStatusColor($model->status),
                    'start_time' => $model->start_time,
                    'end_time' => $model->end_time,
                ];
            });
        
    }

        private function adjustBrightness($hex, $steps) {
        // Convert hex to rgb
        $rgb = array_map('hexdec', str_split(ltrim($hex, '#'), 2));
        
        // Adjust brightness
        foreach ($rgb as &$color) {
            $color = max(0, min(255, $color + $steps));
        }
        
        return sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'wfh' => [
                '#9D174D', // Base color (Light Blue)
                '#FCE7F3'  // Darker color (Dark Blue)
            ],
            'halfday' => [
                'blue-200', // Base color (Light Yellow)
                'blue-800'  // Darker color (Dark Yellow)
            ],
            default => [
                'yellow-200', // Base color (Light Gray)
                'yellow-800'  // Darker color (Dark Gray)
            ],
        };
    }


}
