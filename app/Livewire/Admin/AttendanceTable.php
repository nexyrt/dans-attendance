<?php

namespace App\Livewire\Admin;

use App\Models\Attendance;
use Livewire\Component;

class AttendanceTable extends Component
{
    public $attendances;

    public function mount()
    {
        $this->attendances = Attendance::all();
    }

    public function render()
    {
        return view('livewire.admin.attendance-table');
    }
}
