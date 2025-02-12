<!-- resources/views/livewire/staff/leave.blade.php -->
<div class="min-h-screen bg-gray-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Leave Management</h2>
                <p class="mt-1 text-sm text-gray-500">Manage and track your leave requests</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button wire:click="$toggle('showLeaveForm')"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Leave Request
                </button>
            </div>
        </div>

        <!-- Leave Balance Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Leave Days</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $leaveBalance->total_balance }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Available Balance</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $leaveBalance->remaining_balance }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Used Leave Days</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $leaveBalance->used_balance }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Requests Section -->
        <div class="bg-white shadow-sm rounded-xl overflow-hidden">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    @php
                        $tabs = [
                            'pending' => ['label' => 'Pending', 'color' => 'yellow'],
                            'approved' => ['label' => 'Approved', 'color' => 'green'],
                            'rejected' => ['label' => 'Rejected', 'color' => 'red'],
                            'cancelled' => ['label' => 'Cancelled', 'color' => 'gray'],
                        ];
                    @endphp

                    @foreach ($tabs as $key => $tab)
                        <button wire:click="$set('activeTab', '{{ $key }}')"
                            class="px-6 py-3 border-b-2 text-sm font-medium {{ $activeTab === $key
                                ? 'border-blue-500 text-blue-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            {{ $tab['label'] }}
                        </button>
                    @endforeach
                </nav>
            </div>

            <!-- Leave Requests List -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($leaveRequests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ ucfirst($request->type) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Cake\Chronos\Chronos::parse($request->start_date)->format('M j, Y') }}
                                        -
                                        {{ \Cake\Chronos\Chronos::parse($request->end_date)->format('M j, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $request->getDurationInDays() }} days
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $request->status_badge }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $request->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($request->canBeCancelled())
                                        <button wire:click="cancelRequest({{ $request->id }})"
                                            class="text-red-600 hover:text-red-900">
                                            Cancel
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No leave requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($showLeaveForm)
        <div class="fixed inset-0 bg-gray-900/50 z-40">
            <div class="mx-auto mt-10 max-w-3xl">
                <div class="bg-white rounded-xl shadow-xl divide-y divide-gray-200">
                    <!-- Modal Header -->
                    <div class="bg-blue-600 p-6 rounded-t-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-white">New Leave Request</h3>
                                <p class="mt-1 text-sm text-blue-100">Fill in the details for your leave application</p>
                            </div>
                            <button wire:click="$toggle('showLeaveForm')" class="text-white hover:text-blue-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Content -->
                    <form wire:submit="submitLeave" class="p-6">
                        @csrf
                        <div class="space-y-6">
                            <!-- Leave Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-900">Leave Type</label>
                                <div class="relative mt-2">
                                    <select wire:model="type"
                                        class="block w-full rounded-lg border-0 py-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600">
                                        <option value="">Select leave type</option>
                                        @foreach ($leaveTypes as $leaveType)
                                            <option value="{{ $leaveType }}">{{ ucfirst($leaveType) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-900">Date Range</label>
                                <div class="mt-2">
                                    <livewire:date-range-picker />
                                </div>
                                @error('startDate')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('endDate')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Supporting Documents -->
                            <div>
                                <label class="block text-sm font-medium text-gray-900">Supporting Documents</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
                                    x-data="{ dragover: false }" x-on:dragover.prevent="dragover = true"
                                    x-on:dragleave.prevent="dragover = false"
                                    x-on:drop.prevent="dragover = false; $refs.file.files = $event.dataTransfer.files; $refs.file.dispatchEvent(new Event('change'))"
                                    :class="{ 'border-blue-500 bg-blue-50': dragover }">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex justify-center text-sm leading-6 text-gray-600">
                                            <label
                                                class="cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500">
                                                <span>Upload a file</span>
                                                <input type="file" class="sr-only" wire:model.live="attachment"
                                                    x-ref="file">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">PDF, JPG, PNG up to 10MB</p>
                                    </div>
                                </div>
                                @error('attachment')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($attachment)
                                <p>{{$attachment}}</p>                                
                            @endif

                            <!-- Reason -->
                            <div>
                                <label class="block text-sm font-medium text-gray-900">Reason for Leave</label>
                                <div class="mt-2">
                                    <textarea wire:model="reason" rows="4"
                                        class="block w-full rounded-lg border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600"
                                        placeholder="Please provide a detailed reason for your leave request..."></textarea>
                                </div>
                                @error('reason')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex items-center justify-end gap-x-4">
                            <button type="button" wire:click="$toggle('showLeaveForm')"
                                class="rounded-lg px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
