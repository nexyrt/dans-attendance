<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = Carbon::createFromTime(
            $this->faker->numberBetween(7, 10),
            0,
            0
        );
        
        $endTime = $startTime->copy()->addHours(
            $this->faker->numberBetween(8, 9)
        );

        
        return [
            'day_of_week' => $this->faker->randomElement(Schedule::DAYS),
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'late_tolerance' => $this->faker->randomElement([15, 30, 45]),
        ];
    }
}
