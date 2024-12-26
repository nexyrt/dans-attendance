<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

use Cake\Chronos\Chronos;

class UserDetail extends Component
{
    public User $user;
    public $attendancePeriod = '30';

    // Computed properties
    public $attendanceRate;
    public $tasksCompleted;
    public $leaveBalance;
    public $onTimePercentage;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->calculateStatistics();
    }


    protected function getWorkdayCount($fromDate)
    {
        $count = 0;
        $current = Chronos::parse($fromDate);
        $now = new Chronos();

        // Get the user's department ID
        $departmentId = $this->user->department_id;

        // Get schedule exceptions for user's department
        $scheduleExceptions = \App\Models\ScheduleException::whereHas('departments', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->where('date', '>=', $fromDate)
            ->where('date', '<=', $now)
            ->get()
            ->pluck('status', 'date')
            ->toArray();

        while ($current->lessThanOrEquals($now)) {
            $currentDate = $current->format('Y-m-d');

            // Check if there's a schedule exception for this date
            if (isset($scheduleExceptions[$currentDate])) {
                $exceptionStatus = $scheduleExceptions[$currentDate];

                // Count the day based on the exception status
                switch ($exceptionStatus) {
                    case 'holiday':
                        // Don't count holidays
                        break;
                    case 'wfh':
                        // Count WFH as a full workday
                        $count++;
                        break;
                    case 'halfday':
                        // Count halfday as 0.5
                        $count += 0.5;
                        break;
                    case 'regular':
                        // Count regular days if not weekend
                        if (!$current->isWeekend()) {
                            $count++;
                        }
                        break;
                }
            } else {
                // No exception - count if it's not a weekend
                if (!$current->isWeekend()) {
                    $count++;
                }
            }

            $current = $current->addDays(1); // Changed from addDay() to addDays(1)
        }

        return $count;
    }

    protected function calculateStatistics()
    {
        // Calculate attendance rate
        $period = Chronos::now()->subDays($this->attendancePeriod);
        $totalWorkDays = $this->getWorkdayCount($period);

        $attendances = $this->user->attendance()
            ->where('date', '>=', $period)
            ->whereIn('status', ['present', 'late'])
            ->count();

        $this->attendanceRate = $totalWorkDays > 0
            ? round(($attendances / $totalWorkDays) * 100)
            : 0;

        // Calculate tasks completed
        $this->tasksCompleted = 0;

        // Get current year's leave balance
        $currentYearBalance = $this->user->leaveBalances()
            ->where('year', Chronos::now()->year)
            ->first();

        $this->leaveBalance = $currentYearBalance
            ? $currentYearBalance->remaining_balance
            : 0;
    }



    public function approveLeave($leaveId)
    {
        $leave = LeaveRequest::findOrFail($leaveId);

        if (auth()->user()->cannot('approve', $leave)) {
            return $this->addError('permission', 'You do not have permission to approve leave requests.');
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Update leave balance
        $startDate = Chronos::parse($leave->start_date);
        $endDate = Chronos::parse($leave->end_date);
        $leaveDays = $startDate->diffInDays($endDate) + 1;

        $leaveBalance = $this->user->leaveBalance()
            ->where('year', now()->year)
            ->first();

        if ($leaveBalance) {
            $leaveBalance->update([
                'used_balance' => $leaveBalance->used_balance + $leaveDays,
                'remaining_balance' => $leaveBalance->total_balance - ($leaveBalance->used_balance + $leaveDays)
            ]);
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Leave request approved successfully!'
        ]);
    }

    public function rejectLeave($leaveId)
    {
        $leave = LeaveRequest::findOrFail($leaveId);

        if (auth()->user()->cannot('approve', $leave)) {
            return $this->addError('permission', 'You do not have permission to reject leave requests.');
        }

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Leave request rejected successfully!'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.users.user-detail', [
            'attendances' => $this->user->attendance()
                ->where('date', '>=', now()->subDays($this->attendancePeriod))
                ->latest('date')
                ->take(10)
                ->get(),
            'leaveRequests' => $this->user->leaveRequests()
                ->latest()
                ->take(5)
                ->get(),
            'tasks' => null
        ]);
    }
}
