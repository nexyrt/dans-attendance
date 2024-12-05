<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MiniCalendar extends Component
{
    public $weeks;
    public $month;
    public $year;
    public $events;

    public function __construct($events = [])
    {
        $this->events = $events;
        $this->month = request('month', Carbon::now()->month);
        $this->year = request('year', Carbon::now()->year);
        $this->generateCalendar();
    }

    private function generateCalendar()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1);
        $daysInMonth = $date->daysInMonth;
        $firstDayOfWeek = $date->copy()->firstOfMonth()->dayOfWeek;
        
        $weeks = [];
        $week = array_fill(0, 7, null);
        $dayCount = 1;

        // Fill first week with empty days until first day of month
        for ($i = $firstDayOfWeek; $i < 7 && $dayCount <= $daysInMonth; $i++) {
            $week[$i] = $dayCount++;
        }
        $weeks[] = $week;

        // Fill remaining weeks
        while ($dayCount <= $daysInMonth) {
            $week = array_fill(0, 7, null);
            for ($i = 0; $i < 7 && $dayCount <= $daysInMonth; $i++) {
                $week[$i] = $dayCount++;
            }
            $weeks[] = $week;
        }

        $this->weeks = $weeks;
    }

    public function render()
    {
        return view('components.mini-calendar');
    }
}
