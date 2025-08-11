<?php

namespace App\Livewire\Staff;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use TallStackUi\Traits\Interactions;

class Leave extends Component
{
    public function render()
    {
        return view('livewire.staff.leave')->layout('layouts.staff', ['title' => 'Leave Management']);
    }
}