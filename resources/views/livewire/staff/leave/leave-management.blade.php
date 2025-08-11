<div class="max-w-7xl mx-auto p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Manajemen Cuti</h1>
        <p class="text-gray-600">Kelola pengajuan cuti, lihat riwayat, dan cek saldo cuti Anda</p>
    </div>

    <!-- Main Tab Navigation -->
    <x-tab wire:model.live="activeTab" selected="{{ $activeTab }}">
        <!-- Tab: Daftar Cuti -->
        <x-tab.items tab="list">
            <x-slot:left>
                <x-icon name="document-text" class="w-5 h-5" />
            </x-slot:left>
            Daftar Cuti
        </x-tab.items>

        <!-- Tab: Ajukan Cuti -->
        <x-tab.items tab="create">
            <x-slot:left>
                <x-icon name="plus-circle" class="w-5 h-5" />
            </x-slot:left>
            Ajukan Cuti
        </x-tab.items>

        <!-- Tab: Saldo Cuti -->
        <x-tab.items tab="balance">
            <x-slot:left>
                <x-icon name="calendar-days" class="w-5 h-5" />
            </x-slot:left>
            Saldo Cuti
        </x-tab.items>
    </x-tab>

    <!-- Tab Content -->
    <div class="mt-6">
        <!-- List Leave Requests Tab -->
        @if($activeTab === 'list')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Pengajuan Cuti</h3>
                    <x-button wire:click="openCreateModal" color="green" icon="plus">
                        Ajukan Cuti Baru
                    </x-button>
                </div>
                
                <!-- List Component Placeholder -->
                {{-- @livewire('staff.leave.list-leave-requests') --}}
                <div class="text-center text-gray-500 py-8">
                    <x-icon name="document-text" class="w-12 h-12 mx-auto mb-3 text-gray-400" />
                    <p class="text-lg font-medium">Komponen List Leave Requests</p>
                    <p class="text-sm">Akan menampilkan tabel daftar pengajuan cuti</p>
                </div>
            </div>
        @endif

        <!-- Create Leave Request Tab -->
        @if($activeTab === 'create')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Ajukan Cuti Baru</h3>
                    <p class="text-gray-600 text-sm">Isi form di bawah untuk mengajukan cuti</p>
                </div>
                
                <!-- Create Component Placeholder -->
                {{-- @livewire('staff.leave.create-leave-request') --}}
                <div class="text-center text-gray-500 py-8">
                    <x-icon name="plus-circle" class="w-12 h-12 mx-auto mb-3 text-gray-400" />
                    <p class="text-lg font-medium">Komponen Create Leave Request</p>
                    <p class="text-sm">Akan menampilkan form pengajuan cuti</p>
                </div>
            </div>
        @endif

        <!-- Leave Balance Tab -->
        @if($activeTab === 'balance')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Saldo Cuti {{ date('Y') }}</h3>
                    <p class="text-gray-600 text-sm">Informasi saldo cuti tahunan Anda</p>
                </div>
                
                <!-- Balance Component Placeholder -->
                {{-- @livewire('staff.leave.show-leave-balance') --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Balance Card -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icon name="calendar" class="w-8 h-8 text-blue-600" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-blue-900">Total Cuti</p>
                                <p class="text-2xl font-bold text-blue-600">12 hari</p>
                            </div>
                        </div>
                    </div>

                    <!-- Used Balance Card -->
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icon name="check-circle" class="w-8 h-8 text-orange-600" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-orange-900">Telah Digunakan</p>
                                <p class="text-2xl font-bold text-orange-600">3 hari</p>
                            </div>
                        </div>
                    </div>

                    <!-- Remaining Balance Card -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icon name="clock" class="w-8 h-8 text-green-600" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-green-900">Sisa</p>
                                <p class="text-2xl font-bold text-green-600">9 hari</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-6">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Penggunaan Cuti</span>
                        <span>25% dari total</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal: Create Leave Request -->
    <x-modal wire:model="showCreateModal" title="Ajukan Cuti Baru" size="2xl" persistent>
        {{-- @livewire('staff.leave.create-leave-request', key('create-leave-'.now())) --}}
        <div class="text-center text-gray-500 py-8">
            <x-icon name="document-plus" class="w-12 h-12 mx-auto mb-3 text-gray-400" />
            <p class="text-lg font-medium">Form Pengajuan Cuti</p>
            <p class="text-sm">Komponen CreateLeaveRequest akan dimuat di sini</p>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <x-button wire:click="closeCreateModal" color="gray" outline>
                    Batal
                </x-button>
                <x-button color="green" disabled>
                    Ajukan Cuti
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    <!-- Modal: Detail Leave Request -->
    <x-modal wire:model="showDetailModal" title="Detail Pengajuan Cuti" size="2xl">
        @if($selectedLeaveId)
            {{-- @livewire('staff.leave.show-leave-request', ['leaveId' => $selectedLeaveId], key('detail-leave-'.$selectedLeaveId)) --}}
            <div class="text-center text-gray-500 py-8">
                <x-icon name="eye" class="w-12 h-12 mx-auto mb-3 text-gray-400" />
                <p class="text-lg font-medium">Detail Cuti #{{ $selectedLeaveId }}</p>
                <p class="text-sm">Komponen ShowLeaveRequest akan dimuat di sini</p>
            </div>
        @endif

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <x-button wire:click="closeDetailModal" color="gray">
                    Tutup
                </x-button>
                @if($selectedLeaveId)
                    <x-button wire:click="openEditModal({{ $selectedLeaveId }})" color="blue" outline>
                        Edit
                    </x-button>
                @endif
            </div>
        </x-slot:footer>
    </x-modal>

    <!-- Modal: Edit Leave Request -->
    <x-modal wire:model="showEditModal" title="Edit Pengajuan Cuti" size="2xl" persistent>
        @if($selectedLeaveId)
            {{-- @livewire('staff.leave.edit-leave-request', ['leaveId' => $selectedLeaveId], key('edit-leave-'.$selectedLeaveId)) --}}
            <div class="text-center text-gray-500 py-8">
                <x-icon name="pencil" class="w-12 h-12 mx-auto mb-3 text-gray-400" />
                <p class="text-lg font-medium">Edit Cuti #{{ $selectedLeaveId }}</p>
                <p class="text-sm">Komponen EditLeaveRequest akan dimuat di sini</p>
            </div>
        @endif

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <x-button wire:click="closeEditModal" color="gray" outline>
                    Batal
                </x-button>
                <x-button color="blue" disabled>
                    Update Cuti
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
</div>