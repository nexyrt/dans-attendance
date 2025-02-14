<?php

namespace Database\Factories;

use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleExceptionFactory extends Factory
{
    public function definition(): array
    {
        $date = Chronos::today()->subDays(random_int(0, 30));

        return [
            'title' => $this->faker->randomElement([
                'Team Meeting',
                'Performance Review',
                'Special Schedule',
                'Client Meeting',
                'Monthly Review'
            ]),
            'date' => $date->format('Y-m-d'),
            'status' => $this->faker->randomElement(['regular', 'event', 'holiday']),
            'start_time' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00']),
            'end_time' => $this->faker->randomElement(['16:00:00', '17:00:00', '18:00:00']),
            'note' => $this->faker->sentence(),
        ];
    }
}
