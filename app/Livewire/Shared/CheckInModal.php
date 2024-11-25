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
        // Reset modal state
        $this->showModal = false;

        try {
            // Cek apakah hari ini libur
            if ($this->isHoliday()) {
                return;
            }

            // Cek apakah sudah check-in hari ini
            if ($this->hasCheckedInToday()) {
                return;
            }

            // Get current schedule
            $today = strtolower(Carbon::now()->format('l'));
            $this->schedule = Schedule::where('day_of_week', $today)->first();

            if ($this->schedule) {
                $currentTime = Carbon::now();
                $startTime = Carbon::parse($this->schedule->start_time);

                // Show modal if it's time to check-in
                if ($currentTime->gte($startTime)) {
                    $this->showModal = true;
                }
            }
        } catch (\Exception $e) {
            // Log error jika diperlukan
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
            $now = Carbon::now();
            $startTime = Carbon::parse($this->schedule->start_time);
            $toleranceLimit = $startTime->copy()->addMinutes($this->schedule->late_tolerance);

            // Tentukan status
            $status = 'present';
            if ($now->gt($toleranceLimit)) {
                $status = 'late';
            }

            // Buat record attendance
            Attendance::create([
                'user_id' => auth()->id(),
                'date' => $now->toDateString(),
                'check_in' => $now,
                'status' => $status,
            ]);

            // Dispatch event untuk menampilkan success state
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
