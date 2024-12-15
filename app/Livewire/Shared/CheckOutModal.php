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

class CheckOutModal extends Component
{
    use DateTimeComparison;

    public $showModal = false;
    public $currentTime;
    public $attendance;
    public $todayAttendance; // Add this property to track completed attendance
    public $workingHours;
    public $earlyLeaveReason;
    public $showEarlyLeaveForm = false;
    public $isSuccess = false;
    public $schedule;
    public $hasCompletedAttendance = false;

    protected $listeners = ['openCheckOutModal' => 'openModal'];

    protected $rules = [
        'earlyLeaveReason' => 'required_if:showEarlyLeaveForm,true|string|max:255'
    ];

    public function mount()
    {
        $this->loadTodayAttendance();
        $this->loadSchedule();
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

            $currentTime = DateTimeHelper::now();
            $updateData = [
                'check_out' => $currentTime,
                'working_hours' => $this->workingHours,
            ];

            if ($this->showEarlyLeaveForm) {
                $updateData['status'] = 'early_leave';
                $updateData['early_leave_reason'] = $this->earlyLeaveReason;
            }

            $this->attendance->update($updateData);
            $this->loadTodayAttendance(); // Reload attendance after update
            $this->isSuccess = true;
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Check-out successful!'
            ]);

            $this->dispatch('success-checkout');
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