<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateRangePicker extends Component
{
    public $startDate;
    public $endDate;
    public $currentMonth;
    public $currentYear;
    public $calendar = [];
    public $months = [];
    public $years = [];
    public $isOpen = false;
    public $selecting = 'start'; // Track which date we're selecting

    public function mount($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate ?? now()->format('Y-m-d');
        $this->endDate = $endDate ?? now()->format('Y-m-d');
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        
        // Generate months array
        for ($i = 1; $i <= 12; $i++) {
            $this->months[] = [
                'value' => $i,
                'label' => Carbon::create()->month($i)->format('F')
            ];
        }

        // Generate years array (5 years before and after current year)
        $this->years = range($this->currentYear - 5, $this->currentYear + 5);
        
        $this->generateCalendar();
    }

    public function generateCalendar()
    {
        $start = Carbon::create($this->currentYear, $this->currentMonth)->startOfMonth();
        $end = Carbon::create($this->currentYear, $this->currentMonth)->endOfMonth();

        // Get the start of the first week (Monday)
        $start = $start->copy()->startOfWeek(Carbon::MONDAY);
        // Get the end of the last week (Sunday)
        $end = $end->copy()->endOfWeek(Carbon::SUNDAY);

        $period = CarbonPeriod::create($start, $end);
        $weeks = [];
        $currentWeek = [];

        foreach ($period as $date) {
            if (count($currentWeek) === 7) {
                $weeks[] = $currentWeek;
                $currentWeek = [];
            }

            $currentWeek[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('j'),
                'isCurrentMonth' => $date->month === (int)$this->currentMonth,
                'isSelected' => $this->isDateInRange($date),
                'isStart' => $date->format('Y-m-d') === $this->startDate,
                'isEnd' => $date->format('Y-m-d') === $this->endDate,
                'isToday' => $date->isToday(),
            ];
        }

        if (!empty($currentWeek)) {
            $weeks[] = $currentWeek;
        }

        $this->calendar = $weeks;
    }

    protected function isDateInRange($date)
    {
        if (!$this->startDate || !$this->endDate) {
            return false;
        }

        $dateStr = $date->format('Y-m-d');
        return $dateStr >= $this->startDate && $dateStr <= $this->endDate;
    }

    public function updatedCurrentMonth()
    {
        $this->generateCalendar();
    }

    public function updatedCurrentYear()
    {
        $this->generateCalendar();
    }

    public function previousMonth()
    {
        if ($this->currentMonth === 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
        $this->generateCalendar();
    }

    public function nextMonth()
    {
        if ($this->currentMonth === 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
        $this->generateCalendar();
    }

    public function selectDate($date)
    {
        // If selecting start date or resetting selection
        if ($this->selecting === 'start' || ($this->startDate && $this->endDate)) {
            $this->startDate = $date;
            $this->endDate = null;
            $this->selecting = 'end';
        } 
        // If selecting end date
        else {
            // If selected date is before start date, swap them
            if ($date < $this->startDate) {
                $this->endDate = $this->startDate;
                $this->startDate = $date;
            } else {
                $this->endDate = $date;
            }
            $this->selecting = 'start';
        }

        $this->generateCalendar();
        
        // Only dispatch update if we have both dates
        if ($this->startDate && $this->endDate) {
            $this->dispatch('dates-updated', [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate
            ]);
        }
    }

    public function applyDates()
    {
        if ($this->startDate && $this->endDate) {
            $this->dispatch('date-range-selected', [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate
            ]);
            $this->isOpen = false;
        }
    }

    public function getFormattedDateRangeProperty()
    {
        if (!$this->startDate) {
            return 'Select dates';
        }
        
        $start = Carbon::parse($this->startDate)->format('M d, Y');
        if (!$this->endDate) {
            return $start . ' - Select end date';
        }
        
        return $start . ' - ' . Carbon::parse($this->endDate)->format('M d, Y');
    }

    public function render()
    {
        return view('livewire.date-range-picker');
    }
}