<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\User;
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
            ScheduleSeeder::class,
            ScheduleExceptionSeeder::class,
            OfficeLocationSeeder::class,
            SalaryHistorySeeder::class,
            AttendanceSeeder::class,
            LeaveRequestSeeder::class,
            LeaveBalanceSeeder::class
        ]);

    }
}
