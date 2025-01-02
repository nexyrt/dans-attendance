<?php

namespace Database\Factories;

use App\Models\Allowance;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allowance>
 */
class AllowanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Allowance::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'payroll_id' => Payroll::factory(),
            'allowance_type' => $this->faker->randomElement(['Bonus Kinerja', 'Reimbuse','Lemburan','Honor Proyek','Lainnya']),
            'amount' => $this->faker->numberBetween(50000, 1000000),
            'is_recurring' => $this->faker->boolean()
        ];
    }
}
