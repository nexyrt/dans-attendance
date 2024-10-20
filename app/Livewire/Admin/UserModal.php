<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserModal extends Component
{
    public $employee_id;
    public $name;
    public $email;
    public $department;
    public $status;
    public $position;
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'department' => 'required|string',
        'status' => 'required|string',
        'position' => 'required|string',
        'password' => 'required|string|min:8'
    ];

    public function mount($employee = null)
    {
        if ($employee) {
            $this->employee_id = $employee->id;
            $this->name = $employee->name;
            $this->email = $employee->email;
            $this->department = $employee->department;
            $this->status = $employee->status;
            $this->position = $employee->position;
            $this->password = '';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->employee_id) {
            $employee = User::find($this->employee_id);
            $employee->update([
                'name' => $this->name,
                'email' => $this->email,
                'department' => $this->department,
                'status' => $this->status,
                'position' => $this->position,
                'password' => Hash::make($this->password),
            ]);
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'department' => $this->department,
                'status' => $this->status,
                'position' => $this->position,
                'password' => Hash::make($this->password),
            ]);
        }

        $this->resetInputFields();
        $this->emit('employeeSaved');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->department = '';
        $this->status = '';
        $this->position = '';
        $this->password = '';
    }

    public function render()
    {
        return view('livewire.admin.user-modal');
    }
}
