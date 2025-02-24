<?php

namespace App\Livewire\Director;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    // Search and filter properties
    public $search = '';
    public $department = '';
    public $role = '';
    
    // Form fields
    public $name = '';
    public $email = '';
    public $phone_number = '';
    public $department_id = '';
    public $role_selected = 'staff';
    public $salary = '';
    public $address = '';
    public $birthdate = '';

    // Modal states
    public $isModalOpen = false;
    public $editingUser = null;

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->department, function ($query) {
                $query->where('department_id', $this->department);
            })
            ->when($this->role, function ($query) {
                $query->where('role', $this->role);
            })
            ->paginate(10);

        return view('livewire.director.users', [
            'users' => $users,
            'departments' => $this->departments
        ])->layout('layouts.director', ['title' => 'Users Management']);
    }

    public function edit(User $user)
    {
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->department_id = $user->department_id;
        $this->role_selected = $user->role;
        $this->salary = $user->salary;
        $this->address = $user->address;
        $this->birthdate = $user->birthdate;
        
        $this->isModalOpen = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editingUser->id,
            'phone_number' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'role_selected' => 'required|in:staff,manager,admin,director',
            'salary' => 'nullable|numeric|min:0',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string'
        ]);

        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'department_id' => $this->department_id,
            'role' => $this->role_selected,
            'salary' => $this->salary,
            'birthdate' => $this->birthdate,
            'address' => $this->address
        ]);

        $this->reset([
            'name', 'email', 'phone_number', 'department_id', 
            'role_selected', 'salary', 'birthdate', 'address'
        ]);
        
        $this->isModalOpen = false;
        session()->flash('message', 'User updated successfully.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset([
            'name', 'email', 'phone_number', 'department_id', 
            'role_selected', 'salary', 'birthdate', 'address'
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'department', 'role']);
    }
}
