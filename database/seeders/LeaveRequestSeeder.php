<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have some users first
        if (User::count() === 0) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        // Create 20 leave requests with different states
        LeaveRequest::factory()->count(8)->pending()->create();
        LeaveRequest::factory()->count(7)->approved()->create();
        LeaveRequest::factory()->count(3)->rejected()->create();
        LeaveRequest::factory()->count(2)->state(['status' => 'cancel'])->create();

        $this->command->info('20 Leave requests created successfully!');
    }
}
