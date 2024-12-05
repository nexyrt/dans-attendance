<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween(
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear()
        );
        
        // Set random check-in time between 7:00 and 9:00
        $checkIn = Carbon::parse($date)->setHour(rand(7, 9))->setMinute(rand(0, 59));
        
        // Set check-out time 7-9 hours after check-in
        $checkOut = (clone $checkIn)->addHours(rand(7, 9))->addMinutes(rand(0, 59));
        
        // Calculate working hours
        $workingHours = $checkIn->floatDiffInHours($checkOut);
        
        // Determine status based on check-in time
        $status = match(true) {
            $checkIn->format('H:i') > '08:30' => 'late',
            $checkOut->format('H:i') < '17:00' => 'early_leave',
            default => 'present'
        };

        return [
            'user_id' => User::all()->random()->id,
            'date' => $date,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $status,
            'working_hours' => number_format($workingHours, 2),
            'early_leave_reason' => $status === 'early_leave' ? $this->faker->sentence : null,
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence : null,
        ];
    }

    /**
     * Indicate that the attendance is for today.
     */
    public function today()
    {
        return $this->state(function (array $attributes) {
            return [
                'date' => now()->toDateString(),
            ];
        });
    }

    /**
     * Indicate that the attendance is marked as present.
     */
    public function present()
    {
        return $this->state(function (array $attributes) {
            $checkIn = Carbon::parse($attributes['date'])->setHour(8)->setMinute(rand(0, 30));
            $checkOut = (clone $checkIn)->addHours(8)->addMinutes(rand(0, 30));
            
            return [
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => 'present',
                'working_hours' => number_format($checkIn->floatDiffInHours($checkOut), 2),
            ];
        });
    }

    /**
     * Indicate that the attendance is marked as late.
     */
    public function late()
    {
        return $this->state(function (array $attributes) {
            $checkIn = Carbon::parse($attributes['date'])->setHour(9)->setMinute(rand(0, 59));
            $checkOut = (clone $checkIn)->addHours(8);
            
            return [
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => 'late',
                'working_hours' => number_format($checkIn->floatDiffInHours($checkOut), 2),
                'notes' => $this->faker->sentence,
            ];
        });
    }

    /**
     * Indicate that the attendance has early leave.
     */
    public function earlyLeave()
    {
        return $this->state(function (array $attributes) {
            $checkIn = Carbon::parse($attributes['date'])->setHour(8)->setMinute(rand(0, 30));
            $checkOut = (clone $checkIn)->addHours(6); // Leave early after 6 hours
            
            return [
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => 'early_leave',
                'working_hours' => number_format($checkIn->floatDiffInHours($checkOut), 2),
                'early_leave_reason' => $this->faker->sentence,
            ];
        });
    }

    /**
     * Indicate that the day is a holiday.
     */
    public function holiday()
    {
        return $this->state(function (array $attributes) {
            return [
                'check_in' => null,
                'check_out' => null,
                'status' => 'holiday',
                'working_hours' => 0,
                'notes' => $this->faker->sentence,
            ];
        });
    }
}