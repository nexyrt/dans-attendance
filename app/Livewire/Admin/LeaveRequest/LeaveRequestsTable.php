<?php

namespace App\Livewire\Admin\LeaveRequest;

use App\Models\Department;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Cake\Chronos\Chronos;

class LeaveRequestsTable extends Component
{
    use WithPagination;

    public $managers; // Add this property
    public $selectedPeriod = 'today';
    // Add these properties
    public $showStatusModal = false;
    public $users; // Add users property
    public $showEditModal = false;
    public $selectedRequest = null;
    public $filters = [
        'leavetype' => [],  // Changed to array
        'status' => [],     // Changed to array
        'search' => '',
        'startDate' => '',
        'endDate' => '',
    ];
    public $activeFilters = [];
    // For edit modal
    public $editForm = [
        'type' => '',
        'start_date' => '',
        'end_date' => '',
        'reason' => '',
    ];
    public $showCreateModal = false;
    public $createForm = [
        'user_id' => '', // Add user_id field
        'type' => '',
        'start_date' => '',
        'end_date' => '',
        'reason' => '',
        'approved_by' => '',
    ];

    public function mount()
    {
        $this->managers = User::where('role', 'manager')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        $this->users = User::where('role', '!=', 'manager')
            ->select('id', 'name', 'email', 'department_id')
            ->orderBy('name')
            ->get();

        $this->filters['startDate'] = now()->startOfMonth()->format('Y-m-d');
        $this->filters['endDate'] = now()->endOfMonth()->format('Y-m-d');
        $this->activeFilters = array_filter($this->filters, fn($value) => !empty ($value));
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


    // Add watchers for automatic filter application
    public function updatedFilters($value, $key)
    {
        // Clear empty values from arrays
        if (is_array($value)) {
            $value = array_filter($value);
        }

        // Update activeFilters
        if (empty($value)) {
            unset($this->activeFilters[$key]);
        } else {
            $this->activeFilters[$key] = $value;
        }

        // Special handling for date range
        if ($key === 'startDate' || $key === 'endDate') {
            if (!empty($this->filters['startDate']) && !empty($this->filters['endDate'])) {
                $this->activeFilters['startDate'] = $this->filters['startDate'];
                $this->activeFilters['endDate'] = $this->filters['endDate'];
            } else {
                unset($this->activeFilters['startDate'], $this->activeFilters['endDate']);
            }
        }

        $this->resetPage();
    }

    public function changeStatus($requestId)
    {
        $this->selectedRequest = LeaveRequest::find($requestId);
        $this->showStatusModal = true;
    }

    public function updateStatus($newStatus)
    {
        if (!$this->selectedRequest) {
            return;
        }

        try {
            if ($newStatus === 'approved' && $this->selectedRequest->type === 'annual') {
                // Check leave balance
                $balanceCheck = $this->checkLeaveBalance(
                    $this->selectedRequest->user_id,
                    $this->selectedRequest->start_date,
                    $this->selectedRequest->end_date
                );

                if (!$balanceCheck['available']) {
                    session()->flash('error', $balanceCheck['message']);
                    return;
                }

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
                    return;
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

    public function editRequest($requestId)
    {
        $this->selectedRequest = LeaveRequest::find($requestId);
        $this->editForm = [
            'type' => $this->selectedRequest->type,
            'start_date' => $this->selectedRequest->start_date,
            'end_date' => $this->selectedRequest->end_date,
            'reason' => $this->selectedRequest->reason,
        ];
        $this->showEditModal = true;
    }

    public function updateRequest()
    {
        $this->validate([
            'editForm.type' => 'required|in:sick,annual,important,other',
            'editForm.start_date' => 'required|date',
            'editForm.end_date' => 'required|date|after_or_equal:editForm.start_date',
            'editForm.reason' => 'required|string',
        ]);

        try {
            // If it's an approved annual leave request
            if ($this->selectedRequest->status === 'approved' && $this->selectedRequest->type === 'annual') {
                // Start transaction
                \DB::beginTransaction();

                // Restore old balance
                $this->restoreLeaveBalance(
                    $this->selectedRequest->user_id,
                    $this->selectedRequest->start_date,
                    $this->selectedRequest->end_date
                );

                // Check new balance
                $balanceCheck = $this->checkLeaveBalance(
                    $this->selectedRequest->user_id,
                    $this->editForm['start_date'],
                    $this->editForm['end_date']
                );

                if (!$balanceCheck['available']) {
                    \DB::rollBack();
                    session()->flash('error', $balanceCheck['message']);
                    return;
                }

                // Update leave balance with new dates
                $balance = $balanceCheck['balance'];
                $balance->used_balance += $balanceCheck['days'];
                $balance->remaining_balance -= $balanceCheck['days'];
                $balance->save();
            }

            // Update the request
            $this->selectedRequest->update([
                'type' => $this->editForm['type'],
                'start_date' => $this->editForm['start_date'],
                'end_date' => $this->editForm['end_date'],
                'reason' => $this->editForm['reason'],
            ]);

            \DB::commit();

            $this->showEditModal = false;
            $this->selectedRequest = null;
            $this->dispatch('request-updated');
            session()->flash('message', 'Leave request updated successfully.');

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Error updating leave request: ' . $e->getMessage());
        }
    }

    public function createRequest()
    {
        $this->validate([
            'createForm.user_id' => 'required|exists:users,id',
            'createForm.type' => 'required|in:sick,annual,important,other',
            'createForm.start_date' => 'required|date',
            'createForm.end_date' => 'required|date|after_or_equal:createForm.start_date',
            'createForm.reason' => 'required|string',
            'createForm.approved_by' => 'required|exists:users,id',
        ]);

        LeaveRequest::create([
            'user_id' => $this->createForm['user_id'],
            'type' => $this->createForm['type'],
            'start_date' => $this->createForm['start_date'],
            'end_date' => $this->createForm['end_date'],
            'reason' => $this->createForm['reason'],
            'approved_by' => $this->createForm['approved_by'],
            'status' => 'pending',
        ]);

        $this->showCreateModal = false;
        $this->reset('createForm');
        session()->flash('message', 'Leave request created successfully.');
    }

    // Add watcher specifically for search with debounce
    public function updatedFiltersSearch()
    {
        $this->resetPage();
    }


    // Add a method to handle balance restoration if needed
    private function restoreLeaveBalance($userId, $startDate, $endDate)
    {
        $year = Carbon::parse($startDate)->year;
        $leaveBalance = LeaveBalance::where('user_id', $userId)
            ->where('year', $year)
            ->first();

        if ($leaveBalance) {
            $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
            $leaveBalance->used_balance -= $days;
            $leaveBalance->remaining_balance += $days;
            $leaveBalance->save();
        }
    }

    public function setDateRange($range)
    {
        $this->filters['startDate'] = match ($range) {
            'today' => now()->format('Y-m-d'),
            'yesterday' => now()->subDay()->format('Y-m-d'),
            'thisWeek' => now()->startOfWeek()->format('Y-m-d'),
            'lastWeek' => now()->subWeek()->startOfWeek()->format('Y-m-d'),
            'thisMonth' => now()->startOfMonth()->format('Y-m-d'),
            'lastMonth' => now()->subMonth()->startOfMonth()->format('Y-m-d'),
            'last30Days' => now()->subDays(30)->format('Y-m-d'),
            'last90Days' => now()->subDays(90)->format('Y-m-d'),
        };

        $this->filters['endDate'] = match ($range) {
            'today' => now()->format('Y-m-d'),
            'yesterday' => now()->subDay()->format('Y-m-d'),
            'thisWeek' => now()->endOfWeek()->format('Y-m-d'),
            'lastWeek' => now()->subWeek()->endOfWeek()->format('Y-m-d'),
            'thisMonth' => now()->endOfMonth()->format('Y-m-d'),
            'lastMonth' => now()->subMonth()->endOfMonth()->format('Y-m-d'),
            'last30Days' => now()->format('Y-m-d'),
            'last90Days' => now()->format('Y-m-d'),
        };
    }

    public function getLeaveRequests()
    {
        $query = LeaveRequest::query()
            ->with('user')
            ->when($this->filters['startDate'] && $this->filters['endDate'], function ($query) {
                $query->whereBetween('start_date', [
                    $this->filters['startDate'],
                    $this->filters['endDate']
                ]);
            })
            ->when(!empty($this->filters['leavetype']), function ($query) {
                $query->whereIn('type', $this->filters['leavetype']);
            })
            ->when(!empty($this->filters['status']), function ($query) {
                $query->whereIn('status', $this->filters['status']);
            })
            ->when($this->filters['search'], function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->filters['search'] . '%')
                        ->orWhere('email', 'like', '%' . $this->filters['search'] . '%');
                });
            });

        return $query->latest()->paginate(10);
    }

