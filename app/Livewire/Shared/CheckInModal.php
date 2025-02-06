<?php

namespace App\Livewire\Shared;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\OfficeLocation;
use App\Models\ScheduleException;
use App\Traits\DateTimeComparison;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Cake\Chronos\Chronos;

class CheckInModal extends Component
{
    use DateTimeComparison;

    public $showModal = false;
    public $currentTime;
    public $schedule;
    public $exceptionInfo = null;
    public $latitude = null;
    public $longitude = null;
    public $errorMessage = null;
    public $debug = false;
    public $nearestOfficeDistance = null;
    public $nearestOffice = null;
    public $exception = null;

    protected $listeners = [
        'closeModal' => 'closeModal',
        'locationUpdated' => 'handleLocationUpdate'
    ];

    public function mount()
    {
        $this->checkAttendance();
    }

    public function handleLocationUpdate($latitude, $longitude)
    {
        try {
            $this->latitude = $latitude;
            $this->longitude = $longitude;
            $this->errorMessage = null;

            $this->nearestOffice = $this->findNearestOffice($latitude, $longitude);

            if (!$this->nearestOffice) {
                $this->errorMessage = 'No office locations found in database.';
                return;
            }

            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $this->nearestOffice->latitude,
                $this->nearestOffice->longitude
            );

            $this->nearestOfficeDistance = $distance;

            if ($distance > $this->nearestOffice->radius) {
                $this->errorMessage = "You must be within {$this->nearestOffice->radius}m of {$this->nearestOffice->name} to check in. Currently " . round($distance) . "m away.";
            }
        } catch (Exception $e) {
            Log::error('Location update error: ' . $e->getMessage());
            $this->errorMessage = 'Error processing location data.';
        }
    }

    protected function findNearestOffice($latitude, $longitude)
    {
        if (!$latitude || !$longitude) {
            return null;
        }

        $offices = OfficeLocation::all();
        $nearestOffice = null;
        $shortestDistance = PHP_FLOAT_MAX;

        foreach ($offices as $office) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $office->latitude,
                $office->longitude
            );

            if ($distance < $shortestDistance) {
                $nearestOffice = $office;
                $shortestDistance = $distance;
            }
        }

        return $nearestOffice;
    }

    protected function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($lat1) * cos($lat2) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Distance in meters
    }

    public function checkIn()
    {
        try {
            if (!$this->schedule) {
                throw new Exception('No schedule found for today.');
            }

            if (!$this->latitude || !$this->longitude) {
                $this->errorMessage = 'Location data is required for check-in.';
                return;
            }

            $nearestOffice = $this->findNearestOffice($this->latitude, $this->longitude);

            if (!$nearestOffice) {
                $this->errorMessage = 'No office locations found.';
                return;
            }

            $distance = $this->calculateDistance(
                $this->latitude,
                $this->longitude,
                $nearestOffice->latitude,
                $nearestOffice->longitude
            );

            if ($distance > $nearestOffice->radius) {
                $this->errorMessage = 'You must be within office area to check in.';
                return;
            }

            $now = Chronos::now();

            // Get the correct start time based on schedule type
            if ($this->exception) {
                $startTime = Chronos::parse($this->exception->start_time);
                $lateToleranceMinutes = $this->exception->late_tolerance;
            } else {
                $startTime = Chronos::parse($this->schedule->start_time);
                $lateToleranceMinutes = $this->schedule->late_tolerance;
            }

            // Calculate late hours
            $toleranceLimit = $startTime->addMinutes($lateToleranceMinutes);
            $status = $now->timestamp > $toleranceLimit->timestamp ? 'late' : 'present';

            // Calculate late hours if status is 'late'
            $lateHours = null;
            if ($status === 'late') {
                $diffInMinutes = $now->diffInMinutes($startTime);
                $lateHours = round($diffInMinutes / 60, 2);
            }

            Log::info('Check-in details:', [
                'is_exception' => (bool) $this->exception,
                'start_time' => $startTime->format('H:i:s'),
                'current_time' => $now->format('H:i:s'),
                'status' => $status,
                'late_hours' => $lateHours
            ]);

            Attendance::create([
                'user_id' => auth()->id(),
                'date' => $now->format('Y-m-d'),
                'check_in' => $now,
                'status' => $status,
                'late_hours' => $lateHours,
                'check_in_office_id' => $nearestOffice->id,
                'check_in_latitude' => $this->latitude,
                'check_in_longitude' => $this->longitude,
                'device_type' => $this->detectDeviceType()
            ]);

            $this->dispatch('refresh-page');
            $this->dispatch('success-checkin');

        } catch (Exception $e) {
            Log::error('Error during check-in:', [
                'message' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            $this->errorMessage = 'Failed to check in. Please try again.';
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => $this->errorMessage
            ]);
        }
    }

    protected function detectDeviceType()
    {
        $userAgent = request()->header('User-Agent');
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            return 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    public function isException()
    {
        try {
            $today = Chronos::now();

            // Check schedule exceptions
            $exception = ScheduleException::query()
                ->whereDate('date', $today->format('Y-m-d'))
                ->first();

            if ($exception) {
                Log::info('Found schedule exception');
                $this->exceptionInfo = [
                    'type' => $exception->status,
                    'title' => $exception->title ?? $this->getExceptionTitle($exception->status),
                    'description' => $exception->note
                ];
                return true;
            }

            $this->exceptionInfo = null;
            return false;
        } catch (Exception $e) {
            Log::error('Error checking exception status: ' . $e->getMessage());
            return false;
        }
    }

    protected function getExceptionTitle($status)
    {
        return match ($status) {
            'regular' => 'Regular Schedule',
            'event' => 'Special Event',
            'holiday' => 'Holiday',
            default => 'Schedule Exception'
        };
    }

    public function getScheduleException()
    {
        try {
            $today = Chronos::now();

            return ScheduleException::query()
                ->whereDate('date', $today->format('Y-m-d'))
                ->first();

        } catch (Exception $e) {
            Log::error('Error checking exception status: ' . $e->getMessage());
            return null;
        }
    }

    public function checkAttendance()
    {
        try {
            $this->showModal = false;
            $today = Chronos::now();

            // 1. First check for holiday exception
            $exception = $this->getScheduleException();
            if ($exception && $exception->status === 'holiday') {
                $this->dispatch('notify', [
                    'type' => 'info',
                    'message' => "Today is a holiday: {$exception->title}",
                    'persistent' => true
                ]);
                return;
            }

            // Check if already checked in before proceeding
            if ($this->hasCheckedInToday()) {
                Log::info('User already checked in today');
                return;
            }

            // 2. Check for regular schedule exception
            if ($exception && $exception->status === 'regular') {
                $this->exception = $exception;
                $this->exceptionInfo = [
                    'type' => 'regular',
                    'title' => $exception->title,
                    'description' => $exception->note
                ];

                // Create Schedule object for the exception schedule
                $this->schedule = new Schedule([
                    'start_time' => $exception->start_time,
                    'end_time' => $exception->end_time,
                    'late_tolerance' => $exception->late_tolerance
                ]);

                // Important: We need to cast these to actual DateTime objects
                $this->schedule->start_time = $exception->start_time;
                $this->schedule->end_time = $exception->end_time;

                // Check time window with exception schedule times
                $startTime = Chronos::parse($exception->start_time);
                $endTime = Chronos::parse($exception->end_time);
                $checkInWindowStart = $startTime->modify('-30 minutes');

                if (
                    $today->timestamp >= $checkInWindowStart->timestamp &&
                    $today->timestamp <= $endTime->timestamp
                ) {
                    Log::info('Current time is within exception schedule window', [
                        'exception_start' => $exception->start_time,
                        'exception_end' => $exception->end_time,
                        'late_tolerance' => $exception->late_tolerance
                    ]);
                    $this->showModal = true;
                }
                return;
            }

            // 3. If no relevant exception exists, use default schedule
            $dayOfWeek = strtolower($today->format('l'));
            $this->schedule = Schedule::where('day_of_week', $dayOfWeek)->first();

            if (!$this->schedule) {
                Log::info('No default schedule found for today');
                return;
            }

            Log::info('Using default schedule:', [
                'start_time' => $this->schedule->start_time,
                'end_time' => $this->schedule->end_time
            ]);

            $startTime = Chronos::parse($this->schedule->start_time);
            $endTime = Chronos::parse($this->schedule->end_time);
            $checkInWindowStart = $startTime->modify('-30 minutes');

            if (
                $today->timestamp >= $checkInWindowStart->timestamp &&
                $today->timestamp <= $endTime->timestamp
            ) {
                Log::info('Current time is within default schedule window');
                $this->showModal = true;
            }

        } catch (Exception $e) {
            Log::error('Error in checkAttendance:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }

    public function hasCheckedInToday()
    {
        return Attendance::where('user_id', auth()->id())
            ->whereDate('date', Chronos::today()->format('Y-m-d'))
            ->exists();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        $this->currentTime = Chronos::now()->format('H:i:s');
        return view('livewire.shared.check-in-modal');
    }
}