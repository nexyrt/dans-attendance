<?php

namespace App\Livewire\Director\Schedules;

use Livewire\Component;

class SchedulesCalendar extends Component
{
    public function render()
    {
        return view('livewire.director.schedules.schedules-calendar')->layout('layouts.director', ['title' => 'Schedules Calendar']);
    }
}
