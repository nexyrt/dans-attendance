<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\LeaveBalance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            UsersTableSeeder::class,
            AttendanceTableSeeder::class,
            ScheduleSeeder::class,
            HolidaySeeder::class,
            ScheduleExceptionSeeder::class,
            LeaveRequestSeeder::class,
        ]);
        LeaveBalance::factory()->count(20)->create();

    }
}
