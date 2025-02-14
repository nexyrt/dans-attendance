<?php

namespace App\Livewire\Staff;

use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.staff.profile')
            ->layout('layouts.staff', ['title' => 'Profile']);
    }
}
