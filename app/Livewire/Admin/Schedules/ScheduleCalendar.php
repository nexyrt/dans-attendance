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

    public function onEventDropped($eventId, $year, $month, $day)
    {
        ScheduleException::where('id', $eventId)
            ->update([
                'date' => sprintf('%d-%02d-%02d', $year, $month, $day)
            ]);

        // Optional: Notify update success
        $this->dispatch('schedule-updated', ['message' => 'Schedule updated successfully']);
    }

    public function onEventClick($eventId)
    {
        $schedule = ScheduleException::with('department')->find($eventId);

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
        // Handle update dari Alpine
        $this->schedule = $data;

        // Optional: Update database jika diperlukan
        if (isset($data['id'])) {
            ScheduleException::find($data['id'])->update([
                'status' => $data['title'],
                'note' => $data['description'],
                // ... update field lainnya
            ]);
        }
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
                    'backgroundColor' => $this->getStatusColor($model->status)
                ];
            });
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'wfh' => '#E5F6FD',  // Light blue
            'halfday' => '#FFF7E6', // Light yellow
            default => '#F3F4F6'  // Light gray
        };
    }
}
