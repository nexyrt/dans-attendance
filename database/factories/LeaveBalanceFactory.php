<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveBalance>
 */
class LeaveBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalBalance = 12; // Default annual leave balance
        $usedBalance = $this->faker->numberBetween(0, $totalBalance);
        
        return [
            'user_id' => User::factory(),
            'year' => now()->year,
            'total_balance' => $totalBalance,
            'used_balance' => $usedBalance,
            'remaining_balance' => $totalBalance - $usedBalance
        ];
    }

    // State for fresh balance (no used days)
    public function fresh()
    {
        return $this->state(function (array $attributes) {
            $totalBalance = 12;
            return [
                'total_balance' => $totalBalance,
                'used_balance' => 0,
                'remaining_balance' => $totalBalance
            ];
        });
    }

    // State for specific total balance
    public function withTotalBalance($total)
    {
        return $this->state(function (array $attributes) use ($total) {
            return [
                'total_balance' => $total,
                'used_balance' => 0,
                'remaining_balance' => $total
            ];
        });
    }

    // State for previous year
    public function previousYear()
    {
        return $this->state(function (array $attributes) {
            return [
                'year' => now()->subYear()->year
            ];
        });
    }
}
