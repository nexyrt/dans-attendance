<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'date' => $this->faker->date,
            'check_in' => $this->faker->dateTimeThisMonth(),
            'check_out' => $this->faker->dateTimeThisMonth(),
            'activity_log' => $this->faker->sentence,
        ];
    }
}
