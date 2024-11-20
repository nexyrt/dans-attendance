<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // Get all existing users
            $users = User::all();
            $currentYear = now()->year;

            foreach ($users as $user) {
                // Create or find balance for current year
                LeaveBalance::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'year' => $currentYear,
                    ],
                    [
                        'total_balance' => 365,
                        'used_balance' => 0,
                        'remaining_balance' => 365
                    ]
                );
            }

            // Calculate used days from approved leave requests
            $leaveRequests = LeaveRequest::where('status', 'approved')
                ->whereYear('start_date', $currentYear)
                ->get()
                ->groupBy('user_id');

            foreach ($leaveRequests as $userId => $requests) {
                $usedDays = $requests->sum(function ($leave) {
                    return Carbon::parse($leave->start_date)
                        ->diffInDays(Carbon::parse($leave->end_date)) + 1;
                });

                if ($usedDays > 0) {
                    LeaveBalance::where('user_id', $userId)
                        ->where('year', $currentYear)
                        ->update([
                            'used_balance' => $usedDays,
                            'remaining_balance' => 365 - $usedDays
                        ]);
                }
            }

        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            \Log::error('Error in LeaveBalanceSeeder: ' . $e->getMessage());
            throw $e;
        }
    }
}
