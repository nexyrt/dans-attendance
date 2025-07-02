<?php

namespace App\Livewire\Director;

use Livewire\Component;
use App\Models\User;

class QrAttendance extends Component
{
    public $selectedUser;
    public $users;
    public $qrData;

    public function mount()
    {
        $this->users = User::with('department')->get();
    }

    public function generateQRData()
    {
        if (!$this->selectedUser) {
            session()->flash('error', 'Please select a user first.');
            return;
        }

        $user = User::find($this->selectedUser);
        
        // Generate QR code with direct API URL and user ID parameter
        $apiUrl = url('/api/attendance/universal?user_id=' . $user->id);
        
        // The QR code will contain just the URL with parameter
        $this->qrData = $apiUrl;
        
        session()->flash('success', "Universal QR Code generated for {$user->name}");
        
        // Emit event to generate and auto-download QR code
        $this->dispatch('generateQRCode', $this->qrData, $user->name);
    }

    public function clearQR()
    {
        $this->qrData = null;
        $this->dispatch('clearQRCode');
        session()->flash('success', 'QR Code cleared');
    }

    public function render()
    {
        return view('livewire.director.qr-attendance')->layout('layouts.director', ['title' => 'QR Attendance']);
    }
}