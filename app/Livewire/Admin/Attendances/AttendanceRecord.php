<?php

namespace App\Livewire\Admin\Attendances;

use App\Exports\AttendancesExport;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Attendance;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;

class AttendanceRecord extends Component
{
    use WithPagination;

    public $selectedPeriod = 'today';
    public $startDate;
    public $endDate;
    public $showDetailModal = false;
    public $detailType = '';
    public $detailData = [];
    public $chartData = [];
    public $showDatePicker = false;
    protected $listeners = ['refresh' => '$refresh', 'dateSelected'];

    public $page = 1;
    protected $paginationTheme = 'tailwind';
    public $perPage = 10;

    public $filters = [
        'department' => [],  // Changed to array for multi-select
        'status' => [],      // Changed to array for multi-select
        'search' => '',
        'startDate' => '',
        'endDate' => '',
    ];

    public $activeFilters = [];

    protected $queryString = [
        'filters' => [
            'except' => [
                'department' => [],
                'status' => [],
                'search' => '',
                'startDate' => '',
                'endDate' => '',
            ]
        ],
    ];

    // Add method to handle filter updates
    public function updatedFilters($value, $key)
    {
        // Clear empty values from arrays
        if (is_array($value)) {
            $value = array_filter($value);
        }

        // Update activeFilters
        if (empty($value)) {
            unset($this->activeFilters[$key]);
        } else {
            $this->activeFilters[$key] = $value;
        }

        // Special handling for date range
        if ($key === 'startDate' || $key === 'endDate') {
            if (!empty($this->filters['startDate']) && !empty($this->filters['endDate'])) {
                $this->activeFilters['startDate'] = $this->filters['startDate'];
                $this->activeFilters['endDate'] = $this->filters['endDate'];
            } else {
                unset($this->activeFilters['startDate'], $this->activeFilters['endDate']);
            }
        }

        $this->resetPage();
    }

    public function removeFilterValue($key, $value)
    {
        if (isset($this->filters[$key]) && is_array($this->filters[$key])) {
            $this->filters[$key] = array_filter($this->filters[$key], function ($v) use ($value) {
                return $v !== $value;
            });

            if (empty($this->filters[$key])) {
                unset($this->activeFilters[$key]);
            } else {
                $this->activeFilters[$key] = $this->filters[$key];
            }
        }
        $this->resetPage();
    }

    public function removeFilter($key)
    {
        if ($key === 'startDate' || $key === 'endDate') {
            $this->filters['startDate'] = '';
            $this->filters['endDate'] = '';
            unset($this->activeFilters['startDate'], $this->activeFilters['endDate']);
        } else {
            $this->filters[$key] = is_array($this->filters[$key]) ? [] : '';
            unset($this->activeFilters[$key]);
        }
        $this->resetPage();
    }

    private function getFilteredData()
    {
        return $this->getFilteredAttendancesProperty()->get();
    }

