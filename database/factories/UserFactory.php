<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->randomElement(['admin', 'manager', 'staff']),
            'department_id' => Department::inRandomOrder()->first()->id,
            'position' => $this->faker->randomElement(['Manager', 'Staff']),
            'salary' => $this->faker->randomNumber(5),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'birthdate' => $this->faker->date,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
