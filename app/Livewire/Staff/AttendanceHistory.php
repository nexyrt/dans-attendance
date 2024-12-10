<?php

namespace App\Livewire\Staff;

use App\Models\Attendance;
use App\Helpers\DateTimeHelper;
use Cake\Chronos\Chronos;
use Livewire\Component;

class AttendanceHistory extends Component
{
    public $status = 'all';
    public $startDate;
    public $endDate;

    public function setDateRange($range)
    {
        $now = Chronos::now();

        if (!$now instanceof Chronos) {
            $now = Chronos::parse($now);
        }

        switch ($range) {
            case 'today':
                $this->startDate = $now->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                break;
        
            case 'yesterday':
                $this->startDate = $now->modify('-1 day')->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                break;
        
            case 'thisWeek':
                $this->startDate = $now->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->endOfWeek()->format('Y-m-d');
                break;
        
            case 'lastWeek':
                $this->startDate = $now->modify('-1 week')->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->endOfWeek()->format('Y-m-d');
                break;
        
            case 'thisMonth':
                $this->startDate = $now->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
        
            case 'lastMonth':
                $this->startDate = $now->modify('-1 month')->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
        
            case 'last30Days':
                $this->startDate = $now->modify('-30 days')->format('Y-m-d');
                $this->endDate = $now->modify('+30 days')->format('Y-m-d');
                break;
        
            case 'last90Days':
                $this->startDate = $now->modify('-90 days')->format('Y-m-d');
                $this->endDate = $now->modify('+90 days')->format('Y-m-d');
                break;
        }
    }

    public function resetFilters()
    {
        $this->status = 'all';
        $this->startDate = Chronos::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Chronos::now()->endOfMonth()->format('Y-m-d');
    }

    public function mount()
    {
        // Set default date range to current month
        $this->startDate = Chronos::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Chronos::now()->endOfMonth()->format('Y-m-d');
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