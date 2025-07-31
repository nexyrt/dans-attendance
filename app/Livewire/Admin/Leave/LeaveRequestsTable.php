<?php

namespace App\Livewire\Admin\Leave;

use App\Exports\LeaveRequestsExport;
use App\Models\Department;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\User;
use Auth;
use DB;
use File;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Cake\Chronos\Chronos;
use PhpOffice\PhpWord\TemplateProcessor;
use Str;

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


    public $activeTab = 'pending';
    public $showPreview = false;
    public $previewUrl = null;
    public $previewType = null;
    public $showRejectModal = false;
    public $rejectReason = '';
    public $selectedDepartment = null;
    public $signature = '';
    public $selectedLeaveRequest = null;


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

    // For Signature
    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->selectedRequest = null;
        $this->rejectReason = '';
        $this->resetValidation();
    }

    public function openSignatureModal($leaveRequestId)
    {
        $this->selectedLeaveRequest = LeaveRequest::find($leaveRequestId);
        $this->dispatch('open-modal', 'signature-modal');
    }

    /**
     * Document Signature Handler
     */
    private function addSignatureToDocument($signaturePath)
    {
        try {
            // Check if document exists
            if (
                !$this->selectedLeaveRequest->attachment_path ||
                !File::exists(public_path($this->selectedLeaveRequest->attachment_path))
            ) {
                return false;
            }

            // Initialize template processor with the document
            $templateProcessor = new TemplateProcessor(
                public_path($this->selectedLeaveRequest->attachment_path)
            );

            // Get current user and their department
            $user = auth()->user();
            $department = $user->department;

            // HR specific placeholders
            $placeholders = [
                'signature' => 'hr_signature',
                'name' => 'hr_name',
                'department' => 'hr_department'
            ];

            // Set signature image
            $templateProcessor->setImageValue($placeholders['signature'], public_path($signaturePath));

            // Set name and department values
            $templateProcessor->setValue($placeholders['name'], $user->name);
            $templateProcessor->setValue($placeholders['department'], $department->name);

            // Save document with the same filename (override)
            $templateProcessor->saveAs(public_path($this->selectedLeaveRequest->attachment_path));

            return true;
        } catch (\Exception $e) {
            \Log::error('Error adding signature to document: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Signature Approval Process
     */
    public function saveSignatureAndApprove()
    {
        // Validate signature
        $this->validate([
            'signature' => 'required'
        ]);

        $user = Auth::user();
        $currentTime = now();

        // Create signatures directory if not exists
        $directory = public_path('signatures');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Generate signature filename
        $filename = sprintf(
            '%s_%s_%s.png',
            'hr',
            Str::slug($user->name),
            $user->id
        );

        // Save signature image
        $imageData = base64_decode(Str::of($this->signature)->after(','));
        $signaturePath = 'signatures/' . $filename;
        File::put(public_path($signaturePath), $imageData);

        // Add signature to document
        $documentSigned = $this->addSignatureToDocument($signaturePath);

        // Process HR approval
        $status = [
            'status' => 'pending_director',
            'hr_id' => $user->id,
            'hr_approved_at' => $currentTime,
            'hr_signature' => $signaturePath,
            'message' => 'Leave request approved and sent to Director.'
        ];

        // Update leave request with HR approval details
        $this->selectedLeaveRequest->update(collect($status)->except('message')->toArray());

        session()->flash('message', $status['message'] . ($documentSigned ? ' Document has been signed.' : ''));

        $this->dispatch('close-modal', 'signature-modal');
        $this->resetSignature();
    }

    /**
     * Reset Handlers
     */
    private function resetSignature()
    {
        $this->selectedLeaveRequest = null;
        $this->signature = '';
    }

    /**
     * Reject Process Handlers
     */
    public function showModalReject($requestId)
    {
        $this->selectedRequest = LeaveRequest::findOrFail($requestId);
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function rejectRequest()
    {
        $this->validate([
            'rejectReason' => 'required|min:10',
        ]);

        if (!$this->selectedRequest) {
            return;
        }

        DB::transaction(function () {
            $this->selectedRequest->update([
                'status' => LeaveRequest::STATUS_REJECTED_HR,
                'hr_id' => auth()->id(),
                'hr_approved_at' => now(),
                'rejection_reason' => $this->rejectReason
            ]);
        });

        $this->selectedRequest = null;
        $this->rejectReason = '';
        $this->showRejectModal = false;

        session()->flash('message', 'Leave request rejected by HR successfully.');
    }

    /**
     * Data Getters
     */
    public function getLeaveRequestsProperty()
    {
        return LeaveRequest::query()
            ->when($this->activeTab === 'pending', function ($query) {
                $query->where('status', LeaveRequest::STATUS_PENDING_HR);
            })
            ->when($this->activeTab === 'approved', function ($query) {
                $query->whereIn('status', [
                    LeaveRequest::STATUS_PENDING_DIRECTOR,
                    LeaveRequest::STATUS_APPROVED
                ])->where('hr_id', auth()->id());
            })
            ->when($this->activeTab === 'rejected', function ($query) {
                $query->where('status', LeaveRequest::STATUS_REJECTED_HR)
                      ->where('hr_id', auth()->id());
            })
            ->with(['user.department'])
            ->latest()
            ->get()
            ->map(function ($request) {
                $request->user->currentLeaveBalance = $request->user->leaveBalances()
                    ->where('year', now()->year)
                    ->first();
                return $request;
            });
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

    public function exportToExcell()
{
    $filters = [
        'startDate' => $this->filters['startDate'] ?? null,
        'endDate' => $this->filters['endDate'] ?? null,
        'leavetype' => $this->filters['leavetype'] ?? null,
        'status' => $this->filters['status'] ?? null,
        'search' => $this->filters['search'] ?? null
    ];

    return (new LeaveRequestsExport($filters))
        ->download('leave-requests-' . now()->format('Y-m-d') . '.xlsx');
}

    public function render()
    {
        $statistics = $this->getStatistics();
        $departments = Department::all();
        return view('livewire.admin.leave.leave-requests-table', [
            'leaveRequests' => $this->getLeaveRequests(),
            'statistics' => $statistics,
            'departments' => $departments
        ]);
    }
}

