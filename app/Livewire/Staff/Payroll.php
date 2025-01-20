<?php

namespace App\Livewire\Staff;

use Livewire\Component;

class Payroll extends Component
{
    public function render()
    {
        return view('livewire.staff.payroll')
            ->layout('layouts.staff', ['title' => 'Payroll']);
        ;
    }
}
