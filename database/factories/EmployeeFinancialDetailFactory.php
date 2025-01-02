<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeFinancialDetail>
 */
class EmployeeFinancialDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $banks = ['BCA', 'Mandiri', 'BNI', 'BRI', 'CIMB Niaga'];
        $grades = ['C Level', 'M Level', 'S Level'];
        $selectedGrade = $this->faker->randomElement($grades);

        return [
            //
            'user_id' => User::factory(),
            'bank_name' => $this->faker->randomElement($banks),
            'bank_account_number' => $this->faker->numerify('##########'),
            'grade' => $selectedGrade,
        ];
    }

    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'grade' => 'M Level',
        ]);
    }
}
