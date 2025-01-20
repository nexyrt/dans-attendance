<?php

namespace App\Livewire\Staff;

use Livewire\Component;

class Leave extends Component
{
    public function render()
    {
        return view('livewire.staff.leave')
            ->layout('layouts.staff', ['title' => 'Leave']);
        ;
    }
}
