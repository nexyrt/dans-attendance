<?php

namespace App\Livewire\Staff;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

class Payroll extends Component
{
    public $department;

    public function render()
    {
        return view('livewire.staff.payroll')
            ->layout('layouts.staff', ['title' => 'Payroll']);
        ;
    }
}
