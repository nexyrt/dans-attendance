<?php

namespace App\Livewire\Hr;

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
    public $signature = '';
    public $selectedLeaveRequest = null;

    /**
     * Initialize Component
     */
    public function mount()
    {
        // HR might not be tied to a specific department
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
            if (!$this->selectedLeaveRequest->attachment_path || 
                !File::exists(public_path($this->selectedLeaveRequest->attachment_path))) {
                return false;
            }

            // Initialize template processor with the document
            $templateProcessor = new TemplateProcessor(
                public_path($this->selectedLeaveRequest->attachment_path)
            );

            // For HR, set the hr_signature placeholder
            $templateProcessor->setImageValue('hr_signature', public_path($signaturePath));

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

        // Update the leave request status to pending_director
        $this->selectedLeaveRequest->update([
            'status' => LeaveRequest::STATUS_PENDING_DIRECTOR,
            'hr_id' => $user->id,
            'hr_approved_at' => $currentTime,
            'hr_signature' => $signaturePath
        ]);

        session()->flash('message', 'Leave request approved and sent to Director.' . 
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
                'status' => LeaveRequest::STATUS_REJECTED_HR,
                'hr_id' => auth()->id(),
                'hr_approved_at' => now(),
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
            ->when($this->activeTab === 'pending', function ($query) {
                $query->where('status', LeaveRequest::STATUS_PENDING_HR);
            })
            ->when($this->activeTab === 'approved', function ($query) {
                $query->whereIn('status', [
                    LeaveRequest::STATUS_PENDING_DIRECTOR,
                    LeaveRequest::STATUS_APPROVED
                ]);
            })
            ->when($this->activeTab === 'rejected', function ($query) {
                $query->where('status', LeaveRequest::STATUS_REJECTED_HR);
            })
            ->with(['user.department', 'manager'])
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
     * Counter Getters
     */
    public function getPendingCountProperty()
    {
        return $this->getRequestsCount(LeaveRequest::STATUS_PENDING_HR);
    }

    public function getApprovedCountProperty()
    {
        return $this->getRequestsCount([
            LeaveRequest::STATUS_PENDING_DIRECTOR,
            LeaveRequest::STATUS_APPROVED
        ]);
    }

    public function getRejectedCountProperty()
    {
        return $this->getRequestsCount(LeaveRequest::STATUS_REJECTED_HR);
    }

    protected function getRequestsCount($status)
    {
        return LeaveRequest::query()
            ->when(is_array($status), function ($query) use ($status) {
                $query->whereIn('status', $status);
            }, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->count();
    }

    /**
     * Get all department leave balances for HR overview
     */
    public function getAllDepartmentsLeaveBalancesProperty()
    {
        return User::with(['department', 'leaveRequests' => function ($query) {
                $query->whereYear('created_at', now()->year);
            }])
            ->whereIn('role', ['staff', 'manager']) // Exclude admin/director
            ->get()
            ->each(function ($user) {
                $user->currentLeaveBalance = $user->leaveBalances()
                    ->where('year', now()->year)
                    ->first();
            })
            ->groupBy('department.name');
    }

    /**
     * Render Component
     */
    public function render()
    {
        $this->dispatch('refresh-preline');

        return view('livewire.hr.leave', [
            'leaveRequests' => $this->leaveRequests,
            'departmentsBalances' => $this->allDepartmentsLeaveBalances,
        ])->layout('layouts.hr', ['title' => 'HR Leave Management']);
    }
}
