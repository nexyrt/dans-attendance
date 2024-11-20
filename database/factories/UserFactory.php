<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->randomElement(['admin', 'manager', 'staff']),
            'department' => $this->faker->randomElement(['Digital', 'Keuangan', 'Digital Marketing']),
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
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
