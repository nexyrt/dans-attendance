<?php

namespace App\Livewire\Admin\Attendances;

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

    public $page = 1; // Add this line

    protected $paginationTheme = 'tailwind';
    public $perPage = 10;


    public $filters = [
        'department' => '',
        'status' => '',
        'search' => '',
        'startDate' => '',
        'endDate' => '',
    ];

    public $activeFilters = [];

    protected $queryString = [
        'filters' => [
            'except' => [
                'department' => '',
                'status' => '',
                'search' => '',
            ]
        ],
    ];

    // Add method to get filtered data without pagination
    private function getFilteredData()
    {
        return Attendance::query()
            ->with(['user', 'user.department'])
            ->latest('date')
            ->get();
    }

    public function exportToCSV()
    {
        $attendances = $this->getFilteredData();

        $csvData = [];
        $csvData[] = [
            'Employee Name',
            'Email',
            'Position',
            'Department',
            'Date',
            'Check In',
            'Check Out',
            'Status'
        ];

        foreach ($attendances as $attendance) {
            $csvData[] = [
                $attendance->user->name,
                $attendance->user->email,
                $attendance->user->position,
                $attendance->user->department->name,
                Carbon::parse($attendance->date)->format('M d, Y'),
                Carbon::parse($attendance->check_in)->format('h:i A'),
                $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : 'Not checked out',
                ucfirst($attendance->status)
            ];
        }

        $timestamp = Carbon::now()->format('Y-m-d-H-i-s');
        $filename = "attendance-records-{$timestamp}.csv";

        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function printData()
    {
        $attendances = $this->getFilteredData();

        // Dispatch browser event with data
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
        $now = Carbon::now();

        switch ($range) {
            case 'today':
                $this->filters['startDate'] = $now->format('Y-m-d');
                $this->filters['endDate'] = $now->format('Y-m-d');
                break;
            case 'yesterday':
                $this->filters['startDate'] = $now->subDay()->format('Y-m-d');
                $this->filters['endDate'] = $now->format('Y-m-d');
                break;
            case 'thisWeek':
                $this->filters['startDate'] = $now->startOfWeek()->format('Y-m-d');
                $this->filters['endDate'] = $now->endOfWeek()->format('Y-m-d');
                break;
            case 'lastWeek':
                $this->filters['startDate'] = $now->subWeek()->startOfWeek()->format('Y-m-d');
                $this->filters['endDate'] = $now->endOfWeek()->format('Y-m-d');
                break;
            case 'thisMonth':
                $this->filters['startDate'] = $now->startOfMonth()->format('Y-m-d');
                $this->filters['endDate'] = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'lastMonth':
                $this->filters['startDate'] = $now->subMonth()->startOfMonth()->format('Y-m-d');
                $this->filters['endDate'] = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'last30Days':
                $this->filters['startDate'] = $now->subDays(30)->format('Y-m-d');
                $this->filters['endDate'] = $now->addDays(30)->format('Y-m-d');
                break;
            case 'last90Days':
                $this->filters['startDate'] = $now->subDays(90)->format('Y-m-d');
                $this->filters['endDate'] = $now->addDays(90)->format('Y-m-d');
                break;
        }
    }

    public function dateSelected($startDate, $endDate)
    {
        $this->filters['startDate'] = $startDate;
        $this->filters['endDate'] = $endDate;
        $this->showDatePicker = false;
    }

    public function applyFilters()
    {
        $this->activeFilters = array_filter($this->filters);
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->activeFilters = [];
    }

    public function removeFilter($key)
    {
        $this->filters[$key] = '';
        unset($this->activeFilters[$key]);
    }

    public function mount()
    {
        // Set default date range to current month
        $this->filters['startDate'] = Carbon::now()->format('Y-m-d');
        $this->filters['endDate'] = Carbon::now()->format('Y-m-d');
    }

    public function getFilteredAttendancesProperty()
    {
        $query = Attendance::query()
            ->with(['user', 'user.department']);

        if ($this->filters['department']) {
            $query->whereHas('user', function ($q) {
                $q->where('department_id', $this->filters['department']);
            });
        }

        if ($this->filters['status']) {
            $query->where('status', $this->filters['status']);
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
            })
            ->latest('date');

        return $query->latest();
    }



    public function getStatistics()
    {
        $date = match ($this->selectedPeriod) {
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            default => Carbon::today()
        };

        // Get the end date (current time)
        $endDate = Carbon::now();

        // @dd(Attendance::whereBetween('date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
        //         ->where('status', 'late')->get());
        return [
            'total_present' => Attendance::whereBetween('date', [$date, $endDate])
                ->where('status', 'present')
                ->count(),
            'total_late' => Attendance::where('date', '>=', $date)
                ->where('status', '=', 'late')
                ->count(),
            'average_check_in' => Attendance::where('date', '>=', $date)
                ->whereNotNull('check_in')
                ->avg('check_in'),
            'pending_checkouts' => Attendance::where('date', '>=', $date)
                ->where('status', '=', 'pending present')
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
                ->where('status', '!=', 'present')
                ->latest()
                ->take(5)
                ->get(),
            'pending' => Attendance::with('user')
                ->whereNull('check_out')
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
            'attendances' => $this->getFilteredAttendancesProperty()->latest('date')->paginate($this->perPage),
            'departments' => Department::all(),
            'statistics' => $this->getStatistics()
        ]);
    }
}
