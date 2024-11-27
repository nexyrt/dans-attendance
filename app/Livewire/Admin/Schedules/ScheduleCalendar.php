<?php

namespace App\Livewire\Admin\Schedules;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Department;
use App\Models\ScheduleException;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;

class ScheduleCalendar extends LivewireCalendar
{


    protected $listeners = [
        'open-create-modal' => 'openCreateModal',
        'handle-schedule-update' => 'loadSchedule'
    ];

    public $search = '';
    protected $queryString = ['search'];

    public $activeFilter = 'all'; // Add this property

    // Add this method to handle search updates
    public function updated($field)
    {
        if ($field === 'search') {
            $this->dispatch('refresh-calendar');
        }
    }

    // Add method to clear search
    public function clearSearch()
    {
        $this->reset('search');
    }

    public function onEventDropped($eventId, $year, $month, $day)
    {
        ScheduleException::where('id', $eventId)
            ->update([
                'date' => sprintf('%d-%02d-%02d', $year, $month, $day)
            ]);

    }

    public function setFilter($filter)
    {
        $this->activeFilter = $filter;
    }

    public function setStartTime($startTime)
    {
        $this->start_time = $startTime;
    }




    public function onEventClick($eventId)
    {
        $this->schedule = ScheduleException::find($eventId);

        if ($this->schedule) {
            $this->dispatch('schedule-selected', [
                'id' => $this->schedule->id,
                'title' => $this->schedule->title,
                'start_time' => $this->schedule->start_time->format('H:i'),
                'end_time' => $this->schedule->end_time->format('H:i'),
                'status' => $this->schedule->status,
                'date' => $this->schedule->date->format('Y-m-d'),
                'description' => $this->schedule->note,
                'department' => $this->schedule->department?->name ?? 'All Departments',
                'departments' => Department::all(),
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
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->activeFilter !== 'all', function ($query) {
                $today = Carbon::today();

                return match ($this->activeFilter) {
                    'completed' => $query->where('date', '<', $today),
                    'today' => $query->whereDate('date', $today),
                    'upcoming' => $query->where('date', '>', $today),
                    default => $query
                };
            })
            ->whereBetween('date', [
                $this->gridStartsAt->format('Y-m-d'),
                $this->gridEndsAt->format('Y-m-d')
            ])
            ->get()
            ->map(function ($event) {
                $today = Carbon::today();
                $eventDate = Carbon::parse($event->date);

                $dateStatus = 'upcoming';
                if ($eventDate->isPast()) {
                    $dateStatus = 'completed';
                } elseif ($eventDate->isToday()) {
                    $dateStatus = 'today';
                }

                $backgroundColor = match ($dateStatus) {
                    'completed' => '#6B7280',
                    'today' => '#059669',
                    'upcoming' => '#3B82F6',
                    default => '#6B7280'
                };

                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => $event->date,
                    'status' => $event->status,
                    'date_status' => $dateStatus,
                    'description' => $event->note,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'department' => $event->department?->name,
                    'backgroundColor' => $backgroundColor,
                    'textColor' => '#FFFFFF',
                    'borderColor' => $backgroundColor,
                ];
            });
    }

    private function adjustBrightness($hex, $steps)
    {
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

    // Optional: Add a method to clear search



}
