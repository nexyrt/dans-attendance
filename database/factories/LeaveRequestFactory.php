<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\LeaveRequest;
use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        $startDate = Chronos::now()->subDays($this->faker->numberBetween(1, 30));
        $endDate = (clone $startDate)->addDays($this->faker->numberBetween(1, 5));

        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['sick', 'annual', 'important', 'other']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'reason' => $this->faker->sentence(),
            'status' => LeaveRequest::STATUS_PENDING_MANAGER, // Use constant instead of string
            'attachment_path' => $this->faker->optional(0.3)->filePath(),
            'manager_id' => null,
            'manager_approved_at' => null,
            'manager_signature' => null,
            'hr_id' => null,
            'hr_approved_at' => null,
            'hr_signature' => null,
            'director_id' => null,
            'director_approved_at' => null,
            'director_signature' => null,
            'rejection_reason' => null,
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (LeaveRequest $leave) {
            // No additional configuration needed
        });
    }

    public function pendingHR()
    {
        return $this->state(function (array $attributes) {
            $managers = User::where('role', 'manager')->get();

            return [
                'status' => LeaveRequest::STATUS_PENDING_HR, // Changed from pending_admin
                'manager_id' => $managers->random()->id,
                'manager_approved_at' => now(),
                'manager_signature' => 'signature_' . Str::random(10),
            ];
        });
    }


    public function pendingDirector()
    {
        return $this->state(function (array $attributes) {
            $managers = User::where('role', 'manager')->get();
            $admins = User::where('role', 'admin')->get();  // Changed from hr

            return [
                'status' => 'pending_director',
                'manager_id' => $managers->random()->id,
                'manager_approved_at' => now(),
                'manager_signature' => 'signature_' . Str::random(10),
                'hr_id' => $admins->random()->id,  // You might want to rename this column too
                'hr_approved_at' => now()->addHours(2),
                'hr_signature' => 'signature_' . Str::random(10),
            ];
        });
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            $managers = User::where('role', 'manager')->get();
            $admins = User::where('role', 'admin')->get();  // Changed from hr
            $directors = User::where('role', 'director')->get();

            return [
                'status' => 'approved',
                'manager_id' => $managers->random()->id,
                'manager_approved_at' => now(),
                'manager_signature' => 'signature_' . Str::random(10),
                'hr_id' => $admins->random()->id,  // You might want to rename this column too
                'hr_approved_at' => now()->addHours(2),
                'hr_signature' => 'signature_' . Str::random(10),
                'director_id' => $directors->random()->id,
                'director_approved_at' => now()->addHours(4),
                'director_signature' => 'signature_' . Str::random(10),
            ];
        });
    }

    public function rejectedByManager()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'rejected_manager',
            'manager_id' => User::where('role', 'manager')->first()->id,
            'manager_approved_at' => now(),
            'manager_signature' => 'signature_' . Str::random(10),
        ]);
    }

    public function rejectedByHR()
    {
        return $this->state(fn(array $attributes) => [
            'status' => LeaveRequest::STATUS_REJECTED_HR, // Changed from rejected_admin
            'manager_id' => User::where('role', 'manager')->first()->id,
            'manager_approved_at' => now(),
            'manager_signature' => 'signature_' . Str::random(10),
            'hr_id' => User::where('role', 'admin')->first()->id,
            'hr_approved_at' => now()->addHour(),
            'hr_signature' => 'signature_' . Str::random(10),
        ]);
    }

    public function rejectedByDirector()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'rejected_director',
            'manager_id' => User::where('role', 'manager')->first()->id,
            'manager_approved_at' => now(),
            'manager_signature' => 'signature_' . Str::random(10),
            'hr_id' => User::where('role', 'admin')->first()->id,
            'hr_approved_at' => now()->addHour(),
            'hr_signature' => 'signature_' . Str::random(10),
            'director_id' => User::where('role', 'director')->first()->id,
            'director_approved_at' => now()->addHours(2),
            'director_signature' => 'signature_' . Str::random(10),
        ]);
    }

    public function cancelled()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'cancel'
        ]);
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