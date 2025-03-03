<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use App\Models\OfficeLocation;
use Cake\Chronos\Chronos;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $office = OfficeLocation::inRandomOrder()->first();
        $date = $this->faker->dateTimeBetween('-3 months', 'now');
        $checkIn = Chronos::parse($date)->setTime(
            $this->faker->numberBetween(7, 9),
            $this->faker->numberBetween(0, 59)
        );
        
        // 80% chance of checking out
        $hasCheckOut = $this->faker->boolean(80);
        $checkOut = $hasCheckOut ? (clone $checkIn)->addHours($this->faker->numberBetween(8, 10)) : null;
        
        // Calculate working hours if check out exists
        $workingHours = $hasCheckOut ? 
            round($checkIn->diffInHours($checkOut, true), 2) : 
            null;

        // Determine status based on check-in time
        $status = $this->determineStatus($checkIn);

        // Generate coordinates near the office location
        $checkInCoordinates = $this->generateNearbyCoordinates($office);
        $checkOutCoordinates = $hasCheckOut ? $this->generateNearbyCoordinates($office) : null;

        return [
            'date' => $date,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $status,
            'working_hours' => $workingHours,
            'early_leave_reason' => $status === 'early_leave' ? $this->faker->sentence() : null,
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            
            // Location data
            'check_in_latitude' => $checkInCoordinates['latitude'],
            'check_in_longitude' => $checkInCoordinates['longitude'],
            'check_out_latitude' => $checkOutCoordinates ? $checkOutCoordinates['latitude'] : null,
            'check_out_longitude' => $checkOutCoordinates ? $checkOutCoordinates['longitude'] : null,
            'check_in_office_id' => $office->id,
            'check_out_office_id' => $hasCheckOut ? $office->id : null,
            
            // Device info
            'device_type' => $this->faker->randomElement(['Android', 'iOS', 'Web']),
        ];
    }

    /**
     * Determine attendance status based on check-in time
     */
    private function determineStatus(Chronos $checkIn): string
    {
        $hour = $checkIn->hour;
        
        if ($hour < 8) {
            return 'present';
        } elseif ($hour < 9) {
            return $this->faker->randomElement(['present', 'late']);
        } elseif ($hour >= 9) {
            return 'late';
        }

        return 'present';
    }

    /**
     * Generate coordinates within office radius
     */
    private function generateNearbyCoordinates(OfficeLocation $office): array
    {
        // Convert office radius from meters to degrees (approximate)
        $radiusInDegrees = $office->radius / 111320; // 1 degree = 111.32 km

        return [
            'latitude' => $this->faker->latitude(
                $office->latitude - $radiusInDegrees,
                $office->latitude + $radiusInDegrees
            ),
            'longitude' => $this->faker->longitude(
                $office->longitude - $radiusInDegrees,
                $office->longitude + $radiusInDegrees
            ),
        ];
    }
}