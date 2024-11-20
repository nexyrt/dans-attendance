<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LeaveBalance;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\LeaveRequest;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Get all existing users
        $users = User::all();

        foreach ($users as $user) {
            // Create current year balance
            $currentYearBalance = LeaveBalance::create([
                'user_id' => $user->id,
                'year' => Carbon::now()->year,
                'total_balance' => 12, // Default annual leave balance
                'used_balance' => 0,
                'remaining_balance' => 12
            ]);

            // Calculate and update used balance based on existing leave requests
            $usedDays = LeaveRequest::where('user_id', $user->id)
                ->where('status', 'approved')
                ->where('type', 'annual')
                ->whereYear('start_date', Carbon::now()->year)
                ->get()
                ->sum(function ($leave) {
                    return $leave->start_date->diffInDays($leave->end_date) + 1;
                });

            if ($usedDays > 0) {
                $currentYearBalance->updateBalance($usedDays);
            }

            // Create previous year balance with random usage
            LeaveBalance::create([
                'user_id' => $user->id,
                'year' => Carbon::now()->subYear()->year,
                'total_balance' => 12,
                'used_balance' => rand(0, 12),
                'remaining_balance' => rand(0, 12)
            ]);
        }
    }
}
