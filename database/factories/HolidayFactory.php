<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Holiday>
 */
class HolidayFactory extends Factory
{
    protected $model = Holiday::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 year');
        $endDate = Carbon::parse($startDate)->endOfDay();

        return [
            'title' => $this->faker->sentence(3),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'description' => $this->faker->paragraph(1),
        ];
    }

    // State for single-day holiday
    public function singleDay()
    {
        return $this->state(function (array $attributes) {
            $date = $this->faker->dateTimeBetween('now', '+1 year');
            return [
                'start_date' => Carbon::parse($date)->startOfDay(),
                'end_date' => Carbon::parse($date)->endOfDay(),
            ];
        });
    }

    // State for multi-day holiday
    public function multiDay($days = 2)
    {
        return $this->state(function (array $attributes) use ($days) {
            $startDate = $this->faker->dateTimeBetween('now', '+1 year');
            return [
                'start_date' => Carbon::parse($startDate)->startOfDay(),
                'end_date' => Carbon::parse($startDate)->addDays($days - 1)->endOfDay(),
            ];
        });
    }
}
