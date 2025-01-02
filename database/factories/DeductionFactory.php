<?php

namespace Database\Factories;

use App\Models\Deduction;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deduction>
 */
class DeductionFactory extends Factory
{
    protected $model = Deduction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'payroll_id' => Payroll::factory(),
            'deduction_type' => $this->faker->randomElement([
                'BPJS Kesehatan',
                'BPJS TK',
                'PPH 21',
                'Pinjaman',
                'Terlambat',
                'Lainnya'
            ]),
            'amount' => $this->faker->numberBetween(50000, 1000000),
            'is_recurring' => $this->faker->boolean()
        ];
    }

    
}