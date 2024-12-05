<?php

namespace App\Livewire\Shared;

use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckInModal extends Component
{
    public $showModal = false;
    public $currentTime;
    public $schedule;

    protected $listeners = ['closeModal' => 'closeModal'];

    public function mount()
    {
        $this->checkAttendance();
    }

    public function checkAttendance()
    {
        $this->showModal = false;

        try {
            if ($this->isHoliday()) {
                return;
            }

            if ($this->hasCheckedInToday()) {
                return;
            }

            $today = strtolower(Carbon::now()->format('l'));
            $this->schedule = Schedule::where('day_of_week', $today)->first();

            if (!$this->schedule) {
                return;
            }

            $currentTime = Carbon::now();
            $startTime = Carbon::parse($this->schedule->start_time);
            $endTime = Carbon::parse($this->schedule->end_time);

            // Show modal only if current time is between start time and end time
            if ($currentTime->between(
                $startTime->copy()->subMinutes($this->schedule->late_tolerance),
                $endTime
            )) {
                $this->showModal = true;
            }
        } catch (Exception $e) {
            Log::error('Error in checkAttendance: ' . $e->getMessage());
        }
    }

    public function isHoliday()
    {
        // Implementasi pengecekan hari libur
        return false;
    }

    public function hasCheckedInToday()
    {
        return Attendance::where('user_id', auth()->id())
            ->whereDate('date', Carbon::today())
            ->exists();
    }

    public function checkIn()
    {
        try {
            if (!$this->schedule) {
                throw new Exception('No schedule found for today.');
            }

            $now = Carbon::now();
            $startTime = Carbon::parse($this->schedule->start_time);
            $endTime = Carbon::parse($this->schedule->end_time);

            // Prevent check-in after working hours
            if ($now->gt($endTime)) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Check-in is not allowed after working hours.'
                ]);
                $this->closeModal();
                return;
            }

            $toleranceLimit = $startTime->copy()->addMinutes($this->schedule->late_tolerance);

            // Determine status based on tolerance limit
            $status = $now->gt($toleranceLimit) ? 'late' : 'present';

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

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        $this->currentTime = Carbon::now()->format('H:i:s');
        return view('livewire.shared.check-in-modal');
    }
}
