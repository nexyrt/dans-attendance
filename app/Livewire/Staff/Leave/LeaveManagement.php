<?php

namespace App\Livewire\Staff\Leave;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use TallStackUi\Traits\Interactions;

class LeaveManagement extends Component
{
    use WithFileUploads, Interactions;

    // Form properties
    public $type = '';
    public $dateRange = [];
    public $reason = '';
    public $attachment;
    public $signature = '';

    // Display properties
    public $leaveRequests = [];
    public $leaveBalance;
    public $showForm = false;

    protected $rules = [
        'type' => 'required|in:sick,annual,important,other',
        'dateRange' => 'required|array|size:2',
        'dateRange.0' => 'required|date|after_or_equal:today',
        'dateRange.1' => 'required|date|after_or_equal:dateRange.0',
        'reason' => 'required|string|min:10',
        'signature' => 'required|string',
        'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
    ];

    public function mount()
    {
        $this->loadLeaveData();
    }

    public function loadLeaveData()
    {
        $user = auth()->user();
        
        // Load current year leave balance
        $this->leaveBalance = $user->currentLeaveBalance() ?? $user->initializeYearlyLeaveBalance();
        
        // Load leave requests
        $this->leaveRequests = LeaveRequest::where('user_id', $user->id)
            ->with(['manager', 'hr', 'director'])
            ->latest()
            ->get();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }

    public function submitLeave()
    {
        $this->validate();

        $user = auth()->user();

        // Check leave balance for annual leave
        if ($this->type === 'annual') {
            $duration = $this->calculateWorkingDays();
            if ($duration > $this->leaveBalance->remaining_balance) {
                $this->toast()
                    ->error('Error', 'Saldo cuti tidak mencukupi. Tersedia: ' . $this->leaveBalance->remaining_balance . ' hari')
                    ->send();
                return;
            }
        }

        try {
            // Save signature
            $signaturePath = $this->saveSignature($user);
            
            // Save attachment if exists
            $attachmentPath = null;
            if ($this->attachment) {
                $attachmentPath = $this->attachment->store('leave-attachments', 'public');
            }

            // Create leave request
            LeaveRequest::create([
                'user_id' => $user->id,
                'type' => $this->type,
                'start_date' => $this->dateRange[0],
                'end_date' => $this->dateRange[1],
                'reason' => $this->reason,
                'attachment_path' => $attachmentPath,
                'status' => LeaveRequest::STATUS_PENDING_MANAGER
            ]);

            $this->toast()
                ->success('Berhasil', 'Pengajuan cuti berhasil dikirim')
                ->send();

            $this->resetForm();
            $this->showForm = false; // Auto close form
            $this->loadLeaveData();

        } catch (\Exception $e) {
            $this->toast()
                ->error('Error', 'Gagal mengirim pengajuan cuti')
                ->send();
        }
    }

    private function saveSignature($user)
    {
        // Generate consistent filename: {user_id}_{name}_{role}.png
        $filename = $user->id . '_' . str_replace(' ', '_', strtolower($user->name)) . '_' . $user->role . '.png';
        
        // Decode base64 signature
        $signatureData = explode(',', $this->signature)[1];
        $decodedSignature = base64_decode($signatureData);
        
        // Save to storage (will overwrite existing)
        $path = 'signatures/' . $filename;
        Storage::disk('public')->put($path, $decodedSignature);
        
        return $filename;
    }

    private function calculateWorkingDays()
    {
        if (!is_array($this->dateRange) || count($this->dateRange) !== 2 || !$this->dateRange[0] || !$this->dateRange[1]) {
            return 0;
        }
        
        $start = \Carbon\Carbon::parse($this->dateRange[0]);
        $end = \Carbon\Carbon::parse($this->dateRange[1]);
        
        $workingDays = 0;
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                $workingDays++;
            }
        }
        
        return $workingDays;
    }

    public function cancelLeave($leaveId)
    {
        $leave = LeaveRequest::where('id', $leaveId)
            ->where('user_id', auth()->id())
            ->first();

        if ($leave && $leave->canBeCancelled()) {
            $leave->cancel();
            
            $this->toast()
                ->success('Berhasil', 'Pengajuan cuti berhasil dibatalkan')
                ->send();
                
            $this->loadLeaveData();
        }
    }

    private function resetForm()
    {
        $this->type = '';
        $this->dateRange = [];
        $this->reason = '';
        $this->signature = '';
        $this->attachment = null;
    }

    public function render()
    {
        return view('livewire.staff.leave.leave-management')->layout('layouts.staff', ['title' => 'Leave Management']);
    }
}