<!-- resources/views/livewire/staff/leave.blade.php -->
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Leave Balance Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <!-- Available Balance -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl h-[150px]">
                <div class="flex flex-col h-full p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Available Balance</h3>
                            <div class="mt-1 flex items-baseline">
                                <span
                                    class="text-2xl font-bold text-gray-900">{{ $leaveBalance->remaining_balance }}</span>
                                <span class="ml-2 text-sm text-gray-500">days</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full transition-all duration-500"
                                style="width: {{ ($leaveBalance->remaining_balance / $leaveBalance->total_balance) * 100 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Used Leave Days -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl h-[150px]">
                <div class="flex flex-col h-full p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Used Leave Days</h3>
                            <div class="mt-1 flex items-baseline">
                                <span class="text-2xl font-bold text-gray-900">{{ $leaveBalance->used_balance }}</span>
                                <span class="ml-2 text-sm text-gray-500">days</span>
                            </div>
                        </div>
                    </div>

                    @if ($lastLeave = $this->getLastLeave())
                        <div class="mt-auto text-sm text-gray-500">
                            Last leave: {{ $lastLeave->start_date->format('M j') }} -
                            {{ $lastLeave->end_date->format('M j') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Leave Template -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl h-[150px]">
                <div class="flex flex-col h-full p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Leave Template</h3>
                            <p class="mt-1 text-sm text-gray-500">Download required form</p>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <a href="{{ asset('templates/Format-Izin-Cuti.docx') }}" download
                            class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Template
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-xl shadow-sm">
            <!-- Main Navigation -->
            <div class="border-b border-gray-200">
                <!-- Desktop Navigation -->
                <nav class="hidden sm:flex sm:space-x-8 px-4 sm:px-6" aria-label="Tabs">
                    <button wire:click="$set('activeView', 'requests')"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 {{ $activeView === 'requests'
                            ? 'border-blue-500 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                whitespace-nowrap font-medium text-sm transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Leave Requests</span>
                    </button>
                    <button wire:click="$set('activeView', 'form')"
                        class="py-4 px-1 inline-flex items-center gap-2 border-b-2 {{ $activeView === 'form'
                            ? 'border-blue-500 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                whitespace-nowrap font-medium text-sm transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>New Request</span>
                    </button>
                </nav>

                <!-- Mobile Navigation -->
                <div class="sm:hidden">
                    <div class="grid grid-cols-2 gap-1 p-2">
                        <button wire:click="$set('activeView', 'requests')"
                            class="inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg font-medium text-sm transition-all
                    {{ $activeView === 'requests'
                        ? 'bg-blue-50 text-blue-600'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Leave Requests</span>
                        </button>
                        <button wire:click="$set('activeView', 'form')"
                            class="inline-flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg font-medium text-sm transition-all
                    {{ $activeView === 'form' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span>New Request</span>
                        </button>
                    </div>
                    <div class="h-px bg-gray-200"></div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6">
                @if ($activeView === 'requests')
                    <!-- Leave Requests View -->
                    <div>
                        <!-- Status Tabs -->
                        <div class="border-b border-gray-200 mb-6">
                            <div class="sm:px-6">
                                <nav class="flex space-x-8 px-6 overflow-x-auto" aria-label="Tabs">
                                    <button wire:click="$set('activeTab', 'pending')"
                                        class="inline-flex items-center py-4 px-1 gap-2 border-b-2 {{ $activeTab === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap font-medium text-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Pending
                                        <span
                                            class="ml-1 px-2.5 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                            {{ $this->pendingCount }}
                                        </span>
                                    </button>

                                    <button wire:click="$set('activeTab', 'approved')"
                                        class="inline-flex items-center py-4 px-1 gap-2 border-b-2 {{ $activeTab === 'approved' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap font-medium text-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Approved
                                        <span
                                            class="ml-1 px-2.5 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                            {{ $this->approvedCount }}
                                        </span>
                                    </button>

                                    <button wire:click="$set('activeTab', 'rejected')"
                                        class="inline-flex items-center py-4 px-1 gap-2 border-b-2 {{ $activeTab === 'rejected' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap font-medium text-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Rejected
                                        <span
                                            class="ml-1 px-2.5 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                            {{ $this->rejectedCount }}
                                        </span>
                                    </button>

                                    <button wire:click="$set('activeTab', 'cancelled')"
                                        class="inline-flex items-center py-4 px-1 gap-2 border-b-2 {{ $activeTab === 'cancelled' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap font-medium text-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancelled
                                        <span
                                            class="ml-1 px-2.5 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                            {{ $this->cancelledCount }}
                                        </span>
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Leave Requests Table View -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <!-- Table Container -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                Type & Duration
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                Dates
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                Details
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($leaveRequests as $request)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <!-- Type & Duration -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div @class([
                                                            'flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center',
                                                            'bg-orange-50 text-orange-600' => $request->type === 'sick',
                                                            'bg-blue-50 text-blue-600' => $request->type === 'annual',
                                                            'bg-purple-50 text-purple-600' => $request->type === 'important',
                                                            'bg-gray-50 text-gray-600' => $request->type === 'other',
                                                        ])>
                                                            @switch($request->type)
                                                                @case('sick')
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                @break

                                                                @case('annual')
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                @break

                                                                @case('important')
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                    </svg>
                                                                @break

                                                                @default
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                            @endswitch
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ ucfirst($request->type) }} Leave
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $request->getDurationInDays() }} days
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Status -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span @class([
                                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize',
                                                        'bg-yellow-100 text-yellow-800' => $request->status === 'pending',
                                                        'bg-green-100 text-green-800' => $request->status === 'approved',
                                                        'bg-red-100 text-red-800' => $request->status === 'rejected',
                                                        'bg-gray-100 text-gray-800' => $request->status === 'cancelled',
                                                    ])>
                                                        {{ $request->status }}
                                                    </span>
                                                    @if ($request->approved_by)
                                                        <div class="mt-1 flex items-center text-sm text-gray-500">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            {{ $request->approvedBy->name }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- Dates -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M j, Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M j, Y') }}
                                                    </div>
                                                </td>

                                                <!-- Details -->
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 max-w-xs truncate"
                                                        title="{{ $request->reason }}">
                                                        {{ $request->reason }}
                                                    </div>
                                                    @if (asset($request->attachment_path))
                                                        <div class="mt-1 flex items-center text-sm text-gray-500">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                            </svg>
                                                            {{ asset($request->attachment_path) }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- Actions -->
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center gap-2">
                                                        @if ($request->attachment_path)
                                                            <!-- Preview Button -->
                                                            <button
                                                                wire:click="previewAttachment({{ $request->id }})"
                                                                class="text-gray-500 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100"
                                                                title="Preview">
                                                                <svg class="w-5 h-5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                            </button>

                                                            <!-- Download Button -->
                                                            <a href="{{ asset($request->attachment_path) }}" download
                                                                class="text-gray-500 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100"
                                                                title="Download">
                                                                <svg class="w-5 h-5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                            </a>
                                                        @endif
                                                        @if ($request->canBeCancelled())
                                                            <button wire:click="cancelRequest({{ $request->id }})"
                                                                wire:confirm="Are you sure you want to cancel this leave request?"
                                                                class="text-red-500 hover:text-red-700 p-1 rounded-lg hover:bg-red-50"
                                                                title="Cancel">
                                                                <svg class="w-5 h-5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-6 py-12 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                        </svg>
                                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No leave
                                                            requests found</h3>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            {{ $activeTab === 'pending' ? 'Get started by creating a new leave request.' : 'No ' . $activeTab . ' leave requests found.' }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Preview Modal -->
                                @if ($showPreview)
                                    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" x-data
                                        @keydown.escape.window="$wire.closePreview()">
                                        <div
                                            class="bg-white rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                                            <!-- Modal Header -->
                                            <div class="flex items-center justify-between p-4 border-b">
                                                <h3 class="text-lg font-medium text-gray-900">Document Preview</h3>
                                                <button wire:click="closePreview"
                                                    class="text-gray-400 hover:text-gray-500 p-1">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Modal Content -->
                                            <div class="p-4">
                                                @if ($previewType === 'pdf')
                                                    <iframe src="{{ $previewUrl }}" class="w-full h-[70vh] border-0"
                                                        type="application/pdf"></iframe>
                                                @elseif(in_array($previewType, ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ $previewUrl }}" alt="Document Preview"
                                                        class="max-w-full h-auto mx-auto">
                                                @elseif(in_array($previewType, ['doc', 'docx']))
                                                    <div class="text-center py-8">
                                                        <svg class="w-16 h-16 mx-auto text-blue-500 mb-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                        <p class="text-gray-600 mb-4">Preview not available for Word
                                                            documents</p>
                                                        <a href="{{ $previewUrl }}" download
                                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                                            <svg class="w-5 h-5 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                            Download Document
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Leave Form UI -->
                        <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
                            <form wire:submit="submitLeave" class="space-y-8">
                                <!-- Top Section: Leave Type and Date Range -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Leave Type -->
                                    <div class="w-full">
                                        <label class="block text-sm font-medium text-gray-900 mb-2">Leave Type</label>
                                        <x-input.select wire:model.live="type" :options="$leaveTypes"
                                            placeholder="Select leave type" class="w-full" />
                                        @error('type')
                                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <!-- Add Duration Display under Date Range -->
                                        @if ($startDate && $endDate)
                                            <div class="mt-2 flex items-center space-x-2 text-sm">
                                                <span class="font-medium text-gray-700">Duration:</span>
                                                <span @class([
                                                    'px-2 py-1 rounded-full text-sm',
                                                    'bg-green-50 text-green-700' =>
                                                        $duration <= $leaveBalance->remaining_balance,
                                                    'bg-red-50 text-red-700' => $duration > $leaveBalance->remaining_balance,
                                                ])>
                                                    {{ $duration }} working days
                                                </span>
                                                <span class="text-gray-500">(Balance:
                                                    {{ $leaveBalance->remaining_balance }}
                                                    days)</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- After the Date Range Picker -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-900 mb-2">Date Range</label>
                                        <div class="mt-2">
                                            <livewire:date-range-picker />
                                        </div>
                                        @error('dates')
                                            <div class="mt-2 flex items-center p-3 text-sm text-red-600 bg-red-50 rounded-lg">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                        @error('startDate')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        @error('endDate')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>


                                </div>

                                <!-- Supporting Documents -->
                                <div class="w-full">
                                    <label class="block text-sm font-medium text-gray-900 mb-2">Supporting
                                        Documents</label>
                                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 transition-all"
                                        x-data="{ dragover: false }" x-on:dragover.prevent="dragover = true"
                                        x-on:dragleave.prevent="dragover = false"
                                        x-on:drop.prevent="dragover = false; $refs.file.files = $event.dataTransfer.files; $refs.file.dispatchEvent(new Event('change'))"
                                        :class="{ 'border-blue-500 bg-blue-50': dragover }">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div class="mt-4">
                                                <label class="relative cursor-pointer">
                                                    <span
                                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">Upload
                                                        a file</span>
                                                    <input id="file-upload" type="file" class="sr-only"
                                                        wire:model.live="attachment" x-ref="file"
                                                        accept=".pdf,.jpg,.jpeg,.png,.docx,.doc">
                                                </label>
                                                <span class="text-sm text-gray-500"> or drag and drop</span>
                                                <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG up to 10MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($attachment)
                                        <div
                                            class="mt-3 flex items-center gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm text-gray-600 flex-1 truncate">{{ $attachment->getClientOriginalName() }}</span>
                                            <button type="button" wire:click="$set('attachment', null)"
                                                class="p-1 hover:bg-gray-100 rounded-full transition-colors">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                    @error('attachment')
                                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Reason -->
                                <div class="w-full">
                                    <label class="block text-sm font-medium text-gray-900 mb-2">Reason for Leave</label>
                                    <div>
                                        <textarea wire:model.live="reason" rows="4"
                                            class="block w-full rounded-lg border-gray-200 resize-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="Please provide a detailed reason for your leave request..."></textarea>
                                        <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                            {{ strlen($reason) }}/500
                                        </div>
                                    </div>
                                    @error('reason')
                                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Form Actions -->
                                <div class="flex justify-end pt-4 border-t border-gray-100">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                        Submit Request
                                        <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Success Message Toast -->
            @if (session()->has('message'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="fixed bottom-4 right-4 flex items-center bg-green-50 rounded-lg p-4 shadow-lg border border-green-100">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('message') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
