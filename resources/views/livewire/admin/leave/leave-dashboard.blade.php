<div>
    <div>
        <!-- Flash Messages -->
        <x-shared.flash-message />

        <div class="min-h-screen">
            <div class="py-8">
                {{-- Stats Card --}}
                <div class="px-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Approved Card -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200 animate-gradient">
                            </div>
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl opacity-0 group-hover:opacity-10 transition duration-500">
                            </div>

                            <div
                                class="relative bg-white/80 backdrop-blur-lg dark:bg-gray-800 rounded-2xl p-7 h-full ring-1 ring-gray-100/50 shadow-md">
                                <div
                                    class="absolute -top-3 -right-3 w-24 h-24 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-full blur-2xl opacity-60 group-hover:opacity-90 transition-opacity">
                                </div>

                                <div class="flex justify-between items-start relative">
                                    <div class="flex items-center space-x-2">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 flex items-center justify-center bg-emerald-50 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="absolute top-0 right-0 h-3 w-3">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Approved</h3>
                                            <p class="text-sm text-gray-500">Leave Requests</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end">
                                        <div
                                            class="flex items-center px-2.5 py-1 bg-emerald-50 rounded-lg group-hover:scale-105 transition-transform">
                                            <span class="text-sm font-semibold text-emerald-700">
                                                {{ $leaveStats['approved']['growth'] > 0 ? '+' : '' }}{{
                                                $leaveStats['approved']['growth'] }}%
                                            </span>
                                            <div class="w-14 h-8 ml-2">
                                                <svg viewBox="0 0 40 20" class="w-full h-full">
                                                    <path d="M0 15 L10 12 L20 14 L30 8 L40 5" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        class="text-emerald-500" />
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400 mt-1">vs last month</span>
                                    </div>
                                </div>

                                <div class="mt-8 flex items-end justify-between">
                                    <div>
                                        <span class="text-4xl font-bold text-gray-900">{{
                                            $leaveStats['approved']['count'] }}</span>
                                        <div class="flex items-center mt-2 space-x-1">
                                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400"></span>
                                            <span class="text-sm text-gray-500">Total approved this year</span>
                                        </div>
                                    </div>

                                    @php
                                    $totalRequests = $leaveStats['approved']['count'] +
                                    $leaveStats['pending']['count'] + $leaveStats['rejected']['count'];
                                    $approvedPercentage = $totalRequests > 0 ?
                                    round(($leaveStats['approved']['count'] / $totalRequests) * 100) : 0;
                                    @endphp
                                    <div class="relative w-16 h-16 group-hover:scale-110 transition-transform">
                                        <svg class="w-full h-full" viewBox="0 0 36 36">
                                            <path
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none" stroke="#E2E8F0" stroke-width="3" stroke-linecap="round" />
                                            <path
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none" stroke="#10B981" stroke-width="3" stroke-linecap="round"
                                                stroke-dasharray="{{ $approvedPercentage }}, 100" />
                                            <text x="18" y="20.35" class="text-xs font-medium" text-anchor="middle"
                                                fill="#10B981">{{ $approvedPercentage }}%</text>
                                        </svg>
                                    </div>
                                </div>

                                @php
                                $thisMonthApproved = collect($leaveStats['approved']['chartData'])->last();
                                $totalDaysApproved = collect($leaveStats['approved']['chartData'])->sum();
                                @endphp
                                <div class="mt-6 grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-xl">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $thisMonthApproved }}</div>
                                        <div class="text-xs text-gray-500">This Month</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $totalDaysApproved }}</div>
                                        <div class="text-xs text-gray-500">Total Days</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Card -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200 animate-gradient">
                            </div>
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl opacity-0 group-hover:opacity-10 transition duration-500">
                            </div>

                            <div
                                class="relative bg-white/80 backdrop-blur-lg dark:bg-gray-800 rounded-2xl p-7 h-full ring-1 ring-gray-100/50 shadow-md">
                                <div
                                    class="absolute -top-3 -right-3 w-24 h-24 bg-gradient-to-br from-amber-100 to-amber-50 rounded-full blur-2xl opacity-60 group-hover:opacity-90 transition-opacity">
                                </div>

                                <div class="flex justify-between items-start relative">
                                    <div class="flex items-center space-x-2">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 flex items-center justify-center bg-amber-50 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <span class="absolute top-0 right-0 h-3 w-3">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Pending</h3>
                                            <p class="text-sm text-gray-500">Leave Requests</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end">
                                        <div
                                            class="flex items-center px-2.5 py-1 bg-amber-50 rounded-lg group-hover:scale-105 transition-transform">
                                            <span class="text-sm font-semibold text-amber-700">
                                                {{ $leaveStats['pending']['count'] > 0 ? 'In Review' : 'No Pending'
                                                }}
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-400 mt-1">Current status</span>
                                    </div>
                                </div>

                                <div class="mt-8 flex items-end justify-between">
                                    <div>
                                        <span class="text-4xl font-bold text-gray-900">{{
                                            $leaveStats['pending']['count'] }}</span>
                                        <div class="flex items-center mt-2 space-x-1">
                                            <span class="inline-block w-2 h-2 rounded-full bg-amber-400"></span>
                                            <span class="text-sm text-gray-500">Currently under review</span>
                                        </div>
                                    </div>

                                    @php
                                    $pendingPercentage = $totalRequests > 0 ? round(($leaveStats['pending']['count']
                                    / $totalRequests) * 100) : 0;
                                    @endphp
                                    <div class="relative w-16 h-16 group-hover:scale-110 transition-transform">
                                        <svg class="w-full h-full" viewBox="0 0 36 36">
                                            <path
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none" stroke="#E2E8F0" stroke-width="3" stroke-linecap="round" />
                                            <path
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none" stroke="#D97706" stroke-width="3" stroke-linecap="round"
                                                stroke-dasharray="{{ $pendingPercentage }}, 100" />
                                            <text x="18" y="20.35" class="text-xs font-medium" text-anchor="middle"
                                                fill="#D97706">{{ $pendingPercentage }}%</text>
                                        </svg>
                                    </div>
                                </div>

                                @php
                                $thisMonthPending = collect($leaveStats['pending']['chartData'])->last();
                                $totalDaysPending = collect($leaveStats['pending']['chartData'])->sum();
                                @endphp
                                <div class="mt-6 grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-xl">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $thisMonthPending }}</div>
                                        <div class="text-xs text-gray-500">This Month</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $totalDaysPending }}</div>
                                        <div class="text-xs text-gray-500">Total Days</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rejected Card -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-rose-600 to-pink-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200 animate-gradient">
                            </div>
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-rose-600 to-pink-600 rounded-2xl opacity-0 group-hover:opacity-10 transition duration-500">
                            </div>

                            <div
                                class="relative bg-white/80 backdrop-blur-lg dark:bg-gray-800 rounded-2xl p-7 h-full ring-1 ring-gray-100/50 shadow-md">
                                <div
                                    class="absolute -top-3 -right-3 w-24 h-24 bg-gradient-to-br from-rose-100 to-rose-50 rounded-full blur-2xl opacity-60 group-hover:opacity-90 transition-opacity">
                                </div>

                                <div class="flex justify-between items-start relative">
                                    <div class="flex items-center space-x-2">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 flex items-center justify-center bg-rose-50 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                            <span class="absolute top-0 right-0 h-3 w-3">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">Rejected</h3>
                                            <p class="text-sm text-gray-500">Leave Requests</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end">
                                        <div
                                            class="flex items-center px-2.5 py-1 bg-rose-50 rounded-lg group-hover:scale-105 transition-transform">
                                            <span class="text-sm font-semibold text-rose-700">
                                                {{ $leaveStats['rejected']['growth'] }}%
                                            </span>
                                            <div class="w-14 h-8 ml-2">
                                                <svg viewBox="0 0 40 20" class="w-full h-full">
                                                    <path d="M0 5 L10 8 L20 6 L30 12 L40 15" fill="none"
                                                        stroke="currentColor" stroke-width="2" class="text-rose-500" />
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400 mt-1">vs last month</span>
                                    </div>
                                </div>

                                <div class="mt-8 flex items-end justify-between">
                                    <div>
                                        <span class="text-4xl font-bold text-gray-900">{{
                                            $leaveStats['rejected']['count'] }}</span>
                                        <div class="flex items-center mt-2 space-x-1">
                                            <span class="inline-block w-2 h-2 rounded-full bg-rose-400"></span>
                                            <span class="text-sm text-gray-500">Total rejected requests</span>
                                        </div>
                                    </div>

                                    @php
                                    $totalRequests = $leaveStats['approved']['count'] +
                                    $leaveStats['pending']['count'] + $leaveStats['rejected']['count'];
                                    $rejectedPercentage = $totalRequests > 0 ?
                                    round(($leaveStats['rejected']['count'] / $totalRequests) * 100) : 0;
                                    @endphp
                                    <div class="relative w-16 h-16 group-hover:scale-110 transition-transform">
                                        <svg class="w-full h-full" viewBox="0 0 36 36">
                                            <path
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none" stroke="#E2E8F0" stroke-width="3" stroke-linecap="round" />
                                            <path
                                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none" stroke="#E11D48" stroke-width="3" stroke-linecap="round"
                                                stroke-dasharray="{{ $rejectedPercentage }}, 100" />
                                            <text x="18" y="20.35" class="text-xs font-medium" text-anchor="middle"
                                                fill="#E11D48">
                                                {{ $rejectedPercentage }}%
                                            </text>
                                        </svg>
                                    </div>
                                </div>

                                @php
                                $thisMonthRejected = collect($leaveStats['rejected']['chartData'])->last();
                                $totalDaysRejected = collect($leaveStats['rejected']['chartData'])->sum();
                                @endphp
                                <div class="mt-6 grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-xl">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $thisMonthRejected }}</div>
                                        <div class="text-xs text-gray-500">This Month</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">{{ $totalDaysRejected }}</div>
                                        <div class="text-xs text-gray-500">Total Days</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Leave Types Overview Section --}}
                <div class="px-4 mt-8">
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <!-- Header with Filter Pills -->
                            <div class="flex flex-col space-y-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-semibold text-gray-900">Leave Types Overview</h2>
                                </div>

                                <!-- Status Filter Pills -->
                                <div class="flex flex-wrap gap-2">
                                    <button wire:click="setStatusFilter(null)" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200
                            {{ is_null($selectedStatus) 
                                ? 'bg-violet-100 text-violet-800 ring-2 ring-violet-200' 
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                        All Status
                                        @if(is_null($selectedStatus))
                                        <span
                                            class="ml-2 text-xs bg-violet-200 text-violet-800 px-2 py-0.5 rounded-full">
                                            {{ array_sum(array_column($leaveTypeStats, 'count')) }}
                                        </span>
                                        @endif
                                    </button>
                                    @foreach(['approved', 'pending', 'rejected'] as $status)
                                    <button wire:click="setStatusFilter('{{ $status }}')" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200
                            {{ $selectedStatus === $status 
                                ? 'bg-' . ($status === 'approved' ? 'emerald' : ($status === 'pending' ? 'amber' : 'rose')) . '-100 
                                   text-' . ($status === 'approved' ? 'emerald' : ($status === 'pending' ? 'amber' : 'rose')) . '-800
                                   ring-2 ring-' . ($status === 'approved' ? 'emerald' : ($status === 'pending' ? 'amber' : 'rose')) . '-200' 
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                        {{ ucfirst($status) }}
                                        @if($selectedStatus === $status)
                                        <span class="ml-2 text-xs bg-{{ ($status === 'approved' ? 'emerald' : ($status === 'pending' ? 'amber' : 'rose')) }}-200 
                                   text-{{ ($status === 'approved' ? 'emerald' : ($status === 'pending' ? 'amber' : 'rose')) }}-800 
                                   px-2 py-0.5 rounded-full">
                                            {{ array_sum(array_column($leaveTypeStats, 'count')) }}
                                        </span>
                                        @endif
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($leaveTypeStats as $type => $stats)
                            <div
                                class="group relative rounded-xl border border-gray-100 p-4 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="p-2 bg-{{ $stats['color'] }}-50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-4 h-4 text-{{ $stats['color'] }}-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $stats['icon'] }}" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">{{ $stats['label'] }}</span>
                                            <div class="flex items-center mt-0.5 space-x-2">
                                                @foreach(['approved', 'pending', 'rejected'] as $status)
                                                <span class="inline-flex items-center text-xs
                                            {{ $selectedStatus === $status || is_null($selectedStatus) 
                                                ? 'text-' . ($status === 'approved' ? 'emerald' : ($status === 'pending' ? 'amber' : 'rose')) . '-600' 
                                                : 'text-gray-400' }}">
                                                    {{ $stats['status_counts'][$status] ?? 0 }}
                                                    {{ ucfirst($status) }}
                                                </span>
                                                @if(!$loop->last)
                                                <span class="text-gray-300">•</span>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                        @foreach(['approved', 'pending', 'rejected'] as $status)
                                        @php
                                        $width = $stats['count'] > 0
                                        ? (($stats['status_counts'][$status] ?? 0) / $stats['count']) * 100
                                        : 0;
                                        $color = $status === 'approved' ? 'emerald' : ($status === 'pending' ? 'amber' :
                                        'rose');
                                        @endphp
                                        <div class="float-left h-full bg-{{ $color }}-500 transition-all duration-300"
                                            style="width: {{ $width }}%">
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-2 flex items-center justify-between text-xs">
                                        <div class="flex items-center space-x-3">
                                            @foreach(['approved' => 'emerald', 'pending' => 'amber', 'rejected' =>
                                            'rose'] as $status => $color)
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 rounded-full bg-{{ $color }}-500"></div>
                                                <span class="text-gray-500">{{ ucfirst($status) }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                        <span class="text-gray-500">Total: {{ $stats['count'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Main Grid Section --}}
                <div class="px-4 mt-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Section: Pending Leaves -->
                        <!-- Left Section: Pending Leaves -->
                        <div class="lg:col-span-2">
                            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-gray-100">
                                <div class="p-4 sm:p-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">Pending Leave Requests</h2>
                                    <p class="text-sm text-gray-500 mt-1">Review and manage leave applications</p>
                                </div>

                                <div class="p-4 sm:p-6">
                                    @forelse($pendingLeaves as $leave)
                                    <div
                                        class="group relative rounded-xl border border-gray-100 p-3 sm:p-4 mb-3 hover:shadow-md transition-all duration-200">
                                        <!-- Hover gradient effect -->
                                        <div
                                            class="absolute inset-x-0 -top-px h-px w-full bg-gradient-to-r from-transparent via-violet-500 to-transparent opacity-0 transition-all group-hover:opacity-100">
                                        </div>

                                        <div class="flex flex-col sm:flex-row gap-4">
                                            <!-- Left side with enhanced user info -->
                                            <div class="flex items-start space-x-3 flex-grow">
                                                <!-- Enhanced User Avatar with fallback -->
                                                <div class="relative flex-shrink-0">
                                                    @if($leave->user && $leave->user->profile_photo_url)
                                                    <img src="{{ $leave->user->profile_photo_url }}"
                                                        alt="{{ $leave->name }}"
                                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-sm" />
                                                    @else
                                                    <div class="relative w-12 h-12">
                                                        <div
                                                            class="absolute inset-0 bg-gradient-to-br from-violet-100 to-violet-50 rounded-full">
                                                        </div>
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-violet-700">
                                                                {{ strtoupper(substr($leave->name ?? 'U', 0, 2)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- Online/Status indicator -->
                                                    <div class="absolute -right-0.5 -bottom-0.5">
                                                        <div
                                                            class="w-3.5 h-3.5 bg-emerald-400 rounded-full ring-2 ring-white">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Leave Details with enhanced user info -->
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex flex-col">
                                                            <h3
                                                                class="text-sm font-semibold text-gray-900 truncate group-hover:text-violet-600 transition-colors">
                                                                {{ $leave->user->name }}
                                                            </h3>
                                                            <p class="text-xs text-gray-500 truncate">
                                                                {{ $leave->user->department->name ?? 'Department' }} •
                                                                {{$leave->user->position ?? 'Position' }}
                                                            </p>
                                                        </div>

                                                        <!-- Action Buttons - Desktop -->
                                                        <div class="hidden sm:flex items-center gap-2">
                                                            <button
                                                                wire:click="initiateStatusChange({{ $leave->id }}, 'approve')"
                                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                Approve
                                                            </button>
                                                            <button
                                                                wire:click="initiateStatusChange({{ $leave->id }}, 'reject')"
                                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-rose-700 bg-rose-50 rounded-lg hover:bg-rose-100 transition-colors">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                Reject
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Leave Type and Duration -->
                                                    <div
                                                        class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium 
                                                                {{ $leave->type === 'sick' ? 'bg-rose-50 text-rose-700' :
                                                                   ($leave->type === 'annual' ? 'bg-blue-50 text-blue-700' :
                                                                   ($leave->type === 'important' ? 'bg-amber-50 text-amber-700' : 
                                                                    'bg-slate-50 text-slate-700')) }}">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                @if($leave->type === 'sick')
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                                @elseif($leave->type === 'annual')
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                @else
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                @endif
                                                            </svg>
                                                            {{ ucfirst($leave->type) }}
                                                        </span>
                                                        <span class="text-gray-300">•</span>
                                                        @php
                                                        $startDate = \Carbon\Carbon::parse($leave->start_date);
                                                        $endDate = \Carbon\Carbon::parse($leave->end_date);
                                                        $duration = $startDate->diffInDays($endDate) + 1;
                                                        @endphp
                                                        <span class="text-gray-600">{{ $duration }} {{
                                                            Str::plural('day', $duration) }}</span>
                                                    </div>

                                                    <!-- Leave Reason -->
                                                    <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $leave->reason
                                                        }}</p>

                                                    <!-- Date Info and Mobile Actions -->
                                                    <div class="mt-3 flex items-center justify-between">
                                                        <div class="flex items-center text-xs text-gray-500">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M
                                                            d, Y') }}
                                                        </div>

                                                        <!-- Action Buttons - Mobile Only -->
                                                        <div class="sm:hidden flex items-center gap-2">
                                                            <button
                                                                wire:click="initiateStatusChange({{ $leave->id }}, 'approve')"
                                                                class="p-1.5 text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                            </button>
                                                            <button
                                                                wire:click="initiateStatusChange({{ $leave->id }}, 'reject')"
                                                                class="p-1.5 text-rose-700 bg-rose-50 rounded-lg hover:bg-rose-100 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-12">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-sm font-medium text-gray-900">No Pending Requests</h3>
                                        <p class="mt-2 text-sm text-gray-500">All leave requests have been
                                            processed.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Right Section: Leave Types -->
                        <div class="lg:col-span-1">
                            <!-- Current Leaves Section -->
                            <div class="">
                                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-sm border border-gray-100">
                                    <div class="p-6 border-b border-gray-100">
                                        <div class="flex items-center justify-between">
                                            <h2 class="text-lg font-semibold text-gray-900">Currently On Leave</h2>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-50 text-violet-700">
                                                {{ $currentLeaves->count() ?? 0 }} Active
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        @forelse($currentLeaves ?? [] as $leave)
                                        <div
                                            class="group relative rounded-xl border border-gray-100 p-4 mb-3 hover:shadow-md transition-all duration-200">
                                            <!-- Hover gradient effect -->
                                            <div
                                                class="absolute inset-x-0 -top-px h-px w-full bg-gradient-to-r from-transparent via-violet-500 to-transparent opacity-0 transition-all group-hover:opacity-100">
                                            </div>

                                            <div class="flex items-start space-x-4">
                                                <!-- User Avatar -->
                                                <div class="relative flex-shrink-0">
                                                    @if($leave->user?->profile_photo_url)
                                                    <img src="{{ $leave->user->profile_photo_url }}"
                                                        alt="{{ $leave->user->name }}"
                                                        class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm" />
                                                    @else
                                                    <div class="relative w-10 h-10">
                                                        <div
                                                            class="absolute inset-0 bg-gradient-to-br from-violet-100 to-violet-50 rounded-full">
                                                        </div>
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <span class="text-xs font-medium text-violet-700">
                                                                {{ strtoupper(substr($leave->user?->name ?? 'U', 0, 2))
                                                                }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- Leave Type Indicator -->
                                                    <div class="absolute -right-1 -bottom-1">
                                                        <div
                                                            class="w-5 h-5 rounded-full bg-white shadow-sm flex items-center justify-center">
                                                            <div class="w-3.5 h-3.5 rounded-full 
                                    {{ $leave->type === 'sick' ? 'bg-rose-400' : 
                                       ($leave->type === 'annual' ? 'bg-blue-400' : 
                                       ($leave->type === 'important' ? 'bg-amber-400' : 'bg-slate-400')) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Leave Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex flex-col">
                                                            <h3
                                                                class="text-sm font-semibold text-gray-900 truncate group-hover:text-violet-600 transition-colors">
                                                                {{ $leave->user?->name }}
                                                            </h3>
                                                            <p class="text-xs text-gray-500 truncate">
                                                                {{ $leave->user?->department?->name }} • {{
                                                                $leave->user?->position }}
                                                            </p>
                                                        </div>

                                                        @php
                                                        $startDate = \Carbon\Carbon::parse($leave->start_date);
                                                        $endDate = \Carbon\Carbon::parse($leave->end_date);
                                                        $daysLeft = now()->diffInDays($endDate, false) + 1;
                                                        @endphp
                                                        <div class="flex flex-col items-end">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                    {{ $daysLeft <= 1 ? 'bg-rose-50 text-rose-700' :
                                       ($daysLeft <= 3 ? 'bg-amber-50 text-amber-700' : 
                                        'bg-emerald-50 text-emerald-700') }}">
                                                                {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                                                            </span>
                                                            <span class="text-xs text-gray-500 mt-0.5">Returns {{
                                                                $endDate->format('M d') }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Progress Bar -->
                                                    <div class="mt-3">
                                                        @php
                                                        $totalDays = $startDate->diffInDays($endDate) + 1;
                                                        $daysSpent = $startDate->diffInDays(now()) + 1;
                                                        $progress = min(100, ($daysSpent / $totalDays) * 100);
                                                        @endphp
                                                        <div class="relative">
                                                            <div
                                                                class="flex mb-1 items-center justify-between text-xs text-gray-500">
                                                                <span>Progress</span>
                                                                <span>{{ round($progress) }}%</span>
                                                            </div>
                                                            <div
                                                                class="overflow-hidden h-1.5 flex rounded-full bg-gray-100">
                                                                <div style="width: {{ $progress }}%"
                                                                    class="transition-all duration-500 ease-out bg-violet-500">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Leave Type Tag and Duration -->
                                                    <div class="mt-3 flex items-center gap-2">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium 
                                {{ $leave->type === 'sick' ? 'bg-rose-50 text-rose-700' :
                                   ($leave->type === 'annual' ? 'bg-blue-50 text-blue-700' :
                                   ($leave->type === 'important' ? 'bg-amber-50 text-amber-700' : 
                                    'bg-slate-50 text-slate-700')) }}">
                                                            {{ ucfirst($leave->type) }}
                                                        </span>
                                                        <span class="text-gray-300">•</span>
                                                        <span class="text-xs text-gray-500">
                                                            {{ $startDate->format('M d') }} - {{ $endDate->format('M d,
                                                            Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center py-6">
                                            <div
                                                class="w-16 h-16 bg-violet-50 rounded-full flex items-center justify-center mx-auto">
                                                <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="mt-4 text-sm font-medium text-gray-900">No Active Leaves</h3>
                                            <p class="mt-2 text-sm text-gray-500">Everyone is currently working.</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-data="{ show: @entangle('showStatusModal') }" x-show="show" x-cloak
            class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-all"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 shadow-2xl transition-all"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                @if($actionType === 'approve')
                                Approve Leave Request
                                @elseif($actionType === 'reject')
                                Reject Leave Request
                                @else
                                Update Leave Request Status
                                @endif
                            </h3>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if($selectedRequest)
                    <!-- Modal Content -->
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($actionType === 'approve')
                                    <div
                                        class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    @elseif($actionType === 'reject')
                                    <div
                                        class="w-10 h-10 rounded-full bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-rose-600 dark:text-rose-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        @if($actionType === 'approve')
                                        Confirm Approval
                                        @elseif($actionType === 'reject')
                                        Confirm Rejection
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if($actionType === 'approve')
                                        Are you sure you want to approve this leave request?
                                        @elseif($actionType === 'reject')
                                        Are you sure you want to reject this leave request?
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Request Details -->
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Employee</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{
                                        $selectedRequest->user->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Leave Type</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{
                                        ucfirst($selectedRequest->type) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Duration</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($selectedRequest->start_date)->format('M d, Y') }} -
                                        {{ \Carbon\Carbon::parse($selectedRequest->end_date)->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30">
                        <div class="flex justify-end space-x-3">
                            <button @click="show = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                Cancel
                            </button>

                            @if($actionType === 'approve')
                            <button wire:click="updateStatus('approved')"
                                class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                Confirm Approval
                            </button>
                            @elseif($actionType === 'reject')
                            <button wire:click="updateStatus('rejected')"
                                class="px-4 py-2 text-sm font-medium text-white bg-rose-600 rounded-lg hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                                Confirm Rejection
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <style>
            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .animate-gradient {
                animation: gradient 3s ease infinite;
                background-size: 200% 200%;
            }
        </style>

    </div>