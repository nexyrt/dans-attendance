<?php

namespace App\Livewire\Staff;

use App\Exports\Staff\AttendanceExport;
use Cake\Chronos\Chronos;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class Attendance extends Component
{
    use WithPagination;

    // Filters
    public $dateRange = 'current_month';
    public $filterStatus = '';
    public $customStartDate = '';
    public $customEndDate = '';
    
    // Statistics
    public $totalDays;
    public $presentDays;
    public $lateDays;
    public $earlyLeaves;
    public $totalHours;

    protected $listeners = [
        'checkInSuccess' => '$refresh',
        'checkOutSuccess' => '$refresh'
    ];

    public function mount()
    {
        $this->calculateStatistics();
    }

    public function export()
    {
        [$startDate, $endDate] = $this->getDateRangeValues();
        
        return Excel::download(
            new AttendanceExport($startDate, $endDate, $this->filterStatus), 
            'attendance_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    public function getDateRangeValues()
    {
        return match($this->dateRange) {
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
            'current_week' => [now()->startOfWeek(), now()->endOfWeek()],
            'last_week' => [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()],
            'current_month' => [now()->startOfMonth(), now()->endOfMonth()],
            'last_month' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
            'custom' => [
                $this->customStartDate ? Chronos::parse($this->customStartDate) : now()->startOfMonth(),
                $this->customEndDate ? Chronos::parse($this->customEndDate) : now()->endOfMonth()
            ],
            default => [now()->startOfMonth(), now()->endOfMonth()]
        };
    }

    public function updatedDateRange()
    {
        if ($this->dateRange !== 'custom') {
            $this->customStartDate = '';
            $this->customEndDate = '';
        }
        $this->resetPage();
        $this->calculateStatistics();
    }

    public function updatedCustomStartDate()
    {
        $this->dateRange = 'custom';
        $this->resetPage();
        $this->calculateStatistics();
    }

    public function updatedCustomEndDate()
    {
        $this->dateRange = 'custom';
        $this->resetPage();
        $this->calculateStatistics();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function calculateStatistics()
    {
        [$startDate, $endDate] = $this->getDateRangeValues();

        $attendances = Auth::user()->attendances()
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $this->totalDays = $attendances->count();
        $this->presentDays = $attendances->where('status', 'present')->count();
        $this->lateDays = $attendances->where('status', 'late')->count();
        $this->earlyLeaves = $attendances->where('status', 'early_leave')->count();
        $this->totalHours = number_format($attendances->sum('working_hours'), 2);
    }

    public function getStatusBadgeColor($status)
    {
        return match ($status) {
            'present' => 'bg-green-100 text-green-800',
            'late' => 'bg-yellow-100 text-yellow-800',
            'early_leave' => 'bg-blue-100 text-blue-800',
            'holiday' => 'bg-purple-100 text-purple-800',
            'pending present' => 'bg-gray-100 text-gray-800'
        };
    }

    public function getWorkingHoursColor($hours)
    {
        if ($hours >= 8) {
            return 'text-green-600';
        } elseif ($hours >= 4) {
            return 'text-yellow-600';
        }
        return 'text-red-600';
    }

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRangeValues();

        $query = Auth::user()->attendances()
            ->whereBetween('date', [$startDate, $endDate])
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->with(['checkInOffice', 'checkOutOffice'])
            ->latest('date');

        return view('livewire.staff.attendance', [
            'attendances' => $query->paginate(10),
            'dateRanges' => [
                'today' => 'Today',
                'yesterday' => 'Yesterday',
                'current_week' => 'Current Week',
                'last_week' => 'Last Week',
                'current_month' => 'Current Month',
                'last_month' => 'Last Month',
                'custom' => 'Custom Range'
            ],
            'statuses' => [
                '' => 'All Status',
                'present' => 'Present',
                'late' => 'Late',
                'early_leave' => 'Early Leave',
                'holiday' => 'Holiday',
                'pending present' => 'Pending'
            ]
        ])->layout('layouts.staff', ['title' => 'Attendance']);
    }
}