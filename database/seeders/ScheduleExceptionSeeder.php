<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\ScheduleException;
use Illuminate\Database\Seeder;

class ScheduleExceptionSeeder extends Seeder
{
    public function run(): void
    {
        ScheduleException::factory(20)->create()->each(function ($exception) {
            // Attach 1-3 random departments to each exception
            $departments = Department::inRandomOrder()
                ->take(rand(1, 3))
                ->get();

            $exception->departments()->attach($departments);
        });
    }
}