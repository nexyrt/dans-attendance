<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\ScheduleException;
use Illuminate\Database\Seeder;

class ScheduleExceptionSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Team Meeting',
            'Project Discussion',
            'Client Presentation',
            'Weekly Report Review',
            'Brainstorming Session',
            'Staff Training',
            'Department Update',
            'Budget Planning',
            'Performance Review',
            'Strategy Meeting'
        ];

        // Create 20 schedule exceptions using your specific data
        foreach (range(1, 20) as $index) {
            $exception = ScheduleException::create([
                'title' => $titles[array_rand($titles)],
                'date' => now()->addDays($index),
                'start_time' => '08:00:00',
                'end_time' => '16:00:00',
                'status' => ['regular', 'wfh', 'halfday', 'holiday'][array_rand(['regular', 'wfh', 'halfday', 'holiday'])],
                'note' => $index % 3 === 0 ? 'Special case for this day' : null,
            ]);

            // Attach 1-3 random departments to each exception
            $departments = Department::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');

            $exception->departments()->attach($departments);
        }
    }
}