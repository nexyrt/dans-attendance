<?php

namespace Database\Factories;

use App\Models\User;
use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryHistoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first(),
            'amount' => $this->faker->numberBetween(3000000, 10000000),
            'effective_date' => Chronos::now()->subMonths(rand(1, 12))->format('Y-m-d'),
            'pay_slip' => null,
            'notes' => $this->faker->randomElement([
                'Annual salary adjustment',
                'Performance bonus',
                'Position promotion',
                'Contract renewal'
            ])
        ];
    }
}
