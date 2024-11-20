<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            AttendanceTableSeeder::class,
            ScheduleSeeder::class,
            DepartmentSeeder::class,
            HolidaySeeder::class,
            ScheduleExceptionSeeder::class,
        ]);
    }
}
