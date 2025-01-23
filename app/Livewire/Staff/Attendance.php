<?php

namespace App\Livewire\Staff;

use Livewire\Component;

class Attendance extends Component
{
    public function render()
    {
        return view('livewire.staff.attendance')
            ->layout('layouts.staff', ['title' => 'Attendance']);
        ;
    }
}
