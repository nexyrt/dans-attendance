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
    public $schedule = null;

    public $title;

    public $start_time;

    public $end_time;

    public $selectedDate;

    public $department;

    public $description;

    public $status;

    public $departments;


    protected $listeners = [
        'handle-schedule-update' => 'handleScheduleUpdate'
    ];

    public function onEventDropped($eventId, $year, $month, $day)
    {
        ScheduleException::where('id', $eventId)
            ->update([
                'date' => sprintf('%d-%02d-%02d', $year, $month, $day)
            ]);

    }

    public function setStartTime($startTime){
        $this->start_time = $startTime;
    }

    public function onEventClick($eventId)
    {
        $this->schedule = ScheduleException::find($eventId);

        if ($this->schedule) {
            $this->dispatch('schedule-selected', [
                'id' => $this->schedule->id,
                'title' => $this->schedule->title,
                'start_time' => $this->schedule->start_time?->format('H:i'),
                'end_time' => $this->schedule->end_time?->format('H:i'),
                'status' => $this->schedule->status,
                'date' => $this->schedule->date->format('Y-m-d'),
                'description' => $this->schedule->note,
                'department' => $this->schedule->department?->name ?? 'All Departments',
                'departments' => $this->departments // Pass all departments to the frontend
            ]);
            
        }
    }

    public function update()
    {
        $schedule = ScheduleException::findOrFail($this->schedule[0]['id']);

        $department = Department::where('name', $this->department)->first();
        if ($department) {
            $departmentId = $department->id;
        } else {
            $departmentId = null; // Handle the case when the department is not found
        }

        @dd($this->title);
        try {
            $schedule->update([
                'title' => $this->title,
                'date' => $this->selectedDate,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'department_id' => $departmentId,
                'status' => $this->status,
                'description' => $this->description,
            ]);
        
            // Reset the properties to null
            $this->title = null;
            $this->selectedDate = null;
            $this->start_time = null;
            $this->end_time = null;
            $this->department = null; // Assuming department is the name, not ID
            $this->status = null;
            $this->description = null;
        
            notify()->success('Data berhasil diubah!', 'Sukses');
            return redirect()->route('admin.schedules.dashboard');
        } catch (\Exception $e) {
            notify()->error('Terjadi kesalahan saat menambahkan data.' . $e, 'Error');
            return redirect()->back()->withErrors($e->getMessage());
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
                    'title' => $model->title,
                    'description' => $model->note ?? 'No description',
                    'status' => $model->status,
                    'date' => $model->date,
                    'backgroundColor' => $this->getStatusColor($model->status),
                    'start_time' => $model->start_time,
                    'end_time' => $model->end_time,
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


}
