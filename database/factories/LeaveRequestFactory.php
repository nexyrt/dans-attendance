<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LeaveRequest::class;
    public function definition(): array
    {
        $startDate = Carbon::instance($this->faker->dateTimeBetween('-1 month', '+1 month'));
        $endDate = $startDate->copy()->addDays($this->faker->numberBetween(1, 5));

        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(LeaveRequest::TYPES),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'reason' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(LeaveRequest::STATUSES),
            'attachment_path' => $this->faker->optional(0.3)->imageUrl(),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (LeaveRequest $leave) {
            // No additional configuration needed
        })->afterCreating(function (LeaveRequest $leave) {
            if ($leave->status !== 'pending') {
                $leave->approved_by = User::factory()->create()->id;
                $leave->approved_at = now();
                $leave->save();
            }
        });
    }

    // State for pending leave requests
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null
            ];
        });
    }

    // State for approved leave requests
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
                'approved_by' => User::factory(),
                'approved_at' => now()
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
                'approved_by' => User::factory(),
                'approved_at' => now()
            ];
        });
    }

    public function sickLeave()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'sick',
                'reason' => $this->faker->randomElement([
                    'Fever and flu',
                    'Food poisoning',
                    'Migraine',
                    'Medical appointment',
                    'Not feeling well'
                ])
            ];
        });
    }

    public function annualLeave()
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::instance($this->faker->dateTimeBetween('+1 week', '+2 months'));
            return [
                'type' => 'annual',
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addDays($this->faker->numberBetween(1, 14)),
                'reason' => $this->faker->randomElement([
                    'Family vacation',
                    'Personal time off',
                    'Travelling',
                    'Rest and relaxation',
                    'Family gathering'
                ])
            ];
        });
    }
}