    public function exportToExcell()
    {
        $filters = [
            'startDate' => $this->filters['startDate'] ?? null,
            'endDate' => $this->filters['endDate'] ?? null,
            'department' => $this->filters['department'] ?? null,
            'status' => $this->filters['status'] ?? null,
            'search' => $this->filters['search'] ?? null
        ];

        return (new AttendancesExport($filters))->download('attendance-records-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function printData()
    {
        $attendances = $this->getFilteredData();

        $this->dispatch(
            'print-attendance',
            attendances: $attendances->map(function ($attendance) {
                return [
                    'name' => $attendance->user->name,
                    'email' => $attendance->user->email,
                    'position' => $attendance->user->position,
                    'department' => $attendance->user->department->name,
                    'date' => Carbon::parse($attendance->date)->format('M d, Y'),
                    'check_in' => Carbon::parse($attendance->check_in)->format('h:i A'),
                    'check_out' => $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : 'Not checked out',
                    'status' => ucfirst($attendance->status)
                ];
            })->toArray()
        );
    }

    public function setDateRange($range)
    {
        $this->filters['startDate'] = match ($range) {
            'today' => now()->format('Y-m-d'),
            'yesterday' => now()->subDay()->format('Y-m-d'),
            'thisWeek' => now()->startOfWeek()->format('Y-m-d'),
            'lastWeek' => now()->subWeek()->startOfWeek()->format('Y-m-d'),
            'thisMonth' => now()->startOfMonth()->format('Y-m-d'),
            'lastMonth' => now()->subMonth()->startOfMonth()->format('Y-m-d'),
            'last30Days' => now()->subDays(30)->format('Y-m-d'),
            'last90Days' => now()->subDays(90)->format('Y-m-d'),
        };

        $this->filters['endDate'] = match ($range) {
            'today' => now()->format('Y-m-d'),
            'yesterday' => now()->subDay()->format('Y-m-d'),
            'thisWeek' => now()->endOfWeek()->format('Y-m-d'),
            'lastWeek' => now()->subWeek()->endOfWeek()->format('Y-m-d'),
            'thisMonth' => now()->endOfMonth()->format('Y-m-d'),
            'lastMonth' => now()->subMonth()->endOfMonth()->format('Y-m-d'),
            'last30Days' => now()->format('Y-m-d'),
            'last90Days' => now()->format('Y-m-d'),
        };
    }

    public function dateSelected($startDate, $endDate)
    {
        $this->filters['startDate'] = $startDate;
        $this->filters['endDate'] = $endDate;
        $this->showDatePicker = false;
    }

    public function resetFilters()
    {
        $this->filters = [
            'department' => [],
            'status' => [],
            'search' => '',
            'startDate' => now()->format('Y-m-d'),
            'endDate' => now()->format('Y-m-d'),
        ];
        $this->activeFilters = [];
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function mount()
    {
        // Set default date range to current day
        $this->filters['startDate'] = Carbon::now()->format('Y-m-d');
        $this->filters['endDate'] = Carbon::now()->format('Y-m-d');
    }

    public function getFilteredAttendancesProperty()
    {
        $query = Attendance::query()
            ->with(['user', 'user.department']);

        // Handle multi-select department filter
        if (!empty($this->filters['department'])) {
            $query->whereHas('user', function ($q) {
                $q->whereIn('department_id', $this->filters['department']);
            });
        }

        // Handle multi-select status filter
        if (!empty($this->filters['status'])) {
            $query->whereIn('status', $this->filters['status']);
        }

        if ($this->filters['search']) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $this->filters['search'] . '%');
            });
        }

        $query->when($this->filters['startDate'], function ($query) {
            $query->whereDate('date', '>=', $this->filters['startDate']);
        })
        ->when($this->filters['endDate'], function ($query) {
            $query->whereDate('date', '<=', $this->filters['endDate']);
        });

        return $query->latest('date');
    }

    public function getStatistics()
    {
        $date = match ($this->selectedPeriod) {
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            default => Carbon::today()
        };

        $endDate = Carbon::now();

        return [
            'total_present' => Attendance::whereBetween('date', [$date, $endDate])
                ->where('status', 'present')
                ->count(),
            'total_late' => Attendance::where('date', '>=', $date)
                ->where('status', 'late')
                ->count(),
            'average_check_in' => Attendance::where('date', '>=', $date)
                ->whereNotNull('check_in')
                ->avg('check_in'),
            'early_leave_checkouts' => Attendance::where('date', '>=', $date)
                ->where('status', 'early_leave')
                ->count(),
            'attendance_rate' => $this->calculateAttendanceRate($date),
        ];
    }

    private function calculateAttendanceRate($date)
    {
        $total = Attendance::where('date', '>=', $date)->count();
        $present = Attendance::where('date', '>=', $date)
            ->where('status', 'present')
            ->count();

        return $total > 0 ? round(($present / $total) * 100) : 0;
    }

    public function showDetail($type)
    {
        $this->detailType = $type;
        $this->detailData = match ($type) {
            'present' => Attendance::with('user')
                ->where('status', 'present')
                ->latest()
                ->take(5)
                ->get(),
            'late' => Attendance::with('user')
                ->where('status', 'late')
                ->latest()
                ->take(5)
                ->get(),
            'early_leave' => Attendance::with('user')
                ->where('status', 'early_leave')
                ->latest()
                ->take(5)
                ->get(),
            default => []
        };

        $this->showDetailModal = true;
    }

    public function render()
    {
        return view('livewire.admin.attendances.attendance-record', [
            'attendances' => $this->getFilteredAttendancesProperty()->paginate($this->perPage),
            'departments' => Department::all(),
            'statistics' => $this->getStatistics()
        ]);
    }
}