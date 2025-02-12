<?php

namespace App\Livewire\Staff;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

class Payroll extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    #[On('date-range-selected')]
    public function handleDateRangeSelected($data)
    {
        $this->startDate = $data['startDate'];
        $this->endDate = $data['endDate'];
    }

    public function render()
    {
        return view('livewire.staff.payroll')
            ->layout('layouts.staff', ['title' => 'Payroll']);
        ;
    }
}
