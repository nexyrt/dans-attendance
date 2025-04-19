<!-- resources/views/livewire/manager/leave-approval.blade.php -->
<div class="max-w-7xl mx-auto py-6 px-4">
    <!-- Include the Flash Message Component -->
    <x-shared.flash-message />

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Leave Approval Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">Manage leave requests from staff in your department</p>
        </div>

        <!-- Summary Stats -->
        <div class="flex mt-4 md:mt-0 space-x-3 overflow-x-auto">
            <div class="bg-white shadow rounded-lg px-4 py-2 flex items-center w-auto min-w-[140px]">
                <div class="bg-yellow-100 p-2 rounded-full mr-3">
                    <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Pending</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $leaveRequests->where('status', 'pending_manager')->count() }}
                    </p>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg px-4 py-2 flex items-center w-auto min-w-[140px]">
                <div class="bg-blue-100 p-2 rounded-full mr-3">
                    <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">With HR</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $leaveRequests->where('status', 'pending_hr')->count() }}
                    </p>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg px-4 py-2 flex items-center w-auto min-w-[140px]">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Approved</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $leaveRequests->where('status', 'approved')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="md:px-6 md:py-4 border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h2 class="text-lg font-medium text-gray-900">Filters</h2>
        </div>
        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="searchTerm" class="block text-sm font-medium text-gray-700 mb-1">Search Staff</label>
                    <div class="relative">
                        <input type="text" id="searchTerm" wire:model.live.debounce.300ms="searchTerm"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Name or email">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" wire:model.live="status"
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <option value="">All Statuses</option>
                        <option value="pending_manager">Pending Approval</option>
                        <option value="pending_hr">Pending HR</option>
                        <option value="pending_director">Pending Director</option>
                        <option value="approved">Approved</option>
                        <option value="rejected_manager">Rejected by Manager</option>
                        <option value="rejected_hr">Rejected by HR</option>
                        <option value="rejected_director">Rejected by Director</option>
                        <option value="cancel">Cancelled</option>
                    </select>
                </div>

                <!-- Date Range Picker (simplified) -->
                <div>
                    <label for="dateRange" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <input type="text" id="dateRange" wire:model.live="dateRange"
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="YYYY-MM-DD to YYYY-MM-DD">
                </div>

                <!-- Reset Button -->
                <div class="flex items-end">
                    <button wire:click="resetFilters" type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="md:px-6 md:py-4 border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h2 class="text-lg font-medium text-gray-900">Leave Requests</h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if (count($leaveRequests) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Staff
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Leave Type
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Period
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration
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
                        @foreach ($leaveRequests as $request)
                            @php
                                // Calculate working days
                                $leaveStart = \Carbon\Carbon::parse($request->start_date);
                                $leaveEnd = \Carbon\Carbon::parse($request->end_date);
                                $workDays = 0;

                                for ($date = $leaveStart->copy(); $date->lte($leaveEnd); $date->addDay()) {
                                    if (!in_array($date->dayOfWeek, [0, 6])) {
                                        $workDays++;
                                    }
                                }

                                // Status classes
                                $statusInfo = [
                                    'pending_manager' => [
                                        'bg' => 'bg-yellow-100',
                                        'text' => 'text-yellow-800',
                                        'label' => 'Pending Approval',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'pending_hr' => [
                                        'bg' => 'bg-blue-100',
                                        'text' => 'text-blue-800',
                                        'label' => 'Pending HR',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'pending_director' => [
                                        'bg' => 'bg-purple-100',
                                        'text' => 'text-purple-800',
                                        'label' => 'Pending Director',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'approved' => [
                                        'bg' => 'bg-green-100',
                                        'text' => 'text-green-800',
                                        'label' => 'Approved',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'rejected_manager' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-800',
                                        'label' => 'Rejected by Manager',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'rejected_hr' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-800',
                                        'label' => 'Rejected by HR',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'rejected_director' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-800',
                                        'label' => 'Rejected by Director',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    ],
                                    'cancel' => [
                                        'bg' => 'bg-gray-100',
                                        'text' => 'text-gray-800',
                                        'label' => 'Cancelled',
                                        'icon' =>
                                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />',
                                    ],
                                ];

                                $typeColors = [
                                    'annual' => [
                                        'bg' => 'bg-blue-100',
                                        'text' => 'text-blue-600',
                                        'label' => 'Annual',
                                    ],
                                    'sick' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-600',
                                        'label' => 'Sick',
                                    ],
                                    'important' => [
                                        'bg' => 'bg-purple-100',
                                        'text' => 'text-purple-600',
                                        'label' => 'Important',
                                    ],
                                    'other' => [
                                        'bg' => 'bg-gray-100',
                                        'text' => 'text-gray-600',
                                        'label' => 'Other',
                                    ],
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <!-- Staff -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($request->user->image)
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ Storage::url($request->user->image) }}"
                                                    alt="{{ $request->user->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span
                                                        class="text-gray-500 font-medium">{{ substr($request->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $request->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Leave Type -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeColors[$request->type]['bg'] }} {{ $typeColors[$request->type]['text'] }}">
                                        {{ $typeColors[$request->type]['label'] }}
                                    </span>
                                </td>

                                <!-- Period -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        to {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                    </div>
                                </td>

                                <!-- Duration -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $workDays }} {{ Str::plural('day', $workDays) }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusInfo[$request->status]['bg'] }} {{ $statusInfo[$request->status]['text'] }}">
                                        <svg class="mr-1 h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $statusInfo[$request->status]['icon'] !!}
                                        </svg>
                                        {{ $statusInfo[$request->status]['label'] }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        @if ($request->status === 'pending_manager')
                                            <button wire:click="openApprovalModal({{ $request->id }})"
                                                class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 rounde<!-- Continuation of resources/views/livewire/manager/leave-approval.blade.php -->
                                            <button wire:click="openApprovalModal({{ $request->id }})"
                                                class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 rounded px-2 py-1 transition-colors duration-200 flex items-center">
                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>
                                            <button wire:click="openRejectionModal({{ $request->id }})"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 rounded px-2 py-1 transition-colors duration-200 flex items-center">
                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        @endif
                                        <!-- View Details Button -->
                                        <button wire:click="generatePdf({{ $request->id }})"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 rounded px-2 py-1 transition-colors duration-200 flex items-center">
                                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            PDF
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $leaveRequests->links() }}
                </div>
            @else
                <div class="py-12 flex flex-col items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-base font-medium text-gray-900">No leave requests found</h3>
                    <p class="text-sm text-gray-500 mb-4">No leave requests match your current filters</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Approval Modal -->
    <x-modals.modal name="approval-modal" max-width="md" wire:model="isModalOpen">
        <div x-data="signaturePad()">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ $actionType === 'approve' ? 'Approve Leave Request' : 'Reject Leave Request' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                @if ($actionType === 'approve')
                    <!-- Approval Form -->
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Please sign below to approve this leave request.</p>
                        <p class="text-sm text-gray-600 mt-1">After your approval, this request will be sent to HR for
                            further review.</p>
                    </div>

                    <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden bg-white w-full mx-auto">
                        <canvas x-ref="signature_canvas" class="w-full h-64"></canvas>
                    </div>

                    <div class="mt-4 flex justify-between">
                        <button @click="clearSignature()"
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="inline-block mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd" />
                            </svg>
                            Clear Signature
                        </button>
                        <div>
                            <button wire:click="closeModal"
                                class="inline-flex justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                                Cancel
                            </button>
                            <button @click="upload()"
                                class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                Approve Request
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Rejection Form -->
                    <div class="mb-4">
                        <label for="rejectionReason" class="block text-sm font-medium text-gray-700">
                            Reason for Rejection
                        </label>
                        <p class="text-sm text-gray-500 mb-2">Please provide a detailed explanation for rejecting this
                            leave request.</p>
                        <textarea id="rejectionReason" wire:model="rejectionReason" rows="4"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Enter reason for rejection"></textarea>
                        @error('rejectionReason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button wire:click="closeModal"
                            class="inline-flex justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                            Cancel
                        </button>
                        <button wire:click="rejectLeave"
                            class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                            Reject Request
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </x-modals.modal>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                signaturePadInstance: null,

                init() {
                    this.$nextTick(() => {
                        this.initSignaturePad();
                    });

                    // Listen for modal open/close events to properly initialize
                    Livewire.on('modalOpened', () => {
                        setTimeout(() => {
                            this.initSignaturePad();
                        }, 100);
                    });
                },

                initSignaturePad() {
                    const canvas = this.$refs.signature_canvas;
                    if (!canvas) return;

                    // Clean up previous instance if it exists
                    if (this.signaturePadInstance) {
                        this.signaturePadInstance.off();
                    }

                    // Set canvas dimensions to match the container
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);

                    // Initialize signature pad
                    this.signaturePadInstance = new SignaturePad(canvas, {
                        penColor: 'rgb(0, 0, 128)',
                        backgroundColor: 'rgb(255, 255, 255)'
                    });
                },

                clearSignature() {
                    if (this.signaturePadInstance) {
                        this.signaturePadInstance.clear();
                    }
                },

                upload() {
                    if (this.signaturePadInstance && !this.signaturePadInstance.isEmpty()) {
                        const data = this.signaturePadInstance.toDataURL('image/png');
                        @this.set('signature', data);
                        @this.call('approveLeave');
                    } else {
                        alert('Please sign before approving');
                    }
                }
            }));
        });
    </script>
</div>
