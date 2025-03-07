<?php

namespace App\Livewire\Shared;

use App\Models\Attendance;
use App\Models\OfficeLocation;
use App\Models\Schedule;
use App\Helpers\DateTimeHelper;
use App\Models\ScheduleException;
use App\Traits\DateTimeComparison;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckOutModal extends Component
{
    use DateTimeComparison;

    // UI State Properties
    public $showModal = false;
    public $isSuccess = false;
    public $errorMessage = null;
    public $showEarlyLeaveForm = false;

    // Attendance Properties
    public $currentTime;
    public $attendance;
    public $todayAttendance;
    public $workingHours;
    public $hasCompletedAttendance = false;

    // Form Inputs
    public $earlyLeaveReason;
    public $notes;
    public $notesValid = false;

    // Schedule Properties
    public $schedule;
    public $exception = null;

    // Location Properties
    public $latitude = null;
    public $longitude = null;
    public $nearestOffice = null;
    public $nearestOfficeDistance = null;

    protected $listeners = [
        'openCheckOutModal' => 'openModal'
    ];

    protected $rules = [
        'earlyLeaveReason' => 'required_if:showEarlyLeaveForm,true|string|max:255',
        'notes' => 'required|string|max:1000'
    ];

    protected $messages = [
        'notes.required' => 'You must provide activity notes before checking out.'
    ];

    public function mount()
    {
        $this->loadTodayAttendance();
        $this->loadSchedule();
    }

    public function render()
    {
        $this->currentTime = DateTimeHelper::now()->format('H:i:s');
        return view('livewire.shared.check-out-modal');
    }

    /**
     * Process the check-out action
     */
    public function checkOut()
    {
        if ($this->hasCompletedAttendance) {
            $this->closeModal();
            return;
        }

        // Validate all form fields including notes
        $this->validate();

        // Check if notes has substantive content
        if (!$this->notesHasSubstantiveContent($this->notes)) {
            $this->addError('notes', 'Your notes must contain at least 15 characters of actual text content.');
            return;
        }

        try {
            if (!$this->validateCheckOutRequirements()) {
                return;
            }

            $currentTime = DateTimeHelper::now();
            $checkInTime = DateTimeHelper::parse($this->attendance->check_in);

            // Calculate working hours from check-in time to current time
            $workingHours = $checkInTime->diffInHours($currentTime, true);

            $updateData = $this->prepareCheckOutData($currentTime, $workingHours);

            $this->attendance->update($updateData);
            $this->handleSuccessfulCheckOut();

        } catch (Exception $e) {
            $this->handleCheckOutError($e);
        }
    }

    /**
     * Check if notes content is actually empty or just contains HTML tags
     * 
     * @param string|null $content
     * @return boolean
     */
    protected function notesHasSubstantiveContent($content)
    {
        if (empty($content)) {
            return false;
        }
        
        // Remove HTML tags and decode entities
        $plainText = trim(html_entity_decode(strip_tags($content)));
        
        // Check if there's actual text content with at least 15 characters
        return strlen($plainText) >= 15;
    }

    /**
     * Update the notes valid state when notes are updated
     */
    public function updatedNotes($value)
    {
        $this->notesValid = $this->notesHasSubstantiveContent($value);
        
        if (!$this->notesValid) {
            $this->addError('notes', 'Your notes must contain at least 15 characters of actual text content.');
        } else {
            $this->resetValidation('notes');
        }
    }

    /**
     * Validate all requirements for check-out are met
     * 
     * @return bool
     */
    protected function validateCheckOutRequirements()
    {
        if (!$this->attendance) {
            $this->errorMessage = 'No active attendance record found.';
            return false;
        }

        if (!$this->latitude || !$this->longitude) {
            $this->errorMessage = 'Location data is required for check-out.';
            return false;
        }

        if (!$this->nearestOffice) {
            $this->errorMessage = 'No office locations found.';
            return false;
        }

        if ($this->nearestOfficeDistance > $this->nearestOffice->radius) {
            $this->errorMessage = 'You must be within office area to check out.';
            return false;
        }

        return true;
    }

    /**
     * Prepare the data for check-out update
     * 
     * @param \Carbon\Carbon $currentTime
     * @param float $workingHours
     * @return array
     */
    protected function prepareCheckOutData($currentTime, $workingHours)
    {
        // Double-check content validity server-side before saving
        if (!$this->notesHasSubstantiveContent($this->notes)) {
            $this->addError('notes', 'Notes must contain at least 15 characters of actual text.');
            throw new Exception('Notes validation failed');
        }
        
        $updateData = [
            'check_out' => $currentTime,
            'working_hours' => round($workingHours, 1),
            'check_out_latitude' => $this->latitude,
            'check_out_longitude' => $this->longitude,
            'check_out_office_id' => $this->nearestOffice->id,
            'notes' => $this->notes
        ];

        if ($this->showEarlyLeaveForm) {
            $endTime = DateTimeHelper::parse($this->schedule->end_time);

            if ($currentTime->lessThan($endTime)) {
                $updateData['status'] = 'early_leave';
                $updateData['early_leave_reason'] = $this->earlyLeaveReason;
            }
        }

        return $updateData;
    }

    /**
     * Handle successful check-out actions
     */
    protected function handleSuccessfulCheckOut()
    {
        $this->loadTodayAttendance();
        $this->isSuccess = true;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Check-out successful!'
        ]);

        $this->dispatch('success-checkout');
        $this->dispatch('refresh-page');
    }

    /**
     * Handle check-out errors
     * 
     * @param Exception $e
     */
    protected function handleCheckOutError(Exception $e)
    {
        Log::error('Check-out error: ' . $e->getMessage(), [
            'user_id' => auth()->id(),
            'attendance_id' => $this->attendance?->id
        ]);

        $this->dispatch('notify', [
            'type' => 'error',
            'message' => 'Failed to process check-out. Please try again.'
        ]);
    }

    /**
     * Process location data received from the front-end
     * 
     * @param float|null $latitude
     * @param float|null $longitude
     */
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

    /**
     * Find the nearest office to the given coordinates
     * 
     * @param float|null $latitude
     * @param float|null $longitude
     * @return OfficeLocation|null
     */
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

    /**
     * Calculate distance between two geographical coordinates
     * 
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float
     */
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

    /**
     * Load today's attendance record
     */
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

    /**
     * Set state for completed attendance
     */
    protected function setCompletedAttendanceState()
    {
        $this->attendance = $this->todayAttendance;
        $this->hasCompletedAttendance = true;
        $this->workingHours = $this->todayAttendance->working_hours;
    }

    /**
     * Set state for active attendance
     */
    protected function setActiveAttendanceState()
    {
        $this->attendance = $this->todayAttendance;
        $this->hasCompletedAttendance = false;
        $this->calculateWorkingHours();
    }

    /**
     * Reset attendance state
     */
    protected function resetAttendanceState()
    {
        $this->attendance = null;
        $this->hasCompletedAttendance = false;
        $this->workingHours = 0;
    }

    /**
     * Load schedule for today
     */
    public function loadSchedule()
    {
        $today = DateTimeHelper::now();

        // Check for exception schedule first
        $exception = ScheduleException::query()
            ->whereDate('date', $today->format('Y-m-d'))
            ->where('status', 'regular')
            ->first();

        if ($exception) {
            $this->schedule = new Schedule([
                'start_time' => $exception->start_time,
                'end_time' => $exception->end_time
            ]);
        } else {
            // Fall back to default schedule
            $this->schedule = Schedule::where('day_of_week', strtolower($today->format('l')))->first();
        }

        if ($this->schedule && $this->attendance && !$this->hasCompletedAttendance) {
            $currentTime = DateTimeHelper::now();
            $endTime = DateTimeHelper::parse($this->schedule->end_time);
            $this->showEarlyLeaveForm = $currentTime->lessThan($endTime);
        }
    }

    /**
     * Calculate working hours for current session
     */
    public function calculateWorkingHours()
    {
        if ($this->attendance && $this->attendance->check_in) {
            $checkIn = DateTimeHelper::parse($this->attendance->check_in);
            $this->workingHours = round($checkIn->diffInHours(DateTimeHelper::now(), true), 1);
        }
    }

    /**
     * Open the check-out modal
     */
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

    /**
     * Close the modal and reset state
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetState();
    }

    /**
     * Reset component state
     */
    private function resetState()
    {
        $this->isSuccess = false;
        $this->earlyLeaveReason = '';
        $this->notes = '';
        $this->notesValid = false;
        $this->showEarlyLeaveForm = false;
        $this->resetAttendanceState();
    }

    /**
     * Format date for display
     * 
     * @param mixed $date
     * @return string
     */
    public function formatDate($date)
    {
        return $date ? DateTimeHelper::parse($date)->format('H:i:s') : '--:--:--';
    }

    /**
     * Get current date formatted for display
     * 
     * @return string
     */
    public function getCurrentDate()
    {
        return DateTimeHelper::now()->format('l, d F Y');
    }
}