<?php

namespace App\Livewire\Director;

use Livewire\Component;

class FaceAttendance extends Component
{
    public function render()
    {
        return view('livewire.director.face-attendance')
            ->layout('layouts.director', ['title' => 'Face Attendance']);
    }
}