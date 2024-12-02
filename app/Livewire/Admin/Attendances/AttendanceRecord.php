<?php

namespace App\Livewire\Admin\Attendances;

use Livewire\Component;
use App\Models\Attendance;

class AttendanceRecord extends Component
{
    public function render()
    {
        return view('livewire.admin.attendances.attendance-record',['attendances' => Attendance::all()]);
    }
}
