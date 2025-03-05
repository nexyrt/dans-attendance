<?php

namespace App\Livewire\Director;

use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\Department;
use Auth;
use File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use Str;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Leave extends Component
{
    use WithFileUploads;

    /**
     * Component Properties
     */
    public $activeTab = 'pending';
    public $showPreview = false;
    public $previewUrl = null;
    public $previewType = null;
    public $showRejectModal = false;
    public $rejectReason = '';
    public $selectedRequest = null;
    public $selectedDepartment = null;
    public $signature = '';
    public $selectedLeaveRequest = null;
    public $showDepartmentFilter = true;

    /**
     * Initialize Component
     */
    public function mount()
    {
        // Director sees all departments by default, can filter if needed
        $this->selectedDepartment = null;
    }

    /**
     * Modal Handlers
     */
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
     * Department Filter Handler
     */
    public function updateDepartmentFilter($departmentId)
    {
        $this->selectedDepartment = $departmentId ?: null;
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

            // Add Director signature to document
            $templateProcessor->setImageValue('director_signature', public_path($signaturePath));

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
            'director_%s_%s.png',
            Str::slug($user->name),
            $user->id
        );

        // Save signature image
        $imageData = base64_decode(Str::of($this->signature)->after(','));
        $signaturePath = 'signatures/' . $filename;
        File::put(public_path($signaturePath), $imageData);

        // Add signature to document
        $documentSigned = $this->addSignatureToDocument($signaturePath);

        // Process the final approval
        DB::transaction(function () use ($user, $currentTime, $signaturePath) {
            // Update leave request status
            $this->selectedLeaveRequest->update([
                'status' => LeaveRequest::STATUS_APPROVED,
                'director_id' => $user->id,
                'director_approved_at' => $currentTime,
                'director_signature' => $signaturePath
            ]);

            // Update leave balance
            $leaveBalance = $this->selectedLeaveRequest->user->currentLeaveBalance();
            if ($leaveBalance) {
                $usedDays = $this->selectedLeaveRequest->getDurationInDays();
                $leaveBalance->updateBalance(
                    $leaveBalance->used_balance + $usedDays
                );

                // Create attendance records
                $startDate = $this->selectedLeaveRequest->start_date;
                $endDate = $this->selectedLeaveRequest->end_date;
                $currentDate = clone $startDate;

                while ($currentDate <= $endDate) {
                    if (!$currentDate->isWeekend()) {
                        $this->selectedLeaveRequest->user->attendances()->create([
                            'date' => $currentDate,
                            'status' => 'holiday',
                            'notes' => 'Approved leave: ' . $this->selectedLeaveRequest->type
                        ]);
                    }
                    $currentDate->addDay();
                }
            }
        });

        session()->flash('message', 'Leave request has been fully approved.' .
            ($documentSigned ? ' Document has been signed.' : ''));

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
                'status' => LeaveRequest::STATUS_REJECTED_DIRECTOR,
                'director_id' => auth()->id(),
                'director_approved_at' => now(),
                'rejection_reason' => $this->rejectReason
            ]);
        });

        $this->selectedRequest = null;
        $this->rejectReason = '';
        $this->showRejectModal = false;

        session()->flash('message', 'Leave request rejected successfully.');
    }

    /**
     * Preview Handlers
     */
    public function previewAttachment($requestId)
    {
        $request = LeaveRequest::findOrFail($requestId);
        if ($request->attachment_path) {
            $this->previewUrl = asset($request->attachment_path);
            $this->previewType = strtolower(pathinfo($request->attachment_path, PATHINFO_EXTENSION));
            $this->showPreview = true;
        }
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->previewUrl = null;
        $this->previewType = null;
    }

    /**
     * Data Getters
     */
    public function getLeaveRequestsProperty()
    {
        return LeaveRequest::query()
            // Filter by department if selected
            ->when($this->selectedDepartment, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('department_id', $this->selectedDepartment);
                });
            })
            // Filter by status based on active tab
            ->when($this->activeTab === 'pending', function ($query) {
                $query->where('status', LeaveRequest::STATUS_PENDING_DIRECTOR);
            })
            ->when($this->activeTab === 'approved', function ($query) {
                $query->where('status', LeaveRequest::STATUS_APPROVED);
            })
            ->when($this->activeTab === 'rejected', function ($query) {
                $query->where('status', LeaveRequest::STATUS_REJECTED_DIRECTOR);
            })
            ->with(['user.department', 'manager', 'hr'])
            ->latest()
            ->get()
            ->map(function ($request) {
                $request->user->currentLeaveBalance = $request->user->leaveBalances()
                    ->where('year', now()->year)
                    ->first();
                return $request;
            });
    }

    /**
     * Get all departments for filtering
     */
    public function getDepartmentsProperty()
    {
        return Department::orderBy('name')->get();
    }

    /**
     * Counter Getters
     */
    public function getPendingCountProperty()
    {
        return $this->getRequestsCount(LeaveRequest::STATUS_PENDING_DIRECTOR);
    }

    public function getApprovedCountProperty()
    {
        return $this->getRequestsCount(LeaveRequest::STATUS_APPROVED);
    }

    public function getRejectedCountProperty()
    {
        return $this->getRequestsCount(LeaveRequest::STATUS_REJECTED_DIRECTOR);
    }

    protected function getRequestsCount($status)
    {
        return LeaveRequest::query()
            ->when($this->selectedDepartment, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('department_id', $this->selectedDepartment);
                });
            })
            ->when(is_array($status), function ($query) use ($status) {
                $query->whereIn('status', $status);
            }, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }

    /**
     * Get department statistics for Director overview
     */
    public function getDepartmentStatsProperty()
    {
        return LeaveRequest::join('users', 'users.id', '=', 'leave_requests.user_id')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->select(
                'departments.name as department_name',
                'departments.id as department_id',
                DB::raw('COUNT(CASE WHEN leave_requests.status = "pending_director" THEN 1 END) as pending_count'),
                DB::raw('COUNT(CASE WHEN leave_requests.status = "approved" THEN 1 END) as approved_count'),
                DB::raw('COUNT(CASE WHEN leave_requests.status = "rejected_director" THEN 1 END) as rejected_count')
            )
            ->groupBy('departments.name', 'departments.id')
            ->get();
    }

    /**
     * Get monthly column chart model
     */
    public function getMonthlyColumnChartModelProperty()
    {
        $currentYear = now()->year;
        $monthlyStats = LeaveRequest::whereYear('created_at', $currentYear)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(CASE WHEN status = "approved" THEN 1 END) as approved'),
                DB::raw('COUNT(CASE WHEN status LIKE "rejected%" THEN 1 END) as rejected'),
                DB::raw('COUNT(CASE WHEN status LIKE "pending%" THEN 1 END) as pending')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Initialize column chart
        $columnChartModel = (new ColumnChartModel())
            ->setTitle('Monthly Leave Activity')
            ->setAnimated(true)
            ->withoutLegend()
            ->stacked();

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        // Insert all months with 0 values if not in the data
        foreach ($months as $monthNum => $monthName) {
            $month = $monthlyStats->firstWhere('month', $monthNum);
            
            // Add approved data
            $columnChartModel->addColumn(
                $monthName, 
                $month ? $month->approved : 0, 
                '#10B981'  // Green
            );

            // Add rejected data
            $columnChartModel->addColumn(
                $monthName . '_rejected', 
                $month ? $month->rejected : 0, 
                '#EF4444'  // Red
            );

            // Add pending data
            $columnChartModel->addColumn(
                $monthName . '_pending', 
                $month ? $month->pending : 0, 
                '#F59E0B'  // Yellow/amber
            );
        }

        $columnChartModel->withGrid();

        return $columnChartModel;
    }

    /**
     * Render Component
     */
    public function render()
    {
        $this->dispatch('refresh-preline');

        return view('livewire.director.leave', [
            'leaveRequests' => $this->leaveRequests,
            'departments' => $this->departments,
            'departmentStats' => $this->departmentStats,
            'monthlyColumnChartModel' => $this->monthlyColumnChartModel,
        ])->layout('layouts.director', ['title' => 'Director Leave Management']);
    }
}