<?php

namespace App\Livewire\Shared;

use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckOutModal extends Component
{
    // Public Properties
    public $showModal = false;
    public $currentTime;
    public $attendance;
    public $workingHours;
    public $earlyLeaveReason;
    public $showEarlyLeaveForm = false;
    public $isSuccess = false;
    public $schedule;
    public $hasCompletedAttendance = false;

    // Livewire Event Listeners
    protected $listeners = ['openCheckOutModal' => 'openModal'];

    // Validation Rules
    protected $rules = [
        'earlyLeaveReason' => 'required_if:showEarlyLeaveForm,true|string|max:255'
    ];

    public function mount()
    {
        $this->getCurrentAttendance();
        $this->loadSchedule();
    }

    public function getCurrentAttendance()
    {
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$todayAttendance) {
            $this->attendance = null;
            $this->hasCompletedAttendance = false;
            return;
        }

        if ($todayAttendance->check_out) {
            $this->attendance = null;
            $this->hasCompletedAttendance = true;
            return;
        }

        $this->attendance = $todayAttendance;
        $this->hasCompletedAttendance = false;
        $this->calculateWorkingHours();
    }

    public function loadSchedule()
    {
        $today = strtolower(Carbon::now()->format('l'));
        $this->schedule = Schedule::where('day_of_week', $today)->first();

        if ($this->schedule && $this->attendance) {
            $currentTime = Carbon::now();
            $endTime = Carbon::parse($this->schedule->end_time);
            $this->showEarlyLeaveForm = $currentTime->lt($endTime);
        }
    }

    public function calculateWorkingHours()
    {
        if ($this->attendance) {
            $checkIn = Carbon::parse($this->attendance->check_in);
            $this->workingHours = round($checkIn->floatDiffInHours(Carbon::now()), 1);
        }
    }

    public function openModal()
    {
        $this->resetState();
        $this->getCurrentAttendance();
        $this->loadSchedule();

        if ($this->hasCompletedAttendance) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'You have already checked out for today.'
            ]);
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

    public function checkOut()
    {
        if ($this->showEarlyLeaveForm) {
            $this->validate();
        }

        try {
            if (!$this->attendance) {
                throw new Exception('No active attendance record found.');
            }

            $currentTime = Carbon::now();
            $updateData = [
                'check_out' => $currentTime,
                'working_hours' => $this->workingHours,
            ];

            // Only update status if it's an early leave
            if ($this->showEarlyLeaveForm) {
                $updateData['status'] = 'early_leave';
                $updateData['early_leave_reason'] = $this->earlyLeaveReason;
            }

            // Update attendance record
            $this->attendance->update($updateData);

            $this->isSuccess = true;
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Check-out successful!'
            ]);

            $this->dispatch('success-checkout');
        } catch (Exception $e) {
            logger()->error('Check-out error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'attendance_id' => $this->attendance?->id
            ]);

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to process check-out. Please try again.'
            ]);
        }
    }

    private function resetState()
    {
        $this->isSuccess = false;
        $this->earlyLeaveReason = '';
        $this->showEarlyLeaveForm = false;
        $this->attendance = null;
        $this->hasCompletedAttendance = false;
    }

    public function render()
    {
        $this->currentTime = Carbon::now()->format('H:i:s');
        return view('livewire.shared.check-out-modal');
    }
}
