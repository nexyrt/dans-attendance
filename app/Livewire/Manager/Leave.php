<?php

namespace App\Livewire\Manager;

use App\Models\User;
use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\TemplateProcessor;

class Leave extends Component
{
    use WithFileUploads;

    // View states
    public $activeTab = 'pending';
    public $selectedDepartment = null;
    public $selectedRequest = null;

    // Modals & Previews
    public $showRejectModal = false;
    public $showPreview = false;
    public $previewUrl = null;
    public $previewType = null;

    // Form data
    public $rejectReason = '';
    public $signature = '';

    /**
     * Initialize component
     */
    public function mount()
    {
        $this->selectedDepartment = auth()->user()->department_id;
    }

    /**
     * Get filtered leave requests
     */
    public function getLeaveRequestsProperty()
    {
        $statusMap = [
            'pending' => [LeaveRequest::STATUS_PENDING_MANAGER],
            'approved' => [
                LeaveRequest::STATUS_PENDING_HR,
                LeaveRequest::STATUS_PENDING_DIRECTOR,
                LeaveRequest::STATUS_APPROVED
            ],
            'rejected' => [LeaveRequest::STATUS_REJECTED_MANAGER]
        ];

        return LeaveRequest::query()
            ->where('user_id', '!=', auth()->id())
            ->whereHas('user', function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            })
            ->when(isset($statusMap[$this->activeTab]), function ($query) use ($statusMap) {
                $query->whereIn('status', $statusMap[$this->activeTab]);
            })
            ->with([
                'user.department',
                'user.leaveBalances' => function ($query) {
                    $query->where('year', now()->year);
                }
            ])
            ->latest()
            ->get();
    }

    /**
     * Get team leave balances
     */
    public function getTeamLeaveBalancesProperty()
    {
        return User::where('department_id', $this->selectedDepartment)
            ->where('id', '!=', auth()->id())
            ->with([
                'leaveBalances' => function ($query) {
                    $query->where('year', now()->year);
                }
            ])
            ->get();
    }

    /**
     * Get counts for tabs
     */
    public function getCountsProperty()
    {
        $counts = DB::table('leave_requests')
            ->join('users', 'leave_requests.user_id', '=', 'users.id')
            ->where('users.department_id', $this->selectedDepartment)
            ->where('leave_requests.user_id', '!=', auth()->id())
            ->selectRaw('
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status IN (?, ?, ?) THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as rejected
            ', [
                LeaveRequest::STATUS_PENDING_MANAGER,
                LeaveRequest::STATUS_PENDING_HR,
                LeaveRequest::STATUS_PENDING_DIRECTOR,
                LeaveRequest::STATUS_APPROVED,
                LeaveRequest::STATUS_REJECTED_MANAGER
            ])
            ->first();

        return [
            'pending' => $counts->pending ?? 0,
            'approved' => $counts->approved ?? 0,
            'rejected' => $counts->rejected ?? 0
        ];
    }

    /**
     * Preview attachment
     */
    public function previewAttachment($requestId)
    {
        $request = LeaveRequest::findOrFail($requestId);
        $previewPath = null;

        if ($request->document_path && File::exists(public_path($request->document_path))) {
            $previewPath = $request->document_path;
        } elseif ($request->attachment_path && File::exists(public_path($request->attachment_path))) {
            $previewPath = $request->attachment_path;
        }

        if ($previewPath) {
            $this->previewUrl = asset($previewPath);
            $this->previewType = strtolower(pathinfo($previewPath, PATHINFO_EXTENSION));
            $this->showPreview = true;
        }
    }

    /**
     * Close preview modal
     */
    public function closePreview()
    {
        $this->showPreview = false;
        $this->previewUrl = null;
        $this->previewType = null;
    }

    /**
     * Open signature modal
     */
    public function openSignatureModal($requestId)
    {
        $this->selectedRequest = LeaveRequest::find($requestId);
        $this->signature = '';
        $this->dispatch('open-modal', 'signature-modal');
    }

    /**
     * Save signature and approve leave request
     */
    public function approveWithSignature()
    {
        // Validate signature
        $this->validate(['signature' => 'required']);

        if (!$this->selectedRequest) {
            return;
        }

        try {
            $user = auth()->user();
            $signaturePath = $this->saveSignature($user);

            // Update leave request based on role
            DB::transaction(function () use ($user, $signaturePath) {
                $this->selectedRequest->update([
                    'status' => LeaveRequest::STATUS_PENDING_HR,
                    'manager_id' => $user->id,
                    'manager_approved_at' => now(),
                    'manager_signature' => $signaturePath
                ]);
            });

            // Add signature to document if it exists
            $documentSigned = $this->addSignatureToDocument($signaturePath);

            // Show success message
            session()->flash('message', 'Leave request approved and sent to HR.' .
                ($documentSigned ? ' Document has been signed.' : ''));

            // Close modal and reset
            $this->dispatch('close-modal', 'signature-modal');
            $this->reset(['selectedRequest', 'signature']);

        } catch (\Exception $e) {
            Log::error('Error approving leave request: ' . $e->getMessage());
            session()->flash('message', 'An error occurred while approving the request: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }

    /**
     * Save signature to file system
     */
    protected function saveSignature($user)
    {
        try {
            // Create signatures directory if needed
            $directory = public_path('signatures');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Generate filename
            $filename = sprintf(
                '%s_%s_%s.png',
                strtolower($user->role),
                Str::slug($user->name),
                $user->id
            );

            // Save signature image
            $signaturePath = 'signatures/' . $filename;
            $imageData = base64_decode(Str::of($this->signature)->after(','));
            File::put(public_path($signaturePath), $imageData);

            // Log success
            Log::info('Signature saved to: ' . public_path($signaturePath));

            return $signaturePath;
        } catch (\Exception $e) {
            Log::error('Error saving signature: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Add signature to document - CORRECT VERSION
     */
    protected function addSignatureToDocument($signaturePath)
    {
        try {
            // Make sure document exists
            if (
                !$this->selectedRequest->document_path ||
                !File::exists(public_path($this->selectedRequest->document_path))
            ) {
                Log::error('Document not found: ' .
                    ($this->selectedRequest->document_path ?? 'null'));
                return false;
            }

            // Make sure signature file exists
            if (!File::exists(public_path($signaturePath))) {
                Log::error('Signature file not found: ' . public_path($signaturePath));
                return false;
            }

            // Log what we're trying to do
            Log::info('Processing document: ' . public_path($this->selectedRequest->document_path));
            Log::info('With signature: ' . public_path($signaturePath));

            // Create template processor
            $templateProcessor = new TemplateProcessor(
                public_path($this->selectedRequest->document_path)
            );

            // IMPORTANT: Use the placeholder name WITHOUT the ${} wrapper
            // This correctly targets ${manager_signature} in the document
            $templateProcessor->setImageValue('manager_signature', public_path($signaturePath));
            $templateProcessor->setValue('manager_name', auth()->user()->name);

            // Save the document
            $templateProcessor->saveAs(public_path($this->selectedRequest->document_path));

            Log::info('Document signed successfully');
            return true;

        } catch (\Exception $e) {
            Log::error('Error adding signature to document: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return false;
        }
    }

    /**
     * Open reject modal
     */
    public function showRejectModal($requestId)
    {
        $this->selectedRequest = LeaveRequest::findOrFail($requestId);
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    /**
     * Close reject modal
     */
    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->selectedRequest = null;
        $this->rejectReason = '';
        $this->resetValidation();
    }

    /**
     * Reject leave request
     */
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

        $this->closeRejectModal();
        session()->flash('message', 'Leave request rejected successfully.');
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.manager.leave', [
            'leaveRequests' => $this->leaveRequests,
            'teamBalances' => $this->teamLeaveBalances,
            'counts' => $this->counts,
        ])->layout('layouts.manager', ['title' => 'Leave Management']);
    }
}