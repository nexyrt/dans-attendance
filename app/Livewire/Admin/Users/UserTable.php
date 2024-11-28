<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class UserTable extends Component
{
    use WithPagination;

    use WithFileUploads;

    public $editModal = false;
    public $department = '';
    public $position = '';
    public $name;
    public $email;
    public $phone_number;
    public $birthdate;
    public $department_id;
    public $role;
    public $salary;
    public $address;
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $listeners = ['openEditModal' => '$refresh'];

    protected $queryString = [
        'department' => ['except' => ''],
        'position' => ['except' => ''],
        'name' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';
        $this->sortField = $field;
    }


    public function openEditModal($userId)
    {
        $this->editModal = true;
        $user = User::find($userId);

        // Set form fields with existing user data
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->birthdate = optional($user->birthdate)->format('Y-m-d');
        $this->department_id = $user->department_id;
        $this->position = $user->position;
        $this->role = $user->role;
        $this->salary = $user->salary;
        $this->address = $user->address;

    }

    public function closeModal()
    {
        $this->editModal = false;
        $this->reset([
            'userId',
            'name',
            'email',
            'phone_number',
            'birthdate',
            'department_id',
            'position',
            'role',
            'salary',
            'address',
            'image'
        ]);
    }

 


    public function render()
    {
        $query = User::query()
            ->when(
                $this->department,
                fn($q) =>
                $q->whereHas(
                    'department',
                    fn($q) =>
                    $q->where('name', $this->department)
                )
            )
            ->when(
                $this->position,
                fn($q) =>
                $q->where('position', $this->position)
            )
            ->orderBy($this->sortField, $this->sortDirection);

        $stats = [
            'total_employees' => User::count(),
            'departments' => Department::whereHas('users')->count(),
            'positions' => User::distinct('position')->count('position')
        ];

        return view('livewire.admin.users.user-management', [
            'users' => $query->paginate($this->perPage),
            'stats' => $stats,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}

