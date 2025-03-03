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
        LeaveBalance::truncate();

        $users = User::all();
        $currentYear = now()->year;

        foreach ($users as $user) {
            LeaveBalance::create([
                'user_id' => $user->id,
                'year' => $currentYear,
                'total_balance' => 12, // Annual leave
                'used_balance' => 0,
                'remaining_balance' => 12
            ]);
        }
    }
}
