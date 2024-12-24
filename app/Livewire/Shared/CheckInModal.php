<?php

namespace App\Livewire\Shared;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Helpers\DateTimeHelper;
use App\Models\Holiday;
use App\Models\ScheduleException;
use App\Traits\DateTimeComparison;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckInModal extends Component
{
    use DateTimeComparison;

    public $showModal = false;
    public $currentTime;
    public $schedule;
    public $holidayInfo = null;

    protected $listeners = ['closeModal' => 'closeModal'];

    public function mount()
    {
        Log::info('CheckInModal mounted');
        $this->checkAttendance();
    }

    public function isHoliday()
    {
        try {
            $today = now();
            
            // Check holidays table
            $holiday = Holiday::query()
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->first();

            if ($holiday) {
                Log::info('Found holiday in holidays table');
                $this->holidayInfo = [
                    'type' => 'holiday',
                    'title' => $holiday->title,
                    'description' => $holiday->description
                ];
                return true;
            }

            // Check schedule exceptions
            $exception = ScheduleException::query()
                ->where('date', $today->toDateString())
                ->where('status', 'holiday')
                ->first();

            if ($exception) {
                Log::info('Found holiday in schedule exceptions');
                $this->holidayInfo = [
                    'type' => 'exception',
                    'title' => $exception->title,
                    'description' => $exception->note
                ];
                return true;
            }

            $this->holidayInfo = null;
            return false;
        } catch (Exception $e) {
            Log::error('Error checking holiday status: ' . $e->getMessage());
            return false;
        }
    }

    public function checkAttendance()
    {
        try {
            $this->showModal = false;
            
            if ($this->isHoliday()) {
                Log::info('Today is a holiday');
                return;
            }

            // Get current day name in lowercase to match database
            $today = strtolower(now()->format('l'));
            
            Log::info('Checking schedule:', [
                'day' => $today,
                'current_time' => now()->format('H:i:s')
            ]);

            if ($this->hasCheckedInToday()) {
                Log::info('User already checked in today');
                return;
            }

            // Find today's schedule
            $this->schedule = Schedule::where('day_of_week', $today)->first();
            
            if (!$this->schedule) {
                Log::info('No schedule found for today');
                return;
            }

            Log::info('Found schedule:', [
                'start_time' => $this->schedule->start_time,
                'end_time' => $this->schedule->end_time
            ]);

            $currentTime = now();
            $startTime = now()->setTimeFromTimeString($this->schedule->start_time);
            $endTime = now()->setTimeFromTimeString($this->schedule->end_time);
            
            // Check-in window starts 30 minutes before schedule
            $checkInWindowStart = $startTime->copy()->subMinutes(30);
            
            Log::info('Time checks:', [
                'current' => $currentTime->format('H:i:s'),
                'window_start' => $checkInWindowStart->format('H:i:s'),
                'start' => $startTime->format('H:i:s'),
                'end' => $endTime->format('H:i:s')
            ]);

            // Check if current time is within the check-in window
            if ($currentTime->between($checkInWindowStart, $endTime)) {
                Log::info('Current time is within check-in window');
                $this->showModal = true;
            } else {
                Log::info('Current time is outside check-in window');
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
            ->whereDate('date', now()->toDateString())
            ->exists();
    }

    public function checkIn()
    {
        try {
            if (!$this->schedule) {
                throw new Exception('No schedule found for today.');
            }

            $now = now();
            $startTime = now()->setTimeFromTimeString($this->schedule->start_time);
            $endTime = now()->setTimeFromTimeString($this->schedule->end_time);

            if ($now->greaterThan($endTime)) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Check-in is not allowed after working hours.'
                ]);
                $this->closeModal();
                return;
            }

            // Calculate status based on tolerance
            $toleranceLimit = $startTime->copy()->addMinutes($this->schedule->late_tolerance);
            $status = $now->greaterThan($toleranceLimit) ? 'late' : 'present';

            Attendance::create([
                'user_id' => auth()->id(),
                'date' => $now->toDateString(),
                'check_in' => $now,
                'status' => $status,
            ]);

            $this->dispatch('success-checkin');
            
        } catch (Exception $e) {
            Log::error('Error during check-in:', [
                'message' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to check in. Please try again.'
            ]);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        $this->currentTime = now()->format('H:i:s');
        return view('livewire.shared.check-in-modal');
    }
}