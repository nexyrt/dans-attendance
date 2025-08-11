<div class="max-w-7xl mx-auto p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header dengan Leave Balance -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                @if($leaveBalance)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-blue-600 text-sm font-medium">Total Cuti</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $leaveBalance->total_balance }}</div>
                                <div class="text-gray-500 text-sm">hari</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white border border-red-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-red-100 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-red-600 text-sm font-medium">Telah Digunakan</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $leaveBalance->used_balance }}</div>
                                <div class="text-gray-500 text-sm">hari</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white border border-green-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-green-600 text-sm font-medium">Sisa Cuti</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $leaveBalance->remaining_balance }}</div>
                                <div class="text-gray-500 text-sm">hari</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Toggle Form Button -->
                <x-button 
                    wire:click="toggleForm" 
                    color="{{ $showForm ? 'red' : 'blue' }}"
                    icon="{{ $showForm ? 'x-mark' : 'plus' }}"
                    :text="$showForm ? 'Batal Pengajuan' : 'Ajukan Cuti Baru'"
                    size="lg"
                />
            </div>
        </div>

        <!-- Form Pengajuan Cuti -->
        @if($showForm)
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8 transform animate-in slide-in-from-top duration-500">
            <div class="flex items-center mb-8">
                <div class="p-3 bg-blue-100 rounded-xl mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Formulir Pengajuan Cuti</h2>
                    <p class="text-gray-600">Lengkapi semua informasi yang diperlukan</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Jenis Cuti -->
                <div class="space-y-2">
                    <x-select.styled 
                        label="Jenis Cuti *" 
                        wire:model.live="type"
                        :options="[
                            ['label' => '🤒 Cuti Sakit', 'value' => 'sick'],
                            ['label' => '🏖️ Cuti Tahunan', 'value' => 'annual'],
                            ['label' => '⚡ Cuti Penting', 'value' => 'important'],
                            ['label' => '📝 Lainnya', 'value' => 'other']
                        ]"
                        placeholder="Pilih jenis cuti"
                        required
                    />
                </div>

                <!-- Periode Cuti -->
                <div class="space-y-2">
                    <x-date 
                        label="Periode Cuti *" 
                        wire:model.live="dateRange"
                        :min-date="now()->format('Y-m-d')"
                        format="DD MMMM YYYY"
                        range
                        helpers
                        hint="Pilih tanggal mulai dan selesai cuti"
                    />
                </div>

                <!-- Durasi Display -->
                @if(is_array($dateRange) && count($dateRange) === 2 && $dateRange[0] && $dateRange[1])
                <div class="lg:col-span-2">
                    <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-600 font-medium">Durasi Cuti</div>
                                    <div class="text-xl font-bold text-blue-900">{{ $this->calculateWorkingDays() }} hari kerja</div>
                                </div>
                            </div>
                            @if($type === 'annual')
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Sisa setelah cuti</div>
                                <div class="text-lg font-semibold {{ ($leaveBalance->remaining_balance - $this->calculateWorkingDays()) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $leaveBalance->remaining_balance - $this->calculateWorkingDays() }} hari
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Alasan -->
            <div class="mt-8">
                <x-input 
                    label="Alasan Cuti *" 
                    wire:model="reason"
                    hint="Jelaskan alasan detail mengapa Anda mengajukan cuti"
                    placeholder="Masukkan alasan pengajuan cuti..."
                />
            </div>

            <!-- Lampiran -->
            <div class="mt-8">
                <x-upload 
                    label="Dokumen Pendukung" 
                    wire:model="attachment"
                    hint="Upload dokumen pendukung (PDF, JPG, PNG - maksimal 2MB)"
                    tip="Seret dan lepas file atau klik untuk memilih"
                    accept=".pdf,.jpg,.jpeg,.png"
                    delete
                >
                    <x-slot:footer when-uploaded>
                        <div class="bg-green-50 p-3 rounded-lg">
                            <div class="text-green-800 text-sm font-medium">✓ File berhasil diunggah</div>
                        </div>
                    </x-slot:footer>
                </x-upload>
            </div>

            <!-- Tanda Tangan -->
            <div class="mt-8">
                <x-signature 
                    label="Tanda Tangan Digital *"
                    wire:model="signature"
                    hint="Berikan tanda tangan Anda di kotak di bawah ini"
                    clearable
                    height="250"
                    color="#1e40af"
                    background="#f8fafc"
                />
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <x-button 
                    wire:click="submitLeave"
                    color="blue"
                    icon="paper-airplane"
                    text="Kirim Pengajuan Cuti"
                    loading="submitLeave"
                    size="lg"
                    class="transform hover:scale-105 transition-all duration-300"
                />
            </div>
        </div>
        @endif

        <!-- Riwayat Pengajuan Cuti -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-gray-100 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm2 2a1 1 0 000 2h.01a1 1 0 100-2H5zm3 0a1 1 0 000 2h3a1 1 0 100-2H8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Riwayat Pengajuan Cuti</h2>
                        <p class="text-gray-600">Pantau status semua pengajuan cuti Anda</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Jenis & Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($leaveRequests as $request)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r {{ 
                                        $request->type === 'sick' ? 'from-red-400 to-red-500' : 
                                        ($request->type === 'annual' ? 'from-blue-400 to-blue-500' : 
                                        ($request->type === 'important' ? 'from-yellow-400 to-yellow-500' : 'from-gray-400 to-gray-500'))
                                    }} rounded-xl flex items-center justify-center text-white font-bold">
                                        {{ 
                                            $request->type === 'sick' ? '🤒' : 
                                            ($request->type === 'annual' ? '🏖️' : 
                                            ($request->type === 'important' ? '⚡' : '📝'))
                                        }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-900">
                                            {{ 
                                                $request->type === 'sick' ? 'Cuti Sakit' : 
                                                ($request->type === 'annual' ? 'Cuti Tahunan' : 
                                                ($request->type === 'important' ? 'Cuti Penting' : 'Lainnya'))
                                            }}
                                        </div>
                                        <div class="text-sm text-slate-500">
                                            Diajukan {{ $request->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">
                                    {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900">{{ $request->getDurationInDays() }} hari</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ 
                                    str_contains($request->status, 'pending') ? 'bg-yellow-100 text-yellow-800' :
                                    ($request->status === 'approved' ? 'bg-green-100 text-green-800' :
                                    (str_contains($request->status, 'rejected') ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))
                                }}">
                                    {{ 
                                        $request->status === 'pending_manager' ? '⏳ Menunggu Manager' :
                                        ($request->status === 'pending_hr' ? '⏳ Menunggu HR' :
                                        ($request->status === 'pending_director' ? '⏳ Menunggu Direktur' :
                                        ($request->status === 'approved' ? '✅ Disetujui' :
                                        (str_contains($request->status, 'rejected') ? '❌ Ditolak' : '🚫 Dibatalkan'))))
                                    }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <!-- View Button -->
                                    <x-button.circle 
                                        icon="eye" 
                                        color="blue" 
                                        size="sm"
                                        light
                                    />
                                    
                                    <!-- Delete Button -->
                                    @if($request->canBeCancelled())
                                    <x-button.circle 
                                        wire:click="cancelLeave({{ $request->id }})"
                                        icon="trash" 
                                        color="red" 
                                        size="sm"
                                        light
                                    />
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-slate-100 p-6 rounded-2xl mb-4">
                                        <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-slate-700 mb-2">Belum Ada Pengajuan Cuti</h3>
                                    <p class="text-slate-500 mb-6 max-w-md text-center">
                                        Anda belum pernah mengajukan cuti. Klik tombol "Ajukan Cuti Baru" untuk memulai pengajuan pertama Anda.
                                    </p>
                                    <x-button 
                                        wire:click="toggleForm" 
                                        color="blue"
                                        icon="plus"
                                        text="Ajukan Cuti Pertama"
                                        outline
                                    />
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>