<?php

namespace App\Livewire\Manager;

use App\Models\User;
use App\Models\LeaveRequest;
use Auth;
use File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use Str;

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

    /**
     * Initialize Component
     */
    public function mount()
    {
        $this->selectedDepartment = auth()->user()->department_id;
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

            // Determine placeholder based on user role
            $role = $user->role;
            $placeholders = match ($role) {
                'manager' => [
                    'signature' => 'manager_signature',
                    'name' => 'manager_name',
                    'department' => 'department_name'
                ],
                'admin' => [
                    'signature' => 'hr_signature',
                    'name' => 'hr_name',
                    'department' => 'hr_department'
                ],
                'director' => [
                    'signature' => 'director_signature',
                    'name' => 'director_name',
                    'department' => 'director_department'
                ],
                default => null
            };

            if (!$placeholders)
                return false;

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
            strtolower($user->role),
            Str::slug($user->name),
            $user->id
        );

        // Save signature image
        $imageData = base64_decode(Str::of($this->signature)->after(','));
        $signaturePath = 'signatures/' . $filename;
        File::put(public_path($signaturePath), $imageData);

        // Add signature to document
        $documentSigned = $this->addSignatureToDocument($signaturePath);

        // Process approval based on role
        $status = match ($user->role) {
            'manager' => [
                'status' => 'pending_hr',
                'manager_id' => $user->id,
                'manager_approved_at' => $currentTime,
                'manager_signature' => $signaturePath,
                'message' => 'Leave request approved and sent to HR.'
            ],
            'admin' => [
                'status' => 'pending_director',
                'hr_id' => $user->id,
                'hr_approved_at' => $currentTime,
                'hr_signature' => $signaturePath,
                'message' => 'Leave request approved and sent to Director.'
            ],
            'director' => [
                'status' => 'approved',
                'director_id' => $user->id,
                'director_approved_at' => $currentTime,
                'director_signature' => $signaturePath,
                'message' => 'Leave request has been fully approved.'
            ],
            default => null
        };

        if ($status) {
            if ($status['status'] === 'approved') {
                $this->finalizeApproval($user, $currentTime, $signaturePath);
            } else {
                $this->selectedLeaveRequest->update(collect($status)->except('message')->toArray());
            }

            session()->flash('message', $status['message'] . ($documentSigned ? ' Document has been signed.' : ''));
        }

        $this->dispatch('close-modal', 'signature-modal');
        $this->resetSignature();
    }

    /**
     * Final Approval Handler
     */
    private function finalizeApproval($user, $currentTime, $signaturePath)
    {
        DB::transaction(function () use ($user, $currentTime, $signaturePath) {
            // Update leave request status
            $this->selectedLeaveRequest->update([
                'status' => 'approved',
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
                'status' => LeaveRequest::STATUS_REJECTED_MANAGER,
                'manager_id' => auth()->id(),
                'manager_approved_at' => now(),
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
            ->where('user_id', '!=', auth()->id())
            ->whereHas('user', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            })
            ->when($this->activeTab === 'pending', function ($query) {
                $query->where('status', LeaveRequest::STATUS_PENDING_MANAGER);
            })
            ->when($this->activeTab === 'approved', function ($query) {
                $query->whereIn('status', [
                    LeaveRequest::STATUS_PENDING_HR,
                    LeaveRequest::STATUS_PENDING_DIRECTOR,
                    LeaveRequest::STATUS_APPROVED
                ]);
            })
            ->when($this->activeTab === 'rejected', function ($query) {
                $query->where('status', LeaveRequest::STATUS_REJECTED_MANAGER);
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

    public function getTeamLeaveBalancesProperty()
    {
        return User::where('department_id', $this->selectedDepartment)
            ->where('id', '!=', auth()->id())
            ->with([
                'leaveRequests' => function ($query) {
                    $query->whereYear('created_at', now()->year);
                }
            ])
            ->get()
            ->each(function ($user) {
                $user->currentLeaveBalance = $user->leaveBalances()
                    ->where('year', now()->year)
                    ->first();
            });
    }

    /**
     * Counter Getters
     */
    public function getPendingCountProperty()
    {
        return $this->getDepartmentRequestsCount(LeaveRequest::STATUS_PENDING_MANAGER);
    }

    public function getApprovedCountProperty()
    {
        return $this->getDepartmentRequestsCount([
            LeaveRequest::STATUS_PENDING_HR,
            LeaveRequest::STATUS_PENDING_DIRECTOR,
            LeaveRequest::STATUS_APPROVED
        ]);
    }

    public function getRejectedCountProperty()
    {
        return $this->getDepartmentRequestsCount(LeaveRequest::STATUS_REJECTED_MANAGER);
    }

    protected function getDepartmentRequestsCount($status)
    {
        return LeaveRequest::query()
            ->where('user_id', '!=', auth()->id())
            ->whereHas('user', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            })
            ->when(is_array($status), function ($query) use ($status) {
                $query->whereIn('status', $status);
            }, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }

    /**
     * Render Component
     */
    public function render()
    {
        return view('livewire.manager.leave', [
            'leaveRequests' => $this->leaveRequests,
            'teamBalances' => $this->teamLeaveBalances,
        ])->layout('layouts.manager', ['title' => 'Leave Management']);
    }
}