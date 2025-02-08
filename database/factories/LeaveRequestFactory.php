<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\LeaveRequest;
use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        $startDate = Chronos::now()->subDays($this->faker->numberBetween(1, 30));
        $endDate = (clone $startDate)->addDays($this->faker->numberBetween(1, 5));

        // Get existing staff/manager users instead of creating new ones
        $users = User::whereIn('role', ['staff', 'manager'])->pluck('id')->toArray();
        $approvers = User::where('role', 'manager')->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($users),
            'type' => $this->faker->randomElement(['sick', 'annual', 'important', 'other']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'reason' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'cancel']),
            'attachment_path' => $this->faker->optional(0.3)->filePath(),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (LeaveRequest $leave) {
            // No additional configuration needed
        })->afterCreating(function (LeaveRequest $leave) {
            if ($leave->status !== 'pending' && $leave->status !== 'cancel') {
                $approvers = User::where('role', 'manager')->pluck('id')->toArray();
                $leave->approved_by = $this->faker->randomElement($approvers);
                $leave->approved_at = Chronos::now();
                $leave->save();
            }
        });
    }

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

    public function approved()
    {
        return $this->state(function (array $attributes) {
            $approvers = User::where('role', 'manager')->pluck('id')->toArray();
            return [
                'status' => 'approved',
                'approved_by' => $this->faker->randomElement($approvers),
                'approved_at' => Chronos::now()
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            $approvers = User::where('role', 'manager')->pluck('id')->toArray();
            return [
                'status' => 'rejected',
                'approved_by' => $this->faker->randomElement($approvers),
                'approved_at' => Chronos::now()
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
            $startDate = Chronos::now()->addDays($this->faker->numberBetween(7, 60));
            return [
                'type' => 'annual',
                'start_date' => $startDate,
                'end_date' => (clone $startDate)->addDays($this->faker->numberBetween(1, 14)),
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