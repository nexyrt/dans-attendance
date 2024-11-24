<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination; // Tambahkan trait WithPagination
    public $department = '';
    public $position = '';
    public $name = '';

    public $perPage = 10;

    protected $listeners = ['userAdded' => 'render'];

    // Reset pagination ketika filter berubah
    public function updatedDepartment()
    {
        $this->resetPage();
    }
    
    public function updatedPosition()
    {
        $this->resetPage();
    }
    
    public function updatedName()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();

        $departments =  Department::orderBy('name')->get();

        $stats = [
            'total_employees' => User::count(),
            'departments' => Department::whereHas('users')->count(),
            'positions' => User::distinct('position')->count('position'),
        ];


        if ($this->department) {
            
        }

        if ($this->position) {
            $query->where('position', $this->position);
        }

        if ($this->name) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }

        $users = $query->paginate($this->perPage); 

        return view('livewire.admin.user-management', compact('users','stats','departments'));
    }
}

