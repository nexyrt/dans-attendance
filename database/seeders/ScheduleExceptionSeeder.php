<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use App\Models\ScheduleException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleExceptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all department IDs to assign them randomly
        $departmentIds = Department::pluck('id')->toArray();

        // Seed 10 schedule exceptions
        foreach (range(1, 10) as $index) {
            ScheduleException::create([
                'date' => now()->addDays($index), // Example: Adds sequential dates starting today
                'start_time' => $index % 2 === 0 ? '08:00:00' : null, // Alternate between set and null
                'end_time' => $index % 2 === 0 ? '16:00:00' : null,
                'department_id' => $departmentIds[array_rand($departmentIds)], // Random department
                'status' => ['regular', 'wfh', 'halfday'][array_rand(['regular', 'wfh', 'halfday'])], // Random status
                'note' => $index % 3 === 0 ? 'Special case for this day' : null, // Optional note
            ]);
        }
    }
}
