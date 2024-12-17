<?php

namespace App\Livewire\Admin\Leave;

use App\Models\LeaveBalance;
use Livewire\Component;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class LeaveDashboard extends Component
{
    public $selectedStatus = null;
    public $selectedRequest;
    public $showStatusModal = false;
    public $actionType = null; // Track which action was initiated


    // Add event listeners for Livewire lifecycle hooks
    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function setStatusFilter($status)
    {
        $this->selectedStatus = $status;
    }

    public function mount()
    {
        $this->yearFilter = date('Y');
    }

    private function getChartData($status)
    {
        // Get last 7 months of data
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = LeaveRequest::where('status', $status)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return $data;
    }

    // Add this method to your LeaveDashboard class
    private function getLeaveTypeStats()
    {
        $types = ['sick', 'annual', 'important', 'other'];
        $stats = [];

        foreach ($types as $type) {
            $query = LeaveRequest::where('type', $type);

            // Apply status filter if selected
            if ($this->selectedStatus) {
                $query->where('status', $this->selectedStatus);
            }

            // Get counts by status
            $statusCounts = LeaveRequest::where('type', $type)
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $stats[$type] = [
                'count' => array_sum($statusCounts),
                'status_counts' => $statusCounts,
                'color' => $this->getTypeColor($type),
                'icon' => $this->getTypeIcon($type),
                'label' => ucfirst($type)
            ];
        }

        return $stats;
    }

    private function getTypeColor($type)
    {
        return [
            'sick' => 'violet',
            'annual' => 'blue',
            'important' => 'orange',
            'other' => 'slate'
        ][$type];
    }

    public function initiateStatusChange($leaveId, $action)
    {
        $this->selectedRequest = LeaveRequest::find($leaveId);
        $this->actionType = $action;
        $this->showStatusModal = true;
    }

    public function checkLeaveBalance($userId, $startDate, $endDate)
    {

        $year = Carbon::parse($startDate)->year;

        $leaveBalance = LeaveBalance::where('user_id', $userId)
            ->where('year', $year)
            ->first();


        if (!$leaveBalance) {
            return [
                'available' => false,
                'message' => 'No leave balance found for the selected year.'
            ];
        }

        // Calculate number of days
        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;

        if ($leaveBalance->remaining_balance < $days) {
            return [
                'available' => false,
                'message' => "Insufficient leave balance. Available: {$leaveBalance->remaining_balance} days, Requested: {$days} days."
            ];

        }

        return [
            'available' => true,
            'balance' => $leaveBalance,
            'days' => $days
        ];
    }

    public function updateStatus($newStatus)
    {
        if (!$this->selectedRequest) {
            return;
        }

        try {
            if ($newStatus === 'approved' && $this->selectedRequest->type === 'annual') {
                $balanceCheck = $this->checkLeaveBalance(
                    $this->selectedRequest->user_id,
                    $this->selectedRequest->start_date,
                    $this->selectedRequest->end_date
                );

                if (!$balanceCheck['available']) {
                    session()->flash('error', $balanceCheck['message']);
                } else {
                    // Start a database transaction
                    \DB::beginTransaction();

                    try {
                        // Update the leave request status
                        $this->selectedRequest->update([
                            'status' => $newStatus,
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        // Update leave balance
                        $balance = $balanceCheck['balance'];
                        $balance->used_balance += $balanceCheck['days'];
                        $balance->remaining_balance -= $balanceCheck['days'];
                        $balance->save();

                        \DB::commit();
                        session()->flash('message', 'Leave request status updated and balance adjusted successfully.');
                    } catch (\Exception $e) {
                        \DB::rollBack();
                        session()->flash('error', 'Error updating leave request: ' . $e->getMessage());
                    }
                }
            } else {
                $this->selectedRequest->update([
                    'status' => $newStatus,
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);
                session()->flash('message', 'Leave request status updated successfully.');
            }
            $this->showStatusModal = false;
            $this->selectedRequest = null;
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating leave request: ' . $e->getMessage());
        }

    }

    private function getTypeIcon($type)
    {
        return [
            'sick' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', // Clock
            'annual' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', // Calendar
            'important' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', // Exclamation
            'other' => 'M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3', // Pattern
        ][$type];
    }

    private function calculateGrowth($currentValue, $previousValue)
    {
        if ($previousValue == 0)
            return 0;
        return round((($currentValue - $previousValue) / $previousValue) * 100, 1);
    }

    private function getCurrentLeaves()
    {
        return LeaveRequest::where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with([
                'user' => function ($query) {
                    $query->with('department');
                }
            ])
            ->latest('start_date')
            ->get();
    }

    public function render()
    {
        $leaveStats = [
            'approved' => [
                'count' => LeaveRequest::where('status', 'approved')->count(),
                'chartData' => $this->getChartData('approved'),
                'growth' => $this->calculateGrowth(
                    LeaveRequest::where('status', 'approved')->whereMonth('created_at', now()->month)->count(),
                    LeaveRequest::where('status', 'approved')->whereMonth('created_at', now()->subMonth()->month)->count()
                )
            ],
            'pending' => [
                'count' => LeaveRequest::where('status', 'pending')->count(),
                'chartData' => $this->getChartData('pending'),
                'growth' => $this->calculateGrowth(
                    LeaveRequest::where('status', 'pending')->whereMonth('created_at', now()->month)->count(),
                    LeaveRequest::where('status', 'pending')->whereMonth('created_at', now()->subMonth()->month)->count()
                )
            ],
            'rejected' => [
                'count' => LeaveRequest::where('status', 'rejected')->count(),
                'chartData' => $this->getChartData('rejected'),
                'growth' => $this->calculateGrowth(
                    LeaveRequest::where('status', 'rejected')->whereMonth('created_at', now()->month)->count(),
                    LeaveRequest::where('status', 'rejected')->whereMonth('created_at', now()->subMonth()->month)->count()
                )
            ]
        ];

        $leaveTypeStats = $this->getLeaveTypeStats();
        $currentLeaves = $this->getCurrentLeaves();

        $pendingLeaves = LeaveRequest::where('status', 'pending')
            ->with([
                'user' => function ($query) {
                    $query->with('department');
                }
            ])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.leave.leave-dashboard', [
            'leaveStats' => $leaveStats,
            'leaveTypeStats' => $leaveTypeStats,
            'pendingLeaves' => $pendingLeaves,
            'currentLeaves' => $currentLeaves
        ]);
    }
}