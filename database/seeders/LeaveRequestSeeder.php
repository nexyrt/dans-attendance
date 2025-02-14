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
        // Check if we have enough users of each role
        $staffCount = User::where('role', 'staff')->count();
        $managerCount = User::where('role', 'manager')->count();
        $adminCount = User::where('role', 'admin')->count();  // Changed from hrCount
        $directorCount = User::where('role', 'director')->count();

        if ($staffCount === 0 || $managerCount === 0 || $adminCount === 0 || $directorCount === 0) {
            $this->command->error('Missing required users. Please ensure you have users with roles: staff, manager, admin, and director');
            return;
        }

        // Create leave requests with different states
        LeaveRequest::factory()->count(5)->pendingHR()->create();  // We'll keep the function name for now
        LeaveRequest::factory()->count(5)->pendingDirector()->create();
        LeaveRequest::factory()->count(5)->approved()->create();
        LeaveRequest::factory()->count(3)->rejectedByManager()->create();
        LeaveRequest::factory()->count(2)->rejectedByHR()->create();  // We'll keep the function name for now
        LeaveRequest::factory()->count(2)->rejectedByDirector()->create();
        LeaveRequest::factory()->count(3)->cancelled()->create();

        // Mix of leave types
        LeaveRequest::factory()->count(3)->sickLeave()->create();
        LeaveRequest::factory()->count(3)->annualLeave()->create();

        $this->command->info('Leave requests created successfully!');
    }
}