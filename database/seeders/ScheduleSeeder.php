<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $startTime = '08:00:00'; // Default start time
        $endTime = '16:00:00';   // Default end time
        $lateTolerance = 30;     // Default late tolerance

        foreach ($weekdays as $day) {
            Schedule::create([
                'day_of_week' => $day,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'late_tolerance' => $lateTolerance,
            ]);
        }
    }
}
