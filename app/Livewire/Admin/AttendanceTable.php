<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Attendance;

use App\Models\Department;
use PHPUnit\Logging\Exception;
use Illuminate\Support\Facades\Log;

class AttendanceTable extends Component
{
    public $search = '';
    public $department = '';
    public $selectedMonth;

    public $selectedPeriod = 'today';
    public $selectedWeek = 'current';


    protected $queryString = ['search', 'department', 'selectedMonth', 'selectedPeriod', 'selectedWeek'];

    protected $listeners = ['refreshCharts' => 'emitChartData', 'updateCharts' => '$refresh'];

    public function updatedSelectedPeriod()
    {
        $this->emitChartData();
    }

    public function updatedSelectedWeek()
    {
        $this->emitChartData();
    }

    public function emitChartData()
    {
        $this->dispatch('updateCharts', $this->getChartData());
    }

    public function getChartData()
    {
        try {
            $data = $this->getFilteredAttendanceData();

            // Calculate statistics
            $onTimeCount = $data->where('status', 'present')->count();
            $lateCount = $data->where('status', 'late')->count();
            $total = $onTimeCount + $lateCount;

            // If no data, return placeholder values
            if ($total === 0) {
                return [
                    'pieChart' => [
                        'series' => [100], // Single value for "No Data"
                        'labels' => ['No Data Available']
                    ],
                    'barChart' => [
                        'series' => [
                            [
                                'name' => 'On Time',
                                'data' => array_fill(0, 7, 0)
                            ],
                            [
                                'name' => 'Late',
                                'data' => array_fill(0, 7, 0)
                            ]
                        ],
                        'categories' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    ]
                ];
            }

            $weeklyData = $this->getWeeklyData($this->selectedWeek ?? 'current');

            return [
                'pieChart' => [
                    'series' => [
                        round(($onTimeCount / $total) * 100, 1),
                        round(($lateCount / $total) * 100, 1)
                    ],
                    'labels' => ['On Time', 'Late']
                ],
                'barChart' => [
                    'series' => [
                        [
                            'name' => 'On Time',
                            'data' => array_values($weeklyData['onTime'])
                        ],
                        [
                            'name' => 'Late',
                            'data' => array_values($weeklyData['late'])
                        ]
                    ],
                    'categories' => array_keys($weeklyData['onTime'])
                ]
            ];
        } catch (Exception $e) {
            Log::error('Error in getChartData: ' . $e->getMessage());
            return $this->getPlaceholderData();
        }
    }

    private function getPlaceholderData()
    {
        return [
            'pieChart' => [
                'series' => [100],
                'labels' => ['No Data Available']
            ],
            'barChart' => [
                'series' => [
                    [
                        'name' => 'On Time',
                        'data' => array_fill(0, 7, 0)
                    ],
                    [
                        'name' => 'Late',
                        'data' => array_fill(0, 7, 0)
                    ]
                ],
                'categories' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            ]
        ];
    }

    public function getFilteredAttendanceData()
    {
        $query = match ($this->selectedPeriod) {
            'today' => Attendance::where('date', now()->format('Y-m-d')),
            'week' => Attendance::whereBetween('date', [
                now()->startOfWeek()->format('Y-m-d'),
                now()->endOfWeek()->format('Y-m-d')
            ]),
            'month' => Attendance::whereBetween('date', [
                now()->startOfMonth()->format('Y-m-d'),
                now()->endOfMonth()->format('Y-m-d')
            ]),
            default => $this->attendances
        };
        return $query->get();
    }

    private function getWeeklyData($weekSelection)
    {
        $startDate = match ($weekSelection) {
            'last' => now()->subWeek()->startOfWeek(),
            'previous' => now()->subWeeks(2)->startOfWeek(),
            default => now()->startOfWeek()
        };

        $dates = collect(range(0, 6))->map(fn($day) => $startDate->copy()->addDays($day));

        $onTime = [];
        $late = [];

        foreach ($dates as $date) {
            $dayName = $date->format('D');
            $dayAttendances = Attendance::where('date', $date->format('Y-m-d'));

            $onTime[$dayName] = $dayAttendances->where('status', 'present')->count();
            $late[$dayName] = $dayAttendances->where('status', 'late')->count();
        }

        return [
            'onTime' => $onTime,
            'late' => $late
        ];
    }

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


    public function render()
    {
        $date = Carbon::createFromFormat('Y-m', $this->selectedMonth);

        $attendances = Attendance::query()
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->department, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('department_id', $this->department);
                });
            })
            ->with('user')
            ->latest('date')
            ->get();

        $departments = Department::get()
            ->filter()
            ->unique()
            ->values();

        $availableMonths = collect(range(0, 11))->map(function ($i) {
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
