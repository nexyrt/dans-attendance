<!-- resources/views/livewire/director/users.blade.php -->
<div class="min-h-screen bg-gray-50">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users Card -->
            <div
                class="group relative bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-transparent to-transparent opacity-50">
                </div>
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-blue-100 rounded-full -translate-y-10 translate-x-10 opacity-30">
                </div>

                <div class="relative flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="h-14 w-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 flex-1">
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\User::count() }}</p>
                        <div class="flex items-center text-sm">
                            <div class="flex items-center text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-4 relative">
                    <div class="flex justify-between items-center text-xs text-gray-500 mb-2">
                        <span>Kapasitas</span>
                        <span>{{ \App\Models\User::count() }}/500</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500"
                            style="width: {{ min((\App\Models\User::count() / 500) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Departments Card -->
            <div
                class="group relative bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <!-- Background Pattern -->
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-50 via-transparent to-transparent opacity-50">
                </div>
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-purple-100 rounded-full -translate-y-10 translate-x-10 opacity-30">
                </div>

                <div class="relative flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="h-14 w-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 flex-1">
                        <p class="text-sm font-medium text-gray-600 mb-1">Departemen</p>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\Department::count() }}</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach(\App\Models\Department::take(2)->get() as $dept)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $dept->name }}
                            </span>
                            @endforeach
                            @if(\App\Models\Department::count() > 2)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                +{{ \App\Models\Department::count() - 2 }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Department Distribution -->
                <div class="mt-4 space-y-2">
                    @foreach(\App\Models\Department::withCount('users')->take(3)->get() as $dept)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600">{{ $dept->name }}</span>
                        <span class="font-medium text-purple-600">{{ $dept->users_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Admin Users Card -->
            <div
                class="group relative bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <!-- Background Pattern -->
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-transparent to-transparent opacity-50">
                </div>
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-emerald-100 rounded-full -translate-y-10 translate-x-10 opacity-30">
                </div>

                <div class="relative flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="h-14 w-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 flex-1">
                        <p class="text-sm font-medium text-gray-600 mb-1">Pengguna Admin</p>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\User::whereIn('role', ['admin',
                            'director', 'manager'])->count() }}</p>
                        <p class="text-sm text-gray-500">
                            <span class="font-medium text-emerald-600">{{ \App\Models\User::where('role',
                                'staff')->count() }}</span> anggota staf
                        </p>
                    </div>
                </div>

                <!-- Role Distribution Chart -->
                <div class="mt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">Distribusi Peran</span>
                        <span class="text-xs text-gray-500">{{ number_format(((\App\Models\User::whereIn('role',
                            ['admin', 'director', 'manager'])->count() / \App\Models\User::count()) * 100), 1)
                            }}%</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <div class="h-2 bg-red-200 rounded"></div>
                        <div class="h-2 bg-emerald-400 rounded"></div>
                        <div class="h-2 bg-yellow-200 rounded"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div
                class="group relative bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-transparent to-transparent opacity-50">
                </div>
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-amber-100 rounded-full -translate-y-10 translate-x-10 opacity-30">
                </div>

                <div class="relative flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="h-14 w-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 flex-1">
                        <p class="text-sm font-medium text-gray-600 mb-1">Baru Bulan Ini</p>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\User::whereMonth('created_at',
                            now()->month)->count() }}</p>
                        <div class="flex items-center text-sm">
                            @if(\App\Models\User::whereMonth('created_at', now()->month)->count() > 0)
                            <div class="flex items-center text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium text-xs">Naik</span>
                            </div>
                            @else
                            <div class="flex items-center text-gray-500 bg-gray-50 px-2 py-1 rounded-full">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium text-xs">Stabil</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mini Chart -->
                <div class="mt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">Trend 7 hari</span>
                        <span class="text-xs text-amber-600 font-medium">
                            {{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }} registrasi
                        </span>
                    </div>
                    <div class="flex items-end space-x-1 h-8">
                        @for($i = 6; $i >= 0; $i--)
                        @php
                        $count = \App\Models\User::whereDate('created_at', now()->subDays($i))->count();
                        $height = $count > 0 ? max(($count / max(\App\Models\User::where('created_at', '>=',
                        now()->subDays(7))->selectRaw('DATE(created_at) as date, COUNT(*) as
                        count')->groupBy('date')->pluck('count')->toArray() ?: [1])) * 100, 10) : 10;
                        @endphp
                        <div class="flex-1 bg-amber-200 rounded-sm transition-all duration-300 hover:bg-amber-400"
                            style="height: {{ $height }}%"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Table -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Direktori Karyawan</h3>
                                <p class="text-sm text-gray-600 mt-1">Kelola dan lihat semua karyawan perusahaan</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">Total:</span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ \App\Models\User::count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        {{ $this->table }}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Department Breakdown -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian Departemen</h3>
                    <div class="space-y-3">
                        @foreach(\App\Models\Department::withCount('users')->get() as $dept)
                        <div
                            class="group flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">{{
                                    $dept->name }}</p>
                                <p class="text-xs text-gray-500">{{ $dept->code ?? 'Tidak ada kode' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-blue-600">{{ $dept->users_count }}</span>
                                <p class="text-xs text-gray-500">karyawan</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambahan Terbaru</h3>
                    <div class="space-y-3">
                        @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                        <div
                            class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 cursor-pointer group">
                            @if($user->image)
                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white"
                                src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}">
                            @else
                            <div
                                class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center ring-2 ring-white">
                                <span class="text-white font-medium text-sm">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-sm font-medium text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                    {{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($user->role) }} • {{
                                    $user->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($user->role === 'staff') bg-blue-100 text-blue-800
                                @elseif($user->role === 'manager') bg-purple-100 text-purple-800
                                @elseif($user->role === 'admin') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- System Overview -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl shadow-sm text-white p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Ringkasan Sistem
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Total Karyawan</span>
                            <span class="font-bold text-xl">{{ \App\Models\User::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Departemen Aktif</span>
                            <span class="font-bold text-xl">{{ \App\Models\Department::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Pengguna Admin</span>
                            <span class="font-bold text-xl">{{ \App\Models\User::whereIn('role', ['admin',
                                'director'])->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Bulan Ini</span>
                            <span class="font-bold text-xl text-green-400">+{{
                                \App\Models\User::whereMonth('created_at', now()->month)->count() }}</span>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-700">
                        <p class="text-xs text-slate-400">
                            <svg class="h-3 w-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Diperbarui: {{ now()->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <x-modals.modal name="create-user-modal">
        <div class="p-8">
            <div class="flex items-center mb-6">
                <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Buat Pengguna Baru</h2>
                    <p class="text-sm text-gray-600">Tambahkan karyawan baru ke sistem</p>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="create_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input wire:model.defer="name" type="text" id="create_name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="create_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input wire:model.defer="email" type="email" id="create_email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="alamat@email.com">
                        @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="create_password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                        <input wire:model.defer="password" type="password" id="create_password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="Masukkan kata sandi">
                        @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <label for="create_role_select" class="block text-sm font-medium text-gray-700">Peran</label>
                        <select wire:model.defer="role_select" id="create_role_select"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('role_select') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Peran</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role_select')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="space-y-2">
                        <label for="create_department_id"
                            class="block text-sm font-medium text-gray-700">Departemen</label>
                        <select wire:model.defer="department_id" id="create_department_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('department_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Departemen</option>
                            @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-2">
                        <label for="create_phone_number" class="block text-sm font-medium text-gray-700">Nomor
                            Telepon</label>
                        <input wire:model.defer="phone_number" type="text" id="create_phone_number"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone_number') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="08xxxxxxxxx">
                        @error('phone_number')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birthdate -->
                    <div class="space-y-2">
                        <label for="create_birthdate" class="block text-sm font-medium text-gray-700">Tanggal
                            Lahir</label>
                        <input wire:model.defer="birthdate" type="date" id="create_birthdate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('birthdate') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        @error('birthdate')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div class="space-y-2">
                        <label for="create_salary" class="block text-sm font-medium text-gray-700">Gaji</label>
                        <input wire:model.defer="salary" type="number" step="0.01" id="create_salary"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('salary') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="0">
                        @error('salary')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="space-y-2">
                    <label for="create_address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea wire:model.defer="address" id="create_address" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                        placeholder="Alamat lengkap"></textarea>
                    @error('address')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" x-on:click="$dispatch('close-modal', 'create-user-modal')"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Buat Pengguna
                    </button>
                </div>
            </form>
        </div>
    </x-modals.modal>

    <!-- Edit User Modal -->
    <x-modals.modal name="edit-user-modal">
        <div class="p-8">
            <div class="flex items-center mb-6">
                <div class="h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Edit Pengguna</h2>
                    <p class="text-sm text-gray-600">Perbarui informasi karyawan</p>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="edit_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input wire:model.defer="name" type="text" id="edit_name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input wire:model.defer="email" type="email" id="edit_email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="alamat@email.com">
                        @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="edit_password" class="block text-sm font-medium text-gray-700">
                            Kata Sandi <span class="text-gray-500">(Kosongkan jika tidak diubah)</span>
                        </label>
                        <input wire:model.defer="password" type="password" id="edit_password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="Kata sandi baru">
                        @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <label for="edit_role_select" class="block text-sm font-medium text-gray-700">Peran</label>
                        <select wire:model.defer="role_select" id="edit_role_select"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('role_select') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Peran</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role_select')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="space-y-2">
                        <label for="edit_department_id"
                            class="block text-sm font-medium text-gray-700">Departemen</label>
                        <select wire:model.defer="department_id" id="edit_department_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('department_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                            <option value="">Pilih Departemen</option>
                            @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-2">
                        <label for="edit_phone_number" class="block text-sm font-medium text-gray-700">Nomor
                            Telepon</label>
                        <input wire:model.defer="phone_number" type="text" id="edit_phone_number"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone_number') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="08xxxxxxxxx">
                        @error('phone_number')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birthdate -->
                    <div class="space-y-2">
                        <label for="edit_birthdate" class="block text-sm font-medium text-gray-700">Tanggal
                            Lahir</label>
                        <input wire:model.defer="birthdate" type="date" id="edit_birthdate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('birthdate') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        @error('birthdate')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div class="space-y-2">
                        <label for="edit_salary" class="block text-sm font-medium text-gray-700">Gaji</label>
                        <input wire:model.defer="salary" type="number" step="0.01" id="edit_salary"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('salary') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="0">
                        @error('salary')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="space-y-2">
                    <label for="edit_address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea wire:model.defer="address" id="edit_address" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                        placeholder="Alamat lengkap"></textarea>
                    @error('address')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" x-on:click="$dispatch('close-modal', 'edit-user-modal')"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>
    </x-modals.modal>

    <!-- View User Modal -->
    <x-modals.modal name="view-user-modal">
        <div class="p-8">
            @if ($viewUserId && $userBeingViewed)
            <div class="flex items-center mb-8">
                <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Detail Pengguna</h2>
                    <p class="text-sm text-gray-600">Informasi lengkap karyawan</p>
                </div>
            </div>

            <!-- User Avatar -->
            <div class="flex justify-center mb-8">
                @if ($userBeingViewed->image)
                <img class="h-24 w-24 rounded-full object-cover ring-4 ring-blue-100 shadow-lg"
                    src="{{ asset('storage/' . $userBeingViewed->image) }}" alt="{{ $userBeingViewed->name }}">
                @else
                <div
                    class="h-24 w-24 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center ring-4 ring-blue-100 shadow-lg">
                    <span class="text-white font-bold text-2xl">
                        {{ substr($userBeingViewed->name, 0, 1) }}
                    </span>
                </div>
                @endif
            </div>

            <!-- User Information -->
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $userBeingViewed->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono bg-white px-3 py-2 rounded-lg border">{{
                                $userBeingViewed->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($userBeingViewed->phone_number)
                                <span class="font-mono bg-white px-3 py-2 rounded-lg border">{{
                                    $userBeingViewed->phone_number }}</span>
                                @else
                                <span class="text-gray-400 italic">Tidak tersedia</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $userBeingViewed->birthdate ?
                                \Cake\Chronos\Chronos::parse($userBeingViewed->birthdate)->format('d F Y') : 'Tidak
                                tersedia' }}
                            </dd>
                        </div>
                    </div>

                    <!-- Work Information -->
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Peran</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        @if($userBeingViewed->role === 'staff') bg-blue-100 text-blue-800
                                        @elseif($userBeingViewed->role === 'manager') bg-purple-100 text-purple-800
                                        @elseif($userBeingViewed->role === 'admin') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($userBeingViewed->role) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Departemen</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($userBeingViewed->department)
                                <span class="bg-white px-3 py-2 rounded-lg border">{{ $userBeingViewed->department->name
                                    }}</span>
                                @else
                                <span class="text-gray-400 italic">Tidak ditugaskan</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Bergabung Sejak</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ \Cake\Chronos\Chronos::parse($userBeingViewed->created_at)->format('d F Y') }}
                            </dd>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-gray-900 bg-white px-4 py-3 rounded-lg border">
                            {{ $userBeingViewed->address ?? 'Tidak tersedia' }}
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <button type="button" x-on:click="$dispatch('close-modal', 'view-user-modal')"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    Tutup
                </button>
                <button type="button" wire:click="edit({{ $userBeingViewed->id }})"
                    x-on:click="$dispatch('close-modal', 'view-user-modal'); $nextTick(() => $dispatch('open-modal', 'edit-user-modal'))"
                    class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Edit Pengguna
                </button>
            </div>
            @else
            <div class="py-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pengguna yang dipilih</h3>
                <p class="mt-2 text-sm text-gray-500">Pilih pengguna untuk melihat detail.</p>
            </div>
            @endif
        </div>
    </x-modals.modal>

    <!-- Reset Password Modal -->
    <x-modals.modal name="reset-password-modal">
        <div class="p-8">
            <div class="flex items-center mb-6">
                <div class="h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h.01M9 5a2 2 0 00-2 2v8a2 2 0 002 2h4a2 2 0 002-2V7a2 2 0 00-2-2H9z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Reset Kata Sandi</h2>
                    <p class="text-sm text-gray-600">Buat kata sandi baru untuk pengguna</p>
                </div>
            </div>

            <form wire:submit.prevent="resetPassword" class="space-y-6">
                <div class="space-y-2">
                    <label for="newPassword" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                    <input wire:model.defer="newPassword" type="password" id="newPassword"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('newPassword') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                        placeholder="Masukkan kata sandi baru">
                    @error('newPassword')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" x-on:click="$dispatch('close-modal', 'reset-password-modal')"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Reset Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </x-modals.modal>

    <!-- Delete User Confirmation Modal -->
    <x-modals.modal name="delete-user-modal">
        <div class="p-8">
            <div class="flex items-center mb-6">
                <div class="h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Hapus Pengguna</h2>
                    <p class="text-sm text-gray-600">Konfirmasi penghapusan data pengguna</p>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Peringatan!</h3>
                        <p class="mt-1 text-sm text-red-700">
                            Apakah Anda yakin ingin menghapus pengguna ini? Semua data mereka akan dihapus secara
                            permanen termasuk catatan kehadiran, permintaan cuti, dan riwayat gaji. <strong>Tindakan ini
                                tidak dapat dibatalkan.</strong>
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" x-on:click="$dispatch('close-modal', 'delete-user-modal')"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </button>
                <button type="button" wire:click="deleteUser"
                    class="px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Hapus Pengguna
                </button>
            </div>
        </div>
    </x-modals.modal>
</div>