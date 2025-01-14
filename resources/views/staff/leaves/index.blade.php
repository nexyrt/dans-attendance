{{-- resources/views/staff/leaves/index.blade.php --}}
<x-layouts.staff>
    <div class="min-h-screen">
        <div class="max-w-full py-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Leave Balance Card -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-sm p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium opacity-90">Annual Leave Balance</h3>
                            <p class="mt-4 text-4xl font-bold">{{ $leaveBalance->remaining_balance ?? 0 }}</p>
                            <p class="text-sm opacity-80 mt-1">days remaining</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between text-sm opacity-90 mb-2">
                            <span>Used</span>
                            <span>{{ $leaveBalance->used_balance ?? 0 }} / {{ $leaveBalance->total_balance ?? 0 }}
                                days</span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-2">
                            @php
                                $percentage = $leaveBalance
                                    ? ($leaveBalance->used_balance / $leaveBalance->total_balance) * 100
                                    : 0;
                            @endphp
                            <div class="bg-white h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Pending Requests</h3>
                            <p class="mt-4 text-4xl font-bold text-gray-900">{{ $pendingCount ?? 0 }}</p>
                            <p class="text-sm text-gray-500 mt-1">awaiting approval</p>
                        </div>
                        <div class="bg-amber-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                        <div class="bg-emerald-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>

                    @if ($recentActivity && $recentActivity->count() > 0)
                        <div class="space-y-4">
                            @foreach ($recentActivity->take(3) as $activity)
                                <div class="flex items-center gap-3">
                                    <div @class([
                                        'w-2 h-2 rounded-full flex-shrink-0',
                                        'bg-emerald-500' => $activity->status === 'approved',
                                        'bg-red-500' => $activity->status === 'rejected',
                                        'bg-amber-500' => $activity->status === 'pending',
                                        'bg-gray-500' => $activity->status === 'cancel',
                                    ])></div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ ucfirst($activity->type) }} Leave
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span @class([
                                        'px-2 py-1 text-xs font-medium rounded-full',
                                        'bg-emerald-100 text-emerald-800' => $activity->status === 'approved',
                                        'bg-red-100 text-red-800' => $activity->status === 'rejected',
                                        'bg-amber-100 text-amber-800' => $activity->status === 'pending',
                                        'bg-gray-100 text-gray-800' => $activity->status === 'cancel',
                                    ])>
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-center h-32 text-sm text-gray-500">
                            No recent activity
                        </div>
                    @endif
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative"
                    x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ session('success') }}
                        </span>
                        <button @click="show = false" class="text-green-700 hover:text-green-900">×</button>
                    </div>
                </div>
            @endif

            {{-- Add this error notification section --}}
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative"
                    x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            {{ session('error') }}
                        </span>
                        <button @click="show = false" class="text-red-700 hover:text-red-900">×</button>
                    </div>
                </div>
            @endif

            <!-- Action Bar -->
            <div class="flex justify-between items-center mb-8">
                <button x-data @click="$dispatch('open-modal', 'create-leave')"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Request
                </button>
            </div>

            <!-- Leave Requests Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Request Details
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Duration
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($leaveRequests as $request)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <span @class([
                                                'inline-flex items-center justify-center w-10 h-10 rounded-lg mr-3',
                                                'bg-blue-50 text-blue-600' => $request->type === 'annual',
                                                'bg-red-50 text-red-600' => $request->type === 'sick',
                                                'bg-yellow-50 text-yellow-600' => $request->type === 'important',
                                                'bg-gray-50 text-gray-600' => $request->type === 'other',
                                            ])>
                                                @if ($request->type === 'annual')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                @elseif($request->type === 'sick')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                @elseif($request->type === 'important')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                @endif
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 capitalize">
                                                    {{ $request->type }} Leave</p>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    Submitted {{ $request->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-gray-900">
                                                {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                to
                                                {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            'bg-amber-100 text-amber-800' => $request->status === 'pending',
                                            'bg-emerald-100 text-emerald-800' => $request->status === 'approved',
                                            'bg-red-100 text-red-800' => $request->status === 'rejected',
                                            'bg-gray-100 text-gray-800' => $request->status === 'cancel',
                                        ])>
                                            <span @class([
                                                'w-1 h-1 mr-1.5 rounded-full',
                                                'bg-amber-500' => $request->status === 'pending',
                                                'bg-emerald-500' => $request->status === 'approved',
                                                'bg-red-500' => $request->status === 'rejected',
                                                'bg-gray-500' => $request->status === 'cancel',
                                            ])></span>
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-3">
                                            <button
                                                @click="$dispatch('open-modal', 'view-reason-{{ $request->id }}')"
                                                class="text-gray-600 hover:text-blue-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>

                                            @if ($request->status === 'pending')
                                                <button
                                                    @click="$dispatch('open-modal', 'cancel-leave-{{ $request->id }}')"
                                                    class="text-red-600 hover:text-red-900">
                                                    Cancel Request
                                                </button>
                                            @endif

                                            @if ($request->attachment_path)
                                                <a href="{{ Storage::url($request->attachment_path) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Cancel Request Modal -->
                                <x-modals.modal name="cancel-leave-{{ $request->id }}" :show="false">
                                    <div class="p-8">
                                        <!-- Warning Icon -->
                                        <div
                                            class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-6">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>

                                        <h3 class="text-xl font-semibold text-gray-900 text-center">Cancel Leave
                                            Request?</h3>
                                        <p class="mt-2 text-sm text-gray-500 text-center">This action cannot be undone.
                                        </p>

                                        <!-- Request Summary -->
                                        <div class="mt-6 bg-gray-50 rounded-xl p-4">
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-gray-500">Type</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900 capitalize">{{ $request->type }}
                                                        Leave</span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-gray-500">Duration</span>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $request->getDurationInDays() }}
                                                        days</span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-gray-500">Period</span>
                                                    <span class="text-sm font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <form method="POST" action="{{ route('staff.leave.cancel', $request) }}"
                                            class="mt-8 space-y-3">
                                            @csrf
                                            <button type="submit"
                                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Yes, Cancel Request
                                            </button>
                                            <button type="button"
                                                @click="$dispatch('close-modal', 'cancel-leave-{{ $request->id }}')"
                                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                                No, Keep It
                                            </button>
                                        </form>
                                    </div>
                                </x-modals.modal>

                                <!-- View Details Modal -->
                                <x-modals.modal name="view-reason-{{ $request->id }}" :show="false">
                                    <div class="p-6">
                                        <!-- Header -->
                                        <div
                                            class="flex justify-between items-start mb-6 pb-6 border-b border-gray-100">
                                            <div>
                                                <h2 class="text-xl font-bold text-gray-900">Leave Request Details</h2>
                                                <p class="mt-1 text-sm text-gray-500">Request submitted
                                                    {{ $request->created_at->format('M d, Y \a\t h:i A') }}</p>
                                            </div>
                                            <span @class([
                                                'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                                'bg-amber-100 text-amber-800' => $request->status === 'pending',
                                                'bg-emerald-100 text-emerald-800' => $request->status === 'approved',
                                                'bg-red-100 text-red-800' => $request->status === 'rejected',
                                                'bg-gray-100 text-gray-800' => $request->status === 'cancel',
                                            ])>
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full mr-2 
                                                        {{ $request->status === 'pending' ? 'bg-amber-500' : '' }}
                                                        {{ $request->status === 'approved' ? 'bg-emerald-500' : '' }}
                                                        {{ $request->status === 'rejected' ? 'bg-red-500' : '' }}
                                                        {{ $request->status === 'cancel' ? 'bg-gray-500' : '' }}">
                                                </span>
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </div>

                                        <div class="space-y-6">
                                            <!-- Leave Information Card -->
                                            <div class="bg-gray-50 rounded-xl p-4">
                                                <div class="grid grid-cols-2 gap-6">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">Leave Type</p>
                                                        <div class="mt-2 flex items-center">
                                                            <span @class([
                                                                'inline-flex items-center justify-center w-8 h-8 rounded-lg mr-3',
                                                                'bg-blue-50 text-blue-600' => $request->type === 'annual',
                                                                'bg-red-50 text-red-600' => $request->type === 'sick',
                                                                'bg-amber-50 text-amber-600' => $request->type === 'important',
                                                                'bg-gray-50 text-gray-600' => $request->type === 'other',
                                                            ])>
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <!-- Icon based on leave type -->
                                                                </svg>
                                                            </span>
                                                            <span
                                                                class="text-sm font-medium text-gray-900 capitalize">{{ $request->type }}
                                                                Leave</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">Duration</p>
                                                        <p class="mt-2 text-sm text-gray-900">
                                                            {{ $request->getDurationInDays() }}
                                                            {{ Str::plural('day', $request->getDurationInDays()) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Date Range -->
                                            <div class="grid grid-cols-2 gap-6">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Start Date</p>
                                                    <div class="mt-2 flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="text-sm text-gray-900">
                                                            {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M d, Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">End Date</p>
                                                    <div class="mt-2 flex items-center">
                                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="text-sm text-gray-900">
                                                            {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M d, Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reason -->
                                            <div>
                                                <p class="text-sm font-medium text-gray-500">Reason for Leave</p>
                                                <p class="mt-2 text-sm text-gray-900 bg-gray-50 rounded-lg p-4">
                                                    {{ $request->reason }}</p>
                                            </div>

                                            <!-- Attachment -->
                                            @if ($request->attachment_path)
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">Supporting Document
                                                    </p>
                                                    <a href="{{ Storage::url($request->attachment_path) }}"
                                                        target="_blank"
                                                        class="mt-2 inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        View Document
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Footer -->
                                        <div class="mt-8">
                                            <button type="button"
                                                @click="$dispatch('close-modal', 'view-reason-{{ $request->id }}')"
                                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                                Close Details
                                            </button>
                                        </div>
                                    </div>
                                </x-modals.modal>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No leave requests</h3>
                                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new leave
                                                request.</p>
                                            <div class="mt-6">
                                                <button x-data @click="$dispatch('open-modal', 'create-leave')"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    New Leave Request
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($leaveRequests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $leaveRequests->links() }}
                    </div>
                @endif
            </div>


            {{-- Create Leave Request --}}
            <x-modals.modal name="create-leave" :show="false" maxWidth="2xl">
                <div class="bg-white rounded-xl mt-3">
                    <!-- Modal Header - Removed extra padding/gaps -->
                    <div
                        class="px-8 py-6 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-t-xl border-b border-gray-100">
                        <h2 class="text-2xl font-semibold text-gray-900">New Leave Request</h2>
                        <p class="mt-1 text-sm text-gray-600">Fill in the details below to submit your leave request
                        </p>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('staff.leave.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Leave Type Selection with Active States -->
                            <div class="grid grid-cols-4 gap-4 mb-8">
                                @foreach ([
                                            'annual' => [
                                                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                                'color' => 'blue',
                                                'description' => 'Regular planned leave',
                                            ],
                                            'sick' => [
                                                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                                                'color' => 'red',
                                                'description' => 'Health-related leave',
                                            ],
                                            'important' => [
                                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                                'color' => 'amber',
                                                'description' => 'Urgent matters',
                                            ],
                                            'other' => [
                                                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                                'color' => 'gray',
                                                'description' => 'Other purposes',
                                            ],
                                        ] as $type => $config)
                                    <div>
                                        <input type="radio" id="type-{{ $type }}" name="type"
                                            value="{{ $type }}" class="peer hidden"
                                            {{ $type === 'annual' ? 'checked' : '' }}>

                                        <label for="type-{{ $type }}" class="block cursor-pointer">
                                            <div
                                                class="p-4 rounded-xl border-2 border-gray-200 hover:border-{{ $config['color'] }}-500 peer-checked:border-{{ $config['color'] }}-500 peer-checked:bg-{{ $config['color'] }}-500 transition-all duration-200 ">
                                                <div class="flex flex-col items-center gap-3">
                                                    <div
                                                        class="p-3 rounded-xl bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-600">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="{{ $config['icon'] }}" />
                                                        </svg>
                                                    </div>
                                                    <div class="text-center">
                                                        <span
                                                            class="block text-sm font-medium text-gray-900 capitalize">{{ $type }}</span>
                                                        <span
                                                            class="text-xs text-gray-500">{{ $config['description'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Date Selection - Wider layout -->
                            <div class="grid grid-cols-2 gap-8 mb-8">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-900">Start Date</label>
                                    <div class="relative">
                                        <input type="date" name="start_date" required
                                            class="block w-full px-4 py-3 text-gray-700 bg-white border border-gray-200 rounded-xl 
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 
                                       appearance-none hover:border-blue-400"
                                            min="{{ date('Y-m-d') }}" style="min-height: 48px;">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-900">End Date</label>
                                    <div class="relative">
                                        <input type="date" name="end_date" required
                                            class="block w-full px-4 py-3 text-gray-700 bg-white border border-gray-200 rounded-xl 
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 
                                       appearance-none hover:border-blue-400"
                                            min="{{ date('Y-m-d') }}" style="min-height: 48px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Reason Input with Character Count -->
                            <div class="space-y-2 mb-8">
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-medium text-gray-900">Reason for Leave</label>
                                    <span class="text-xs text-gray-500" x-data="{ count: 0 }"
                                        x-init="count = $refs.reason.value.length">
                                        <span x-text="count"></span>/500 characters
                                    </span>
                                </div>
                                <div class="relative">
                                    <textarea name="reason" rows="4" required x-ref="reason" @input="count = $event.target.value.length"
                                        maxlength="500"
                                        class="block w-full px-4 py-3 text-gray-700 bg-white border border-gray-200 rounded-xl 
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none
                                   hover:border-blue-400"
                                        placeholder="Please provide a detailed reason for your leave request..."></textarea>
                                </div>
                            </div>

                            <!-- File Upload with Improved Preview -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-900">Supporting Document</label>
                                <div x-data="{
                                    fileName: '',
                                    fileSize: '',
                                    isUploaded: false,
                                    handleFile(e) {
                                        if (e.target.files.length > 0) {
                                            this.fileName = e.target.files[0].name;
                                            this.fileSize = (e.target.files[0].size / 1024).toFixed(2);
                                            this.isUploaded = true;
                                        }
                                    }
                                }">
                                    <!-- Empty State -->
                                    <div x-show="!isUploaded"
                                        class="relative border-2 border-dashed border-gray-200 rounded-xl hover:border-blue-500 
                                   transition-all duration-200 group">
                                        <input type="file" name="attachment" @change="handleFile($event)"
                                            accept=".pdf,.png,.jpg,.jpeg"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="p-6 text-center">
                                            <div
                                                class="flex items-center justify-center w-14 h-14 mx-auto mb-4 bg-blue-50 rounded-xl 
                                            group-hover:bg-blue-100 group-hover:scale-110 transition-all duration-200">
                                                <svg class="w-6 h-6 text-blue-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-sm">
                                                    <span class="text-blue-500 font-medium">Click to upload</span>
                                                    <span class="text-gray-500"> or drag and drop</span>
                                                </p>
                                                <p class="text-xs text-gray-500">PDF, PNG, JPG (max. 10MB)</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preview State -->
                                    <div x-show="isUploaded" x-cloak
                                        class="relative border-2 border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100/50 
                                   transition-all duration-200">
                                        <div class="p-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg 
                                                    shrink-0">
                                                        <svg class="w-5 h-5 text-blue-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate"
                                                            x-text="fileName"></p>
                                                        <p class="text-xs text-gray-500" x-text="`${fileSize} KB`">
                                                        </p>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    @click="isUploaded = false; $refs.fileInput.value = ''"
                                                    class="p-1 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 
                                               transition-colors">
                                                    <span class="sr-only">Remove file</span>
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
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

                            <!-- Divider -->
                            <div class="relative my-8">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                            </div>

                            <!-- Action Buttons with Improved Styling -->
                            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-8">
                                <button type="button" @click="$dispatch('close-modal', 'create-leave')"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel Request
                                </button>

                                <button type="submit"
                                    class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Submit Request
                                </button>
                            </div>

                            <!-- Leave Balance Info -->
                            <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="p-2 bg-blue-100 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">Available Leave Balance</p>
                                        <p class="text-sm text-gray-500">You have
                                            {{ Auth::user()->leaveBalance?->remaining_balance ?? 0 }} days remaining
                                            for this year</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </x-modals.modal>
        </div>
    </div>
</x-layouts.staff>
