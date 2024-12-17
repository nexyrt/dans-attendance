<?php

namespace App\Livewire\Admin\Leave;

use App\Models\Department;
use App\Models\LeaveBalance as LeaveBalanceModel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveBalance extends Component
{
    use WithPagination;
    public $maxPossibleBalance = 100;
    public $filters = [
        'search' => '',
        'year' => '',
        'total_balance_min' => 0,
        'total_balance_max' => 100,
        'used_balance_min' => 0,
        'used_balance_max' => 100,
        'remaining_balance_min' => 0,
        'remaining_balance_max' => 100,
    ];

    public $showEditModal = false;
    public $selectedBalance = null;


    public $editForm = [
        'total_balance' => '',
        'used_balance' => '',
        'remaining_balance' => '',
    ];

    public function mount()
    {
        $this->filters['year'] = now()->year;
    }
    public function getBalances()
    {
        return LeaveBalanceModel::query()
            ->with('user.department')
            ->when($this->filters['search'], function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->filters['search'] . '%')
                        ->orWhere('email', 'like', '%' . $this->filters['search'] . '%');
                });
            })
            ->when($this->filters['year'], function ($query) {
                $query->where('year', $this->filters['year']);
            })
            ->when(true, function ($query) {
                $query->whereBetween('total_balance', [
                    $this->filters['total_balance_min'],
                    $this->filters['total_balance_max']
                ])
                    ->whereBetween('used_balance', [
                        $this->filters['used_balance_min'],
                        $this->filters['used_balance_max']
                    ])
                    ->whereBetween('remaining_balance', [
                        $this->filters['remaining_balance_min'],
                        $this->filters['remaining_balance_max']
                    ]);
            })
            ->paginate(10);
    }

    public function getStatistics()
    {
        $year = $this->filters['year'] ?? now()->year;

        return [
            'total_employees' => User::count(),
            'total_leave_balance' => LeaveBalanceModel::where('year', $year)->sum('total_balance'),
            'total_used_balance' => LeaveBalanceModel::where('year', $year)->sum('used_balance'),
            'total_remaining_balance' => LeaveBalanceModel::where('year', $year)->sum('remaining_balance'),
        ];
    }

    public function render()
    {
        $statistics = $this->getStatistics();
        return view('livewire.admin.leave.leave-balance', [
            'balances' => $this->getBalances(),
            'statistics' => $statistics,
            'users' => User::orderBy('name')->get(),
            'departments' => Department::all(),
            'years' => range(now()->year - 2, now()->year + 1),
        ]);
    }
}