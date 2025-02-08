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

    // UserFactory.php
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'role' => $this->faker->randomElement(['staff', 'manager']),
            'department_id' => Department::inRandomOrder()->first()->id, // Better way to get random department
            'phone_number' => $this->faker->phoneNumber(),
            'birthdate' => $this->faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'salary' => $this->faker->numberBetween(3000000, 10000000),
            'address' => $this->faker->address(),
            'remember_token' => Str::random(10),
        ];
    }
}
