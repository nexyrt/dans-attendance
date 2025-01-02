<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalaryDetail>
 */
class SalaryDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentType = $this->faker->randomElement(['monthly', 'hourly']);
        $isMonthly = $paymentType === 'monthly';

        return [
            //
            'user_id' => User::factory(),
            'basic_salary' => $isMonthly ? 
                $this->faker->numberBetween(4000000, 20000000) : // Monthly salary range
                $this->faker->numberBetween(50000, 150000), // Hourly salary range
            'monthly_hourly_rate' => $isMonthly ? null : 
                $this->faker->numberBetween(50000, 150000),
            'overtime_rate' => 20000,
            'effective_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            
        ];
    }
}