    public function applyFilters()
    {
        $this->activeFilters = array_filter($this->filters, fn($value) => !empty ($value));
        $this->resetPage();
    }

    public function removeFilter($key)
    {
        if ($key === 'startDate' || $key === 'endDate') {
            $this->filters['startDate'] = '';
            $this->filters['endDate'] = '';
            unset($this->activeFilters['startDate'], $this->activeFilters['endDate']);
        } else {
            $this->filters[$key] = is_array($this->filters[$key]) ? [] : '';
            unset($this->activeFilters[$key]);
        }
        $this->resetPage();
    }

    public function removeFilterValue($key, $value)
    {
        if (isset($this->filters[$key]) && is_array($this->filters[$key])) {
            $this->filters[$key] = array_filter($this->filters[$key], function ($v) use ($value) {
                return $v !== $value;
            });

            if (empty($this->filters[$key])) {
                unset($this->activeFilters[$key]);
            } else {
                $this->activeFilters[$key] = $this->filters[$key];
            }
        }
        $this->resetPage();
    }

    // Update the resetFilters method
    public function resetFilters()
    {
        $this->filters = [
            'leavetype' => [],
            'status' => [],
            'search' => '',
            'startDate' => now()->startOfMonth()->format('Y-m-d'),
            'endDate' => now()->endOfMonth()->format('Y-m-d'),
        ];
        $this->activeFilters = [];
        $this->resetPage();
        $this->dispatch('reset-filters');
    }

    public function getStatistics()
    {
        return [
            'pending_requests' => LeaveRequest::where('status', 'pending')->count(),
            'approved_requests' => LeaveRequest::where('status', 'approved')
                ->whereMonth('created_at', Chronos::now()->month)
                ->count(),
            'total_leaves' => LeaveRequest::whereIn('status', ['approved', 'pending'])
                ->whereMonth('created_at', Chronos::now()->month)
                ->count(),
            'rejected_requests' => LeaveRequest::where('status', 'rejected')
                ->whereMonth('created_at', Chronos::now()->month)
                ->count(),
        ];
    }

    public function deleteRequest($id)
    {
        $request = LeaveRequest::find($id);
        if ($request) {
            $request->delete();
            session()->flash('message', 'Leave request deleted successfully.');
        }
    }

    public function render()
    {
        $statistics = $this->getStatistics();
        $departments = Department::all();
        return view('livewire.admin.leave-request.leave-requests-table', [
            'leaveRequests' => $this->getLeaveRequests(),
            'statistics' => $statistics,
            'departments' => $departments
        ]);
    }
}

