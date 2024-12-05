<?php

namespace App\Livewire\Staff;

use App\Models\Attendance;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceHistory extends Component
{
    public $status = 'all';
    public $startDate;
    public $endDate;

    public function setDateRange($range)
    {
        $now = Carbon::now();

        switch ($range) {
            case 'today':
                $this->startDate = $now->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                break;
            case 'yesterday':
                $this->startDate = $now->subDay()->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                break;
            case 'thisWeek':
                $this->startDate = $now->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->endOfWeek()->format('Y-m-d');
                break;
            case 'lastWeek':
                $this->startDate = $now->subWeek()->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->endOfWeek()->format('Y-m-d');
                break;
            case 'thisMonth':
                $this->startDate = $now->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'lastMonth':
                $this->startDate = $now->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'last30Days':
                $this->startDate = $now->subDays(30)->format('Y-m-d');
                $this->endDate = $now->addDays(30)->format('Y-m-d');
                break;
            case 'last90Days':
                $this->startDate = $now->subDays(90)->format('Y-m-d');
                $this->endDate = $now->addDays(90)->format('Y-m-d');
                break;
        }
    }

    public function resetFilters()
    {
        $this->status = 'all';
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function mount()
    {
        // Set default date range to current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $attendances = Attendance::query()
            ->where('user_id', auth()->id())
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('date', '<=', $this->endDate);
            })
            ->latest('date')
            ->get();

        return view('livewire.staff.attendance-history', [
            'attendances' => $attendances
        ]);
    }
}
