<?php

namespace App\Livewire\Staff;

use App\Models\Attendance as AttendanceModel;
use Cake\Chronos\Chronos;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination;

    public $month;
    public $year;

    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
    }

    public function render()
    {
        $attendances = AttendanceModel::query()
            ->where('user_id', auth()->id())
            ->whereMonth('date', $this->month)
            ->whereYear('date', $this->year)
            ->orderBy('date', 'desc')
            ->paginate(10);

        // Format months for dropdown
        $monthsDropdown = [
            [
                collect(range(1, 12))->map(function ($month) {
                    return [
                        'value' => (string) $month, // Cast to string to avoid type issues
                        'label' => Chronos::create(null, $month)->format('F'),
                        'class' => $this->month === $month ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50'
                    ];
                })->toArray()
            ]
        ];

        // Format years for dropdown
        $yearsDropdown = [
            [
                collect(range(now()->year, now()->year - 2))->map(function ($year) {
                    return [
                        'value' => (string) $year, // Cast to string to avoid type issues
                        'label' => (string) $year,
                        'class' => $this->year === $year ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-50'
                    ];
                })->toArray()
            ]
        ];

        return view('livewire.staff.attendance', [
            'attendances' => $attendances,
            'monthsDropdown' => $monthsDropdown,
            'yearsDropdown' => $yearsDropdown
        ])->layout('layouts.staff', ['title' => 'Attendance']);
    }
}