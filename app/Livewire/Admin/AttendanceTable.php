<?php

namespace App\Livewire\Admin;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\User;
use Livewire\Component;

use Carbon\Carbon;

class AttendanceTable extends Component
{
    public $search = '';
    public $department = '';
    public $selectedMonth;

    protected $queryString = ['search', 'department', 'selectedMonth'];

    // Tambahkan watchers untuk setiap properti
    public function updatedSearch()
    {
        $this->render();
    }

    public function updatedDepartment()
    {
        $this->render();
    }

    public function updatedSelectedMonth()
    {
        $this->render();
    }

    public function mount()
    {
        $this->selectedMonth = $this->selectedMonth ?? now()->format('Y-m');
    }

    public function getChartData()
    {
        // Dummy data for demonstration
        return [
            'pieChart' => [
                'series' => [65, 35], // 65% on time, 35% late
                'labels' => ['On Time', 'Late'],
            ],
            'barChart' => [
                'categories' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                'series' => [
                    [
                        'name' => 'On Time',
                        'data' => [44, 55, 57, 56, 61], // Dummy values for each day
                    ],
                    [
                        'name' => 'Late',
                        'data' => [11, 8, 12, 14, 10], // Dummy values for each day
                    ],
                ],
            ],
        ];
    }


    public function render()
    {
        $date = Carbon::createFromFormat('Y-m', $this->selectedMonth);

        $attendances = Attendance::query()
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->leftJoin('users', 'attendances.user_id', '=', 'users.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->when($this->search, function ($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%');
            })
            ->when($this->department, function ($query) {
                $query->where('departments.name', $this->department);
            })
            ->select('attendances.*', 'users.name as user_name', 'users.position', 'departments.name as department_name')
            ->with('user', 'user.department')
            ->latest('date')
            ->get();

        $departments = Department::pluck('name')->filter()->values();

        $availableMonths = collect(range(0, 18))->map(function ($i) {
            $date = now()->subMonths($i);
            return [
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y')
            ];
        });

        return view('livewire.admin.attendance-table', [
            'attendances' => $attendances,
            'departments' => $departments,
            'availableMonths' => $availableMonths
        ]);
    }
}
