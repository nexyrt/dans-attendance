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

        $users = User::all();
        $currentYear = Carbon::now()->year;
        $previousYear = Carbon::now()->subYear()->year;

        foreach ($users as $user) {
            // Create current year balance
            $currentYearBalance = LeaveBalance::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'year' => $currentYear,
                ],
                [
                    'total_balance' => 12,
                    'used_balance' => 0,
                    'remaining_balance' => 12
                ]
            );

            // Calculate used balance for current year
            $usedDays = LeaveRequest::where('user_id', $user->id)
                ->where('status', 'approved')
                ->where('type', 'annual')
                ->whereYear('start_date', $currentYear)
                ->get()
                ->sum(function ($leave) {
                    return $leave->start_date->diffInDays($leave->end_date) + 1;
                });

            if ($usedDays > 0) {
                $currentYearBalance->used_balance = $usedDays;
                $currentYearBalance->remaining_balance = $currentYearBalance->total_balance - $usedDays;
                $currentYearBalance->save();
            }

            // Create previous year balance
            $usedBalance = rand(0, 12);
            LeaveBalance::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'year' => $previousYear,
                ],
                [
                    'total_balance' => 12,
                    'used_balance' => $usedBalance,
                    'remaining_balance' => 12 - $usedBalance
                ]
            );
        }
    }
}
