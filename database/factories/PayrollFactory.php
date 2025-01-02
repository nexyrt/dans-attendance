<?php

namespace Database\Factories;

use App\Models\Payroll;
use App\Models\PayrollBatch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payroll>
 */
class PayrollFactory extends Factory
{
    protected $model = Payroll::class;

    public function definition(): array
    {
        $batch = PayrollBatch::factory()->create();

        return [
            'user_id' => User::factory(),
            'payroll_batches_id' => $batch->id,
            'run_reference' => $batch->run_reference,
            'status' => $this->faker->randomElement(['draft', 'processing', 'paid']),
            'approved_by' => fn(array $attributes) =>
                $attributes['status'] === 'paid' ?
                User::factory() : null,
            'processed_at' => fn(array $attributes) =>
                in_array($attributes['status'], ['processing', 'paid']) ?
                now() : null,
            'paid_at' => fn(array $attributes) =>
                $attributes['status'] === 'paid' ?
                now() : null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}