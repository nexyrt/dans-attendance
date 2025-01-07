<div>
    <!-- Main Content -->
    <div class="bg-[#2563eb] rounded-3xl p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-lg font-medium text-white flex items-center gap-2">
                <div class="w-1 h-5 bg-white/30 rounded"></div>
                Employee Details
            </h1>
            <div class="flex items-center gap-4">
                <select
                    class="bg-white/10 text-white border border-white/20 rounded-lg px-4 py-2 text-sm focus:bg-white/20 transition-colors">
                    <option>This Year</option>
                    <option>Last Year</option>
                </select>
                <button
                    class="bg-white/10 hover:bg-white/20 text-white rounded-lg px-4 py-2 text-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Info
                </button>
            </div>
        </div>

        <!-- Employee Info Card -->
        <div class="backdrop-blur-sm rounded-lg p-6 mb-8">
            <div class="flex items-center gap-6">
                <div class="relative">
                    @if($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}"
                        class="w-20 h-20 rounded-full object-cover ring-2 ring-white/20" alt="{{ $user->name }}">
                    @else
                    <div
                        class="w-20 h-20 rounded-full bg-white/10 ring-2 ring-white/20 flex items-center justify-center">
                        <span class="text-2xl font-semibold text-white">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-white mb-2">{{ $user->name }}</h2>
                    <div class="grid grid-cols-3 gap-8 text-sm">
                        <div>
                            <div class="text-white/60 mb-1">Role</div>
                            <div class="text-white">{{ $user->position }}</div>
                        </div>
                        <div>
                            <div class="text-white/60 mb-1">Phone Number</div>
                            <div class="text-white">{{ $user->phone_number }}</div>
                        </div>
                        <div>
                            <div class="text-white/60 mb-1">Email Address</div>
                            <div class="text-white">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-4">
            <!-- Attendance Rate Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 hover:bg-white/20 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-white/10 rounded">
                        <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="text-sm text-white/60">Attendance Rate</div>
                </div>
                <div class="text-2xl font-semibold text-white">{{ $attendanceRate }}%</div>
            </div>

            <!-- Check In Average -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 hover:bg-white/20 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-white/10 rounded">
                        <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm text-white/60">Tasks Completed</div>
                </div>
                <div class="text-2xl font-semibold text-white">{{ $tasksCompleted }}</div>
            </div>

            <!-- Check Out Average -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 hover:bg-white/20 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-white/10 rounded">
                        <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm text-white/60">Leave Balance</div>
                </div>
                <div class="text-2xl font-semibold text-white">{{ $leaveBalance }}</div>
            </div>

            <!-- Role Model Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 hover:bg-white/20 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-white/10 rounded">
                        <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="text-sm text-white/60">Role Model</div>
                </div>
                <div class="text-sm text-white">Employee Predicate</div>
            </div>
        </div>
    </div>

    <!-- Attendance History Section -->
    <div class="mt-3 bg-[#2563eb] rounded-3xl p-6">
        <div class="flex space-x-1 mb-6">
            <button wire:click="$set('activeTab', 'attendance')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $activeTab === 'attendance' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Attendance History
            </button>
            <button wire:click="$set('activeTab', 'leave')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $activeTab === 'leave' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Leave Requests
            </button>
            <button wire:click="$set('activeTab', 'tasks')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $activeTab === 'tasks' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Tasks
            </button>
            <button wire:click="$set('activeTab', 'documents')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $activeTab === 'documents' ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Documents
            </button>
        </div>

        <div>
            <div x-show="$wire.activeTab === 'attendance'">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-medium text-white flex items-center gap-2">
                        <div class="w-1 h-5 bg-white/30 rounded"></div>
                        Attendance History
                    </h2>
                    <div class="flex items-center gap-3">
                        <select wire:model.live="attendancePeriod"
                            class="bg-white/10 text-white border border-white/20 rounded-lg px-4 py-2 text-sm focus:bg-white/20 transition-colors">
                            <option value="7">Last 7 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                        <button
                            class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>

                <!-- Attendance Grid -->
                <div class="grid grid-cols-3 gap-4">
                    @forelse($attendances as $attendance)
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 hover:bg-white/20 transition-colors">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-3 items-center">
                                <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-white">{{ $attendance->date->format('F d, Y') }}</span>
                            </div>
                            <div class="px-2 py-1 rounded-full text-xs font-medium 
                        {{ $attendance->status === 'present' ? 'bg-emerald-400/10 text-emerald-400' : 
                           ($attendance->status === 'late' ? 'bg-yellow-400/10 text-yellow-400' : 
                           ($attendance->status === 'early_leave' ? 'bg-orange-400/10 text-orange-400' : 
                           'bg-red-400/10 text-red-400')) }}">
                                {{ ucfirst($attendance->status) }}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-white/60 mb-1">Check In Time</div>
                                <div class="text-sm text-white">{{ $attendance->check_in ?
                                    $attendance->check_in->format('H:i')
                                    : '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-white/60 mb-1">Check Out Time</div>
                                <div class="text-sm text-white">{{ $attendance->check_out ?
                                    $attendance->check_out->format('H:i') : '-' }}</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 text-white/40 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-white/60">No attendance records found for this period</p>
                    </div>
                    @endforelse
                </div>

                <div class="flex justify-center mt-6 gap-1">
                    @php
                    $totalPages = ceil($attendances->count() / 10);
                    @endphp

                    @for($i = 1; $i <= $totalPages; $i++) <button wire:click="gotoPage({{ $i }})"
                        class="w-8 h-8 rounded {{ $i === $currentPage ? 'bg-white/20 text-white' : 'bg-white/10 text-white/60 hover:bg-white/20' }} flex items-center justify-center text-sm transition-colors">
                        {{ $i }}
                        </button>
                        @endfor
                </div>
            </div>

            <!-- Leave Requests Tab -->
            <div x-show="$wire.activeTab === 'leave'">
                <div class="space-y-4">
                    @forelse($leaveRequests as $leave)
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 hover:bg-white/20 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                                            {{ $leave->type === 'sick' ? 'bg-red-400/10 text-red-400' : 
                                               ($leave->type === 'annual' ? 'bg-blue-400/10 text-blue-400' : 
                                               'bg-purple-400/10 text-purple-400') }}">
                                        {{ ucfirst($leave->type) }}
                                    </span>
                                    <span class="text-white/60 text-sm">
                                        {{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d,
                                        Y') }}
                                    </span>
                                </div>
                                <p class="text-white/80 text-sm">{{ $leave->reason }}</p>
                            </div>
                            <div class="px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $leave->status === 'approved' ? 'bg-emerald-400/10 text-emerald-400' : 
                                       ($leave->status === 'pending' ? 'bg-yellow-400/10 text-yellow-400' : 
                                       'bg-red-400/10 text-red-400') }}">
                                {{ ucfirst($leave->status) }}
                            </div>
                        </div>
                        @if($leave->status !== 'pending' && $leave->approved_by)
                        <div class="mt-2 text-xs text-white/40">
                            Approved by {{ $leave->user->name }} on {{ $leave->approved_at->format('M d, Y H:i') }}
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 text-white/40 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-white/60">No leave requests found</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <!-- Documents Tab -->
            <div x-show="$wire.activeTab === 'documents'">
                <div class="space-y-4">
                    <!-- Documents content -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 text-white/40 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-white/60">No documents available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>