<?php

namespace App\Livewire\Director;

use Livewire\Component;

class Leave extends Component
{
    public function render()
    {
        return view('livewire.director.leave')->layout('layouts.director', ['title' => 'Leave Management']);
    }
}
