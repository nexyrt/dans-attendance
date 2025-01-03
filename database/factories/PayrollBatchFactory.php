<?php

namespace Database\Factories;

use App\Models\PayrollBatch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PayrollBatch>
 */
class PayrollBatchFactory extends Factory
{
    protected $model = PayrollBatch::class;

    public function definition(): array
    {
        $monthYear = $this->faker->dateTimeBetween('-6 months', 'now');
        $periodStart = (clone $monthYear)->modify('first day of this month');
        $periodEnd = (clone $monthYear)->modify('last day of this month');
        
        return [
            'run_reference' => 'PR-' . $monthYear->format('Ym'),
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'status' => $this->faker->randomElement(['draft', 'processing', 'completed', 'paid']),
            'created_by' => User::factory(),
            'approved_by' => fn (array $attributes) => 
                in_array($attributes['status'], ['completed', 'paid']) ? 
                User::factory() : null,
            'processed_at' => fn (array $attributes) => 
                in_array($attributes['status'], ['completed', 'paid']) ? 
                now() : null,
            'paid_at' => fn (array $attributes) => 
                $attributes['status'] === 'paid' ? 
                now() : null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}