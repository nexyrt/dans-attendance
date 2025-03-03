<?php

namespace App\Livewire\Director;

use App\Models\User;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Cake\Chronos\Chronos;

class Users extends Component
{
    use WithPagination;

    // Search and filtering properties
    public $search = '';
    public $department = '';
    public $role = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $perPage = 10;

    // Form properties
    public $userId;
    public $name;
    public $email;
    public $password;
    public $role_select;
    public $department_id;
    public $phone_number;
    public $birthdate;
    public $salary;
    public $address;

    // Password reset properties
    public $resetPasswordId = null;
    public $newPassword = '';

    // User deletion properties
    public $userIdBeingDeleted = null;

    // View user property
    public $viewUserId = null;

    // Event listeners
    protected $listeners = [
        'edit' => 'edit',
        'viewUser' => 'viewUser',
        'confirmPasswordReset' => 'confirmPasswordReset',
        'confirmUserDeletion' => 'confirmUserDeletion',
        'userDeleted' => '$refresh'
    ];

    // Reset pagination when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartment()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    // Sorting
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Create or edit user form
    public function create()
    {
        $this->resetValidation();
        $this->reset(['userId', 'name', 'email', 'password', 'role_select', 'department_id', 'phone_number', 'birthdate', 'salary', 'address']);
        $this->dispatch('open-modal', 'create-user-modal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';  // Don't fill password field for security
        $this->role_select = $user->role;
        $this->department_id = $user->department_id;
        $this->phone_number = $user->phone_number;
        $this->birthdate = $user->birthdate ? Chronos::parse($user->birthdate)->format('Y-m-d') : null;
        $this->salary = $user->salary;
        $this->address = $user->address;

        $this->dispatch('open-modal', 'edit-user-modal');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $this->userId ? Rule::unique('users')->ignore($this->userId) : Rule::unique('users'),
            ],
            'role_select' => 'required|in:staff,manager,admin,director',
            'department_id' => 'nullable|exists:departments,id',
            'phone_number' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:500',
        ];

        // Only require password for new users
        if (!$this->userId) {
            $rules['password'] = 'required|min:8';
        } elseif ($this->password) {
            $rules['password'] = 'min:8';
        }

        $this->validate($rules);

        // Create or update user
        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role_select,
                'department_id' => $this->department_id,
                'phone_number' => $this->phone_number,
                'birthdate' => $this->birthdate,
                'salary' => $this->salary,
                'address' => $this->address,
            ];

            // Update password if provided
            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }

            $user->update($userData);

            $this->dispatch('close-modal', 'edit-user-modal');
            session()->flash('message', 'User updated successfully.');
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role_select,
                'department_id' => $this->department_id,
                'phone_number' => $this->phone_number,
                'birthdate' => $this->birthdate,
                'salary' => $this->salary,
                'address' => $this->address,
            ]);

            $this->dispatch('close-modal', 'create-user-modal');
            session()->flash('message', 'User created successfully.');
        }

        $this->reset(['userId', 'name', 'email', 'password', 'role_select', 'department_id', 'phone_number', 'birthdate', 'salary', 'address']);
    }

    // View user details
    public function viewUser($id)
    {
        $this->viewUserId = $id;
        $this->dispatch('open-modal', 'view-user-modal');
    }

    // Reset password
    public function confirmPasswordReset($id)
    {
        $this->resetPasswordId = $id;
        $this->newPassword = '';

        $this->dispatch('open-modal', 'reset-password-modal');
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:8',
        ]);

        try {
            $user = User::findOrFail($this->resetPasswordId);
            $user->update(['password' => Hash::make($this->newPassword)]);

            $this->dispatch('close-modal', 'reset-password-modal');
            session()->flash('message', 'Password reset successfully.');
            $this->resetPasswordId = null;
            $this->newPassword = '';
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reset password: ' . $e->getMessage());
        }
    }

    // Delete user
    public function confirmUserDeletion($id)
    {
        $this->userIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'delete-user-modal');
    }

    public function deleteUser()
    {
        try {
            $user = User::findOrFail($this->userIdBeingDeleted);
            $user->delete();

            $this->dispatch('close-modal', 'delete-user-modal');
            session()->flash('message', 'User deleted successfully.');
            $this->userIdBeingDeleted = null;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $departmentsList = Department::all();
        $this->dispatch('refresh-preline');
        $users = User::query()
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->department, function ($query) use ($departmentsList) {
                // Find the department by name and use its ID for filtering
                $dept = $departmentsList->where('name', $this->department)->first();
                if ($dept) {
                    return $query->where('department_id', $dept->id);
                }
                return $query;
            })
            ->when($this->role, function ($query) {
                return $query->where('role', $this->role);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.director.users', [
            'users' => $users,
            'departments' => $departmentsList,
            'roles' => ['staff', 'manager', 'admin', 'director'],
            'userBeingViewed' => $this->viewUserId ? User::findOrFail($this->viewUserId) : null,
        ])->layout('layouts.director', ['title' => 'Users Management']);
    }
}