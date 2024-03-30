<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mengambil seluruh ID dari tabel users
        $userIds = User::pluck('id')->toArray();

        return [
            'name' => $this->faker->name,
            'employee_number' => $this->faker->unique()->randomNumber(5),
            'user_id' => $this->faker->unique()->randomElement($userIds),
            'department' => $this->faker->randomElement(['Digital', 'Keuangan', 'Digital Marketing']),
            'position' => $this->faker->randomElement(['Manager', 'Staff']),
            'salary' => $this->faker->randomNumber(5),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'birthdate' => $this->faker->date,
        ];
    }
}
