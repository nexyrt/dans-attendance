<?php

namespace App\Livewire\Shared;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Helpers\DateTimeHelper;
use App\Traits\DateTimeComparison;
use Cake\Chronos\Chronos;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckInModal extends Component
{
    use DateTimeComparison;

    public $showModal = false;
    public $currentTime;
    public $schedule;

    protected $listeners = ['closeModal' => 'closeModal'];

    public function mount()
    {
        // Add debugging logs
        Log::info('CheckInModal mounted');
        $this->checkAttendance();
    }

    public function checkAttendance()
    {
        try {
            // Reset modal state
            $this->showModal = false;

            // Debug logs
            Log::info('Checking attendance...');

            if ($this->isHoliday()) {
                Log::info('Today is a holiday');
                return;
            }

            if ($this->hasCheckedInToday()) {
                Log::info('User already checked in today');
                return;
            }

            $today = DateTimeHelper::currentDayName();
            Log::info('Current day: ' . $today);

            $this->schedule = Schedule::where('day_of_week', $today)->first();

            if (!$this->schedule) {
                Log::info('No schedule found for today');
                return;
            }

            $currentTime = DateTimeHelper::now();
            $startTime = DateTimeHelper::parse($this->schedule->start_time);
            $endTime = DateTimeHelper::parse($this->schedule->end_time);
            $toleranceStart = $startTime->subMinutes($this->schedule->late_tolerance);

            Log::info('Time checks:', [
                'current' => $currentTime->toDateTimeString(),
                'start' => $startTime->toDateTimeString(),
                'end' => $endTime->toDateTimeString(),
                'tolerance' => $toleranceStart->toDateTimeString()
            ]);

            if ($this->isTimeInRange($currentTime, $toleranceStart, $endTime)) {
                Log::info('Setting showModal to true');
                $this->showModal = true;
            } else {
                Log::info('Current time not in range');
            }
        } catch (Exception $e) {
            Log::error('Error in checkAttendance: ' . $e->getMessage());
            // You might want to throw the exception here to see it in development
            throw $e;
        }
    }

    public function isHoliday()
    {
        try {
            $today = DateTimeHelper::now();

            // Check if today is in the holidays table
            $holiday = \App\Models\Holiday::query()
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->exists();

            // Check if today is in schedule_exceptions with status 'holiday'
            $scheduleException = \App\Models\ScheduleException::query()
                ->where('date', $today->toDateString())
                ->where('status', 'holiday')
                ->exists();

            return $holiday || $scheduleException;
        } catch (Exception $e) {
            Log::error('Error checking holiday status: ' . $e->getMessage());
            return false; // Return false on error to allow check-in
        }
    }

    public function hasCheckedInToday()
    {
        return Attendance::where('user_id', auth()->id())
            ->whereDate('date', DateTimeHelper::today())
            ->exists();
    }

    public function checkIn()
    {
        try {
            if (!$this->schedule) {
                throw new Exception('No schedule found for today.');
            }

            $now = DateTimeHelper::now();
            $startTime = DateTimeHelper::parse($this->schedule->start_time);
            $endTime = DateTimeHelper::parse($this->schedule->end_time);

            if ($now->greaterThan($endTime)) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Check-in is not allowed after working hours.'
                ]);
                $this->closeModal();
                return;
            }

            $toleranceLimit = $this->getToleranceLimit($startTime, $this->schedule->late_tolerance);
            $status = $now->greaterThan($toleranceLimit) ? 'late' : 'present';

            Attendance::create([
                'user_id' => auth()->id(),
                'date' => $now->toDateString(),
                'check_in' => $now,
                'status' => $status,
            ]);

            $this->dispatch('success-checkin');
        } catch (Exception $e) {
            Log::error('Error during check-in process', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
        }
    }

    public function render()
    {
        $this->currentTime = DateTimeHelper::now()->format('H:i:s');
        Log::info('Rendering with showModal: ' . ($this->showModal ? 'true' : 'false'));
        return view('livewire.shared.check-in-modal');
    }
}
