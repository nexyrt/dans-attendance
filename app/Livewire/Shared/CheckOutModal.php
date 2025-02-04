<?php

namespace App\Livewire\Shared;

use App\Models\Attendance;
use App\Models\OfficeLocation;
use App\Models\Schedule;
use App\Helpers\DateTimeHelper;
use App\Traits\DateTimeComparison;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckOutModal extends Component
{
    use DateTimeComparison;

    public $showModal = false;
    public $currentTime;
    public $attendance;
    public $todayAttendance;
    public $workingHours;
    public $earlyLeaveReason;
    public $showEarlyLeaveForm = false;
    public $isSuccess = false;
    public $schedule;
    public $hasCompletedAttendance = false;

    // New properties for geolocation
    public $latitude = null;
    public $longitude = null;
    public $errorMessage = null;
    public $nearestOffice = null;
    public $nearestOfficeDistance = null;

    protected $listeners = [
        'openCheckOutModal' => 'openModal'
    ];

    protected $rules = [
        'earlyLeaveReason' => 'required_if:showEarlyLeaveForm,true|string|max:255'
    ];

    public function mount()
    {
        $this->loadTodayAttendance();
        $this->loadSchedule();
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
                $this->errorMessage = "You must be within {$this->nearestOffice->radius}m of {$this->nearestOffice->name} to check out. Currently " . round($distance) . "m away.";
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

        return $earthRadius * $c;
    }

    public function checkOut()
    {
        if ($this->hasCompletedAttendance) {
            $this->closeModal();
            return;
        }

        if ($this->showEarlyLeaveForm) {
            $this->validate();
        }

        try {
            if (!$this->attendance) {
                throw new Exception('No active attendance record found.');
            }

            if (!$this->latitude || !$this->longitude) {
                $this->errorMessage = 'Location data is required for check-out.';
                return;
            }

            if (!$this->nearestOffice) {
                $this->errorMessage = 'No office locations found.';
                return;
            }

            if ($this->nearestOfficeDistance > $this->nearestOffice->radius) {
                $this->errorMessage = 'You must be within office area to check out.';
                return;
            }

            $currentTime = DateTimeHelper::now();
            $updateData = [
                'check_out' => $currentTime,
                'working_hours' => $this->workingHours,
                'check_out_latitude' => $this->latitude,
                'check_out_longitude' => $this->longitude,
                'check_out_office_id' => $this->nearestOffice->id
            ];

            if ($this->showEarlyLeaveForm) {
                $updateData['status'] = 'early_leave';
                $updateData['early_leave_reason'] = $this->earlyLeaveReason;
            }

            $this->attendance->update($updateData);
            $this->loadTodayAttendance();
            $this->isSuccess = true;

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Check-out successful!'
            ]);

            $this->dispatch('success-checkout');
            $this->dispatch('refresh-page');

        } catch (Exception $e) {
            Log::error('Check-out error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'attendance_id' => $this->attendance?->id
            ]);

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to process check-out. Please try again.'
            ]);
        }
    }

    protected function loadTodayAttendance()
    {
        $this->todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', DateTimeHelper::today())
            ->first();

        if (!$this->todayAttendance) {
            $this->resetAttendanceState();
            return;
        }

        if ($this->todayAttendance->check_out) {
            $this->setCompletedAttendanceState();
            return;
        }

        $this->setActiveAttendanceState();
    }

    protected function setCompletedAttendanceState()
    {
        $this->attendance = $this->todayAttendance;
        $this->hasCompletedAttendance = true;
        $this->workingHours = $this->todayAttendance->working_hours;
    }

    protected function setActiveAttendanceState()
    {
        $this->attendance = $this->todayAttendance;
        $this->hasCompletedAttendance = false;
        $this->calculateWorkingHours();
    }

    protected function resetAttendanceState()
    {
        $this->attendance = null;
        $this->hasCompletedAttendance = false;
        $this->workingHours = 0;
    }

    public function loadSchedule()
    {
        $today = DateTimeHelper::currentDayName();
        $this->schedule = Schedule::where('day_of_week', $today)->first();

        if ($this->schedule && $this->attendance && !$this->hasCompletedAttendance) {
            $currentTime = DateTimeHelper::now();
            $endTime = DateTimeHelper::parse($this->schedule->end_time);
            $this->showEarlyLeaveForm = $currentTime->lessThan($endTime);
        }
    }

    public function calculateWorkingHours()
    {
        if ($this->attendance && $this->attendance->check_in) {
            $checkIn = DateTimeHelper::parse($this->attendance->check_in);
            $this->workingHours = round($checkIn->diffInHours(DateTimeHelper::now(), true), 1);
        }
    }

    public function openModal()
    {
        $this->resetState();
        $this->loadTodayAttendance();
        $this->loadSchedule();

        if ($this->hasCompletedAttendance) {
            $this->showModal = true;
            return;
        }

        if (!$this->attendance) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Please check-in first before attempting to check-out.'
            ]);
            return;
        }

        $this->showModal = true;
    }

    private function resetState()
    {
        $this->isSuccess = false;
        $this->earlyLeaveReason = '';
        $this->showEarlyLeaveForm = false;
        $this->resetAttendanceState();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetState();
    }

    public function formatDate($date)
    {
        return $date ? DateTimeHelper::parse($date)->format('H:i:s') : '--:--:--';
    }

    public function getCurrentDate()
    {
        return DateTimeHelper::now()->format('l, d F Y');
    }

    public function render()
    {
        $this->currentTime = DateTimeHelper::now()->format('H:i:s');
        return view('livewire.shared.check-out-modal');
    }
}