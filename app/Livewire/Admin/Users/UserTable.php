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

    public $search = '';
    public $selectedDepartments = [];
    public $selectedRoles = [];
    public $departmentFilter = '';
    public $positionFilter = '';

    public function toggleAllRoles()
    {
        if (count($this->selectedRoles) === 3) {
            $this->selectedRoles = [];
        } else {
            $this->selectedRoles = ['admin', 'manager', 'staff'];
        }
    }

    public function removeDepartment($deptId)
    {
        $this->selectedDepartments = array_filter($this->selectedDepartments, function ($id) use ($deptId) {
            return $id != $deptId;
        });
    }

    public function removeRole($role)
    {
        $this->selectedRoles = array_filter($this->selectedRoles, function ($r) use ($role) {
            return $r !== $role;
        });
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedDepartments = [];
        $this->selectedRoles = [];
    }


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatedPositionFilter()
    {
        $this->resetPage();
    }


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


    public function render()
    {
        $query = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('id', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!empty($this->selectedDepartments), function ($query) {
                $query->whereIn('department_id', $this->selectedDepartments);
            })
            ->when(!empty($this->selectedRoles), function ($query) {
                $query->whereIn('role', $this->selectedRoles);
            })
            ->latest()

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

