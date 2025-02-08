<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\OfficeLocation;
use App\Models\User;
use Cake\Chronos\Chronos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    protected int $recordsPerUserPerMonth = 20; // Approximately 20 working days per month

    public function run(): void
    {
        // First ensure we have at least one office location
        if (OfficeLocation::count() === 0) {
            OfficeLocation::create([
                'name' => 'JKB Main Office',
                'latitude' => -0.47902890,
                'longitude' => 117.1401699,
                'radius' => 100,
                'address' => 'Jalan Delima Dalam, Blok E No.1'
            ]);
        }

        // Get all users except admins
        $users = User::whereIn('role', ['staff', 'manager'])->get();
        
        // Generate attendance for the last 3 months
        $startDate = Chronos::now()->subMonths(3);
        $endDate = Chronos::now();
        $monthCount = 3;

        // Calculate total records to create
        $totalRecords = count($users) * $this->recordsPerUserPerMonth * $monthCount;
        $this->command->info("Creating {$totalRecords} attendance records...");

        foreach ($users as $user) {
            $currentDate = clone $startDate;

            // Generate records for each month
            for ($month = 0; $month < $monthCount; $month++) {
                // Create exactly recordsPerUserPerMonth records for each month
                $recordsCreated = 0;
                
                while ($recordsCreated < $this->recordsPerUserPerMonth) {
                    // Skip weekends
                    if ($currentDate->isWeekend()) {
                        $currentDate = $currentDate->addDays(1);
                        continue;
                    }

                    Attendance::factory()->create([
                        'user_id' => $user->id,
                        'date' => $currentDate->format('Y-m-d'),
                    ]);

                    $recordsCreated++;
                    $currentDate = $currentDate->addDays(1);
                }
            }
        }

        $this->command->info('Attendance records created successfully!');
    }
}
