<?php

namespace App\Services;

use App\Models\User;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class LeaveBalanceService
{
    public function checkAvailableBalance(User $user, string $leaveType, float $duration): bool
    {
        // Sick leave doesn't count against balance
        if ($leaveType === 'sick') {
            return true;
        }

        $currentYear = Carbon::now()->year;
        
        // Get or create leave balance for current year
        $balance = LeaveBalance::firstOrCreate(
            [
                'user_id' => $user->id,
                'year' => $currentYear
            ],
            [
                'total_balance' => 12, // Default annual leave balance
                'used_balance' => 0,
                'remaining_balance' => 12
            ]
        );

        // Check if requested duration exceeds remaining balance
        return $balance->remaining_balance >= $duration;
    }

    public function updateLeaveBalance(User $user, float $duration, string $operation = 'subtract'): void
    {
        $currentYear = Carbon::now()->year;
        
        $balance = LeaveBalance::where('user_id', $user->id)
            ->where('year', $currentYear)
            ->first();

        if ($balance) {
            $usedBalance = $operation === 'subtract' 
                ? $balance->used_balance + $duration
                : $balance->used_balance - $duration;

            $balance->update([
                'used_balance' => $usedBalance,
                'remaining_balance' => $balance->total_balance - $usedBalance
            ]);
        }
    }
}