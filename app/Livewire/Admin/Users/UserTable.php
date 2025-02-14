<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Models\Attendance;
use Livewire\Component;
use App\Models\Department;
use Carbon\Carbon;

use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\UsersExport;
class UserTable extends Component
{
    use WithPagination;

    use WithFileUploads;

    public $editModal = false;
    public $department = '';
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


    protected $listeners = ['openEditModal' => '$refresh'];

    protected $queryString = [
        'department' => ['except' => ''],
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

    public function getUserStatus($user)
    {
        $lastAttendance = Attendance::where('user_id', $user->id)
            ->latest()
            ->first();

        if (!$lastAttendance) {
            return [
                'status' => 'inactive',
                'last_active' => 'Never attended',
                'status_color' => 'gray'
            ];
        }

        $now = Carbon::now();
        $attendanceDate = Carbon::parse($lastAttendance->date);

        // If attendance is today
        if ($attendanceDate->isToday()) {
            if (!$lastAttendance->check_out) {
                return [
                    'status' => 'active',
                    'last_active' => 'Working now',
                    'status_color' => 'green'
                ];
            }
            return [
                'status' => 'offline',
                'last_active' => 'Today at ' . Carbon::parse($lastAttendance->check_out)->format('h:i A'),
                'status_color' => 'yellow'
            ];
        }

        // If attendance was yesterday
        if ($attendanceDate->isYesterday()) {
            return [
                'status' => 'inactive',
                'last_active' => 'Yesterday',
                'status_color' => 'gray'
            ];
        }

        // If within this week
        if ($attendanceDate->isCurrentWeek()) {
            return [
                'status' => 'inactive',
                'last_active' => $attendanceDate->format('l'), // Returns day name (e.g., Monday)
                'status_color' => 'gray'
            ];
        }

        // If within this month
        if ($attendanceDate->isCurrentMonth()) {
            return [
                'status' => 'inactive',
                'last_active' => $attendanceDate->format('M d'), // Returns like "Jan 15"
                'status_color' => 'gray'
            ];
        }

        // If older than a month
        return [
            'status' => 'inactive',
            'last_active' => $attendanceDate->format('M d, Y'), // Returns like "Jan 15, 2024"
            'status_color' => 'gray'
        ];
    }

    public function export()
{
    return (new UsersExport(
        $this->search,
        $this->selectedDepartments,
        $this->selectedRoles
    ))->download('users.xlsx');
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

        $users = $query->paginate($this->perPage);

        // Add status information to each user
        $users->getCollection()->transform(function ($user) {
            $user->status_info = $this->getUserStatus($user);
            return $user;
        });

        $stats = [
            'total_employees' => User::count(),
            'departments' => Department::whereHas('users')->count(),
        ];

        return view('livewire.admin.users.user-management', [
            'users' => $users,
            'stats' => $stats,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}

