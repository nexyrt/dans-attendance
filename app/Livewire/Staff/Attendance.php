<?php

namespace App\Livewire\Staff;

use App\Models\Attendance as AttendanceModel;
use Cake\Chronos\Chronos;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    public function render()
    {
        return view('livewire.staff.attendance')->layout('layouts.staff', ['title' => 'Attendance']);
    }
}