<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveRequestSeeder extends Seeder
{
    public function run()
    {
        // Get existing users
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->error('No existing users found. Please seed users first.');
            return;
        }

        // Get a random user as manager/approver
        $manager = $users->random();

        // Create various types of leave requests for each user
        foreach ($users as $user) {

            // Skip if the user is the manager
            if ($user->id === $manager->id) {
                continue;
            }

            
            // Pending leave requests
            LeaveRequest::factory()
                ->count(2)
                ->pending()
                ->create([
                    'user_id' => $user->id
                ]);

            // Approved leave requests
            LeaveRequest::factory()
                ->count(3)
                ->approved()
                ->create([
                    'user_id' => $user->id,
                    'approved_by' => $manager->id
                ]);

            // Rejected leave requests
            LeaveRequest::factory()
                ->count(1)
                ->rejected()
                ->create([
                    'user_id' => $user->id,
                    'approved_by' => $manager->id
                ]);

            // Specific types of leaves
            // Sick leave
            LeaveRequest::factory()
                ->sickLeave()
                ->create([
                    'user_id' => $user->id,
                    'start_date' => now()->subDays(5),
                    'end_date' => now()->subDays(3)
                ]);

            // Annual leave
            LeaveRequest::factory()
                ->annualLeave()
                ->create([
                    'user_id' => $user->id
                ]);
        }

        // Create some upcoming leave requests
        LeaveRequest::factory()
            ->count(5)
            ->pending()
            ->create([
                'start_date' => now()->addDays(random_int(1, 30)),
                'user_id' => $users->random()->id
            ]);
    }
}
