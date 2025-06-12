<!-- resources/views/livewire/hr/leave.blade.php -->
<div class="min-h-screen py-8 space-y-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-5">
            <!-- Pending Requests Card -->
            <div class="bg-white/95 backdrop-blur-sm overflow-hidden shadow-sm rounded-xl">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 rounded-xl bg-yellow-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pending Requests
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $this->pendingCount }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 px-5 py-3">
                    <div class="text-sm">
                        <button wire:click="$set('activeTab', 'pending')"
                            class="font-medium text-yellow-700 hover:text-yellow-900">
                            View all pending
                        </button>
                    </div>
                </div>
            </div>

            <!-- Approved Requests Card -->
            <div class="bg-white/95 backdrop-blur-sm overflow-hidden shadow-sm rounded-xl">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Approved Requests
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $this->approvedCount }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 px-5 py-3">
                    <div class="text-sm">
                        <button wire:click="$set('activeTab', 'approved')"
                            class="font-medium text-green-700 hover:text-green-900">
                            View approved
                        </button>
                    </div>
                </div>
            </div>

            <!-- Rejected Requests Card -->
            <div class="bg-white/95 backdrop-blur-sm overflow-hidden shadow-sm rounded-xl">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 rounded-xl bg-red-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Rejected Requests
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $this->rejectedCount }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 px-5 py-3">
                    <div class="text-sm">
                        <button wire:click="$set('activeTab', 'rejected')"
                            class="font-medium text-red-700 hover:text-red-900">
                            View rejected
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6 overflow-x-auto" aria-label="Tabs">
                    <button wire:click="$set('activeTab', 'pending')"
                        class="inline-flex items-center py-4 px-1 gap-2 border-b-2 whitespace-nowrap font-medium text-sm transition-colors duration-200
                        {{ $activeTab === 'pending' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div @class([
                            'w-8 h-8 rounded-lg flex items-center justify-center',
                            'bg-yellow-50' => $activeTab === 'pending',
                            'bg-gray-50' => $activeTab !== 'pending',
                        ])>
                            <svg class="w-5 h-5 {{ $activeTab === 'pending' ? 'text-yellow-600' : 'text-gray-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Pending
                        @if ($this->pendingCount > 0)
                            <span
                                class="ml-1 px-2.5 py-0.5 bg-yellow-50 text-yellow-700 text-xs font-medium rounded-full">
                                {{ $this->pendingCount }}
                            </span>
                        @endif
                    </button>

                    <button wire:click="$set('activeTab', 'approved')"
                        class="inline-flex items-center py-4 px-1 gap-2 border-b-2 whitespace-nowrap font-medium text-sm transition-colors duration-200
                        {{ $activeTab === 'approved' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div @class([
                            'w-8 h-8 rounded-lg flex items-center justify-center',
                            'bg-green-50' => $activeTab === 'approved',
                            'bg-gray-50' => $activeTab !== 'approved',
                        ])>
                            <svg class="w-5 h-5 {{ $activeTab === 'approved' ? 'text-green-600' : 'text-gray-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Approved
                        @if ($this->approvedCount > 0)
                            <span
                                class="ml-1 px-2.5 py-0.5 bg-green-50 text-green-700 text-xs font-medium rounded-full">
                                {{ $this->approvedCount }}
                            </span>
                        @endif
                    </button>

                    <button wire:click="$set('activeTab', 'rejected')"
                        class="inline-flex items-center py-4 px-1 gap-2 border-b-2 whitespace-nowrap font-medium text-sm transition-colors duration-200
                        {{ $activeTab === 'rejected' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div @class([
                            'w-8 h-8 rounded-lg flex items-center justify-center',
                            'bg-red-50' => $activeTab === 'rejected',
                            'bg-gray-50' => $activeTab !== 'rejected',
                        ])>
                            <svg class="w-5 h-5 {{ $activeTab === 'rejected' ? 'text-red-600' : 'text-gray-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Rejected
                        @if ($this->rejectedCount > 0)
                            <span class="ml-1 px-2.5 py-0.5 bg-red-50 text-red-700 text-xs font-medium rounded-full">
                                {{ $this->rejectedCount }}
                            </span>
                        @endif
                    </button>
                </nav>
            </div>

            <!-- Request List -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Leave Details
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Manager Approval
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($leaveRequests as $request)
                            <tr class="hover:bg-gray-50/50">
                                <!-- Employee -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center max-w-md">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ asset($request->user->image ?? 'images/users/user.png') }}"
                                                alt="{{ $request->user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $request->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $request->user->department->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Leave Details -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div @class([
                                            'flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center',
                                            'bg-orange-50 text-orange-600' => $request->type === 'sick',
                                            'bg-blue-50 text-blue-600' => $request->type === 'annual',
                                            'bg-purple-50 text-purple-600' => $request->type === 'important',
                                            'bg-gray-50 text-gray-600' => $request->type === 'other',
                                        ])>
                                            @switch($request->type)
                                                @case('sick')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @break

                                                @case('annual')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                @break

                                                @case('important')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                @break

                                                @default
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                            @endswitch
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ ucfirst($request->type) }} Leave
                                            </p>
                                            <div class="text-sm text-gray-500 mt-1">
                                                <span class="line-clamp-2" title="{{ $request->reason }}">
                                                    {{ $request->reason }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Duration -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M j, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M j, Y') }}
                                        <span class="text-xs">({{ $request->getDurationInDays() }} days)</span>
                                    </div>
                                </td>

                                <!-- Manager Approval -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-700">
                                            {{ $request->manager->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-gray-500">
                                            @if ($request->manager_approved_at)
                                                {{ $request->manager_approved_at->format('M j, Y H:i') }}
                                            @else
                                                Not approved yet
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($request->attachment_path)
                                        <button wire:click="previewAttachment({{ $request->id }})"
                                            class="mb-2 inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-lg 
                                            text-gray-600 bg-gray-50 hover:bg-gray-100 transition-colors">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            View Attachment
                                        </button>
                                    @endif
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-700">
                                            Balance: {{ $request->user->currentLeaveBalance?->remaining_balance ?? 0 }}
                                            days
                                        </div>
                                        <div class="text-gray-500">
                                            Used: {{ $request->user->currentLeaveBalance?->used_balance ?? 0 }} days
                                        </div>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($activeTab === 'pending')
                                            <button wire:click="openSignatureModal({{ $request->id }})"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>

                                            <button wire:click="showModalReject({{ $request->id }})" type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-lg flex items-center justify-center mb-4">
                                                @switch($activeTab)
                                                    @case('pending')
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @break

                                                    @case('approved')
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @break

                                                    @case('rejected')
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @break
                                                @endswitch
                                            </div>
                                            <h3 class="text-sm font-medium text-gray-900 mb-1">No {{ $activeTab }}
                                                requests</h3>
                                            <p class="text-sm text-gray-500">
                                                @if ($activeTab === 'pending')
                                                    There are no pending leave requests to review at this time.
                                                @elseif($activeTab === 'approved')
                                                    No approved leave requests found.
                                                @else
                                                    No rejected leave requests found.
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modals -->
            <div>
                <!-- Preview Modal -->
                <x-modals.preview-modal :show="$showPreview" :preview-url="$previewUrl" :preview-type="$previewType" />

                <!-- Signature Modal -->
                <x-modals.modal name="signature-modal" maxWidth="md">
                    <div x-data="signaturePad()">
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">Sign to Approve Leave Request</h3>
                            <button @click="$dispatch('close-modal', 'signature-modal')"
                                class="text-gray-500 hover:text-gray-700">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-6">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Please sign below to approve this leave request.</p>
                                <p class="text-sm text-gray-600 mt-1">After your approval, this request will be sent to the
                                    Director for final review.</p>
                            </div>

                            <div
                                class="border border-gray-300 rounded-lg shadow-sm overflow-hidden bg-white w-full mx-auto">
                                <canvas x-ref="signature_canvas" class="w-full h-64"></canvas>
                            </div>

                            <div x-show="signatureError" class="mt-2 text-sm text-red-600" x-text="signatureError"></div>

                            <div class="mt-4 flex justify-between">
                                <button @click="clearSignature()"
                                    class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="inline-block mr-1 h-4 w-4 text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Clear
                                </button>
                                <div>
                                    <button @click="$dispatch('close-modal', 'signature-modal')"
                                        class="inline-flex justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                                        Cancel
                                    </button>
                                    <button @click="upload()" :disabled="signatureSubmitting"
                                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 disabled:opacity-75 disabled:cursor-not-allowed">
                                        <span x-show="signatureSubmitting" class="inline-block mr-2">
                                            <svg class="animate-spin h-4 w-4 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </span>
                                        Approve Request
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-modals.modal>

                <!-- Reject Modal -->
                @if ($showRejectModal)
                    <div class="fixed inset-0 bg-black/25 backdrop-blur-sm z-50 flex items-center justify-center p-4"
                        x-data @keydown.escape.window="$wire.closeRejectModal()">

                        <!-- Modal Panel -->
                        <div class="bg-white rounded-xl shadow-xl max-w-lg w-full overflow-hidden" x-show="true"
                            x-transition:enter="transform transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="transform transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        Reject Leave Request
                                    </h3>
                                    <button type="button" wire:click="closeRejectModal"
                                        class="text-gray-400 hover:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                @if ($selectedRequest)
                                    <!-- Request Summary -->
                                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                        <div class="text-sm text-gray-600 space-y-2">
                                            <p><span class="font-medium">Employee:</span>
                                                {{ $selectedRequest->user->name }}</p>
                                            <p><span class="font-medium">Department:</span>
                                                {{ $selectedRequest->user->department->name }}</p>
                                            <p><span class="font-medium">Leave Type:</span>
                                                {{ ucfirst($selectedRequest->type) }}</p>
                                            <p><span class="font-medium">Duration:</span>
                                                {{ $selectedRequest->start_date->format('M j, Y') }} -
                                                {{ $selectedRequest->end_date->format('M j, Y') }}
                                                ({{ $selectedRequest->getDurationInDays() }} days)
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <div class="space-y-4">
                                    <div>
                                        <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-1">
                                            Reason for Rejection
                                        </label>
                                        <textarea id="rejectReason" wire:model="rejectReason" rows="4"
                                            placeholder="Please provide a reason for rejecting this leave request..."
                                            class="block w-full rounded-lg shadow-sm border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                                        @error('rejectReason')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                                <button type="button" wire:click="closeRejectModal"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                    Cancel
                                </button>
                                <button type="button" wire:click="rejectRequest"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    Reject Request
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Success Message Toast -->
            @if (session()->has('message'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="fixed bottom-4 right-4 z-50 flex items-center px-4 py-3 rounded-lg border"
                    :class="{
                        'bg-green-50 border-green-100': '{{ session('type', 'success') }}'
                        === 'success',
                        'bg-red-50 border-red-100': '{{ session('type', 'success') }}'
                        === 'error'
                    }">
                    <div class="flex-shrink-0">
                        @if (session('type', 'success') === 'success')
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium"
                            :class="{
                                'text-green-800': '{{ session('type', 'success') }}'
                                === 'success',
                                'text-red-800': '{{ session('type', 'success') }}'
                                === 'error'
                            }">
                            {{ session('message') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                signaturePadInstance: null,
                signatureError: '',
                signatureSubmitting: false,

                init() {
                    this.$nextTick(() => {
                        this.initSignaturePad();
                        document.addEventListener('open-modal', (event) => {
                            if (event.detail === 'signature-modal') {
                                setTimeout(() => {
                                    this.initSignaturePad();
                                }, 100);
                            }
                        });
                    });
                },

                initSignaturePad() {
                    const canvas = this.$refs.signature_canvas;
                    if (!canvas) return;

                    if (this.signaturePadInstance) this.signaturePadInstance.off();

                    this.signaturePadInstance = new SignaturePad(canvas, {
                        penColor: 'rgb(0, 0, 128)'
                    });

                    // Set canvas dimensions to match the container
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);
                },

                clearSignature() {
                    if (this.signaturePadInstance) this.signaturePadInstance.clear();
                    this.signatureError = '';
                },

                upload() {
                    if (this.signaturePadInstance && !this.signaturePadInstance.isEmpty()) {
                        try {
                            this.signatureError = '';
                            this.signatureSubmitting = true;

                            const data = this.signaturePadInstance.toDataURL('image/png');

                            // Send signature data to Livewire component
                            @this.set('signature', data);
                            @this.saveSignatureAndApprove().then(() => {
                                this.$dispatch('close-modal', 'signature-modal');
                            }).catch(error => {
                                console.error('Error during approval:', error);
                                this.signatureError =
                                    'Failed to approve leave request. Please try again.';
                            }).finally(() => {
                                this.signatureSubmitting = false;
                            });

                        } catch (error) {
                            this.signatureError = 'Failed to process signature. Please try again.';
                            this.signatureSubmitting = false;
                        }
                    } else {
                        this.signatureError = 'Please sign before approving';
                    }
                }
            }));
        });
    </script>
