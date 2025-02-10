<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LeaveBalance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\LeaveRequest;

class LeaveBalanceSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing leave balances
        LeaveBalance::truncate();

        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            // Create one leave balance record for each user for current year
            LeaveBalance::create([
                'user_id' => $user->id,
                'year' => now()->year,
                'total_balance' => 12, // Default annual leave balance
                'used_balance' => 0,
                'remaining_balance' => 12
            ]);
        }
    }
}
