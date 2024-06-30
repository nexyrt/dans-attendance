<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UserTable extends Component
{
    public $department = '';
    public $position = '';
    public $name = '';

    protected $listeners = ['userAdded' => 'render'];

    public function render()
    {
        $query = User::query();

        if ($this->department) {
            $query->where('department', $this->department);
        }

        if ($this->position) {
            $query->where('position', $this->position);
        }

        if ($this->name) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }

        $users = $query->get();

        return view('livewire.admin.user-table', compact('users'));
    }
}

