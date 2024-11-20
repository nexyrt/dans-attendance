<?php
namespace App\Livewire\Admin\Schedules;

use App\Models\Schedule;
use Livewire\Component;
use Carbon\Carbon;

class ScheduleTable extends Component
{
    public $showModal = false;
    public $editingSchedule = null;
    
    public $day_of_week;
    public $start_time;
    public $end_time;
    public $late_tolerance;

    protected $rules = [
        'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'late_tolerance' => 'required|integer|min:0|max:120'
    ];

    public function edit(Schedule $schedule)
    {
        $this->editingSchedule = $schedule;
        $this->day_of_week = $schedule->day_of_week;
        $this->start_time = $schedule->start_time->format('H:i');
        $this->end_time = $schedule->end_time->format('H:i');
        $this->late_tolerance = $schedule->late_tolerance;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editingSchedule->update([
            'day_of_week' => $this->day_of_week,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'late_tolerance' => $this->late_tolerance,
        ]);

        session()->flash('message', 'Schedule updated successfully.');
        $this->showModal = false;
        $this->reset(['editingSchedule', 'day_of_week', 'start_time', 'end_time', 'late_tolerance']);
    }

    public function render()
    {
        return view('livewire.admin.schedules.schedule-table', [
            'schedules' => Schedule::orderBy('day_of_week', 'asc')->get()
        ]);
    }
}