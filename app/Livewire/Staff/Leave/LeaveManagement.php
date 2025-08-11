<?php

namespace App\Livewire\Staff\Leave;

use Livewire\Component;
use TallStackUi\Traits\Interactions;

class LeaveManagement extends Component
{
    use Interactions;

    public $activeTab = 'list';
    
    // Properties for modals
    public $showCreateModal = false;
    public $showDetailModal = false;
    public $showEditModal = false;
    
    // Selected leave request for detail/edit
    public $selectedLeaveId = null;

    public function mount()
    {
        // Initialize component
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        
        // Close any open modals when switching tabs
        $this->closeAllModals();
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        // Refresh the list when modal is closed
        $this->dispatch('refresh-leave-list');
    }

    public function openDetailModal($leaveId)
    {
        $this->selectedLeaveId = $leaveId;
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedLeaveId = null;
    }

    public function openEditModal($leaveId)
    {
        $this->selectedLeaveId = $leaveId;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->selectedLeaveId = null;
        // Refresh the list when modal is closed
        $this->dispatch('refresh-leave-list');
    }

    private function closeAllModals()
    {
        $this->showCreateModal = false;
        $this->showDetailModal = false;
        $this->showEditModal = false;
        $this->selectedLeaveId = null;
    }

    // Event listeners
    protected $listeners = [
        'leave-created' => 'handleLeaveCreated',
        'leave-updated' => 'handleLeaveUpdated',
        'leave-cancelled' => 'handleLeaveCancelled',
        'open-detail-modal' => 'openDetailModal',
        'open-edit-modal' => 'openEditModal'
    ];

    public function handleLeaveCreated()
    {
        $this->closeCreateModal();
        $this->toast()
            ->success('Berhasil!', 'Pengajuan cuti berhasil dibuat dan akan diproses.')
            ->send();
    }

    public function handleLeaveUpdated()
    {
        $this->closeEditModal();
        $this->toast()
            ->success('Berhasil!', 'Pengajuan cuti berhasil diperbarui.')
            ->send();
    }

    public function handleLeaveCancelled()
    {
        $this->toast()
            ->success('Berhasil!', 'Pengajuan cuti berhasil dibatalkan.')
            ->send();
    }

    public function render()
    {
        return view('livewire.staff.leave.leave-management');
    }
}