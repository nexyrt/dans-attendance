<?php

namespace App\Livewire\Manager;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.manager.dashboard')->layout('layouts.manager', ['title' => 'Dashboard']);
    }
}
