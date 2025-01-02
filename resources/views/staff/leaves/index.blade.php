{{-- resources/views/staff/leaves/index.blade.php --}}
<x-layouts.staff>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header Section --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Leave Management</h2>
                <button @click="$dispatch('open-modal', 'create-leave')"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Leave Request
                </button>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Leave Balance Widget --}}
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Leave Balance ({{ now()->year }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 p-4 rounded-md">
                            <p class="text-sm font-medium text-green-800">Total Balance</p>
                            <p class="mt-2 text-3xl font-semibold text-green-900">{{ $currentBalance->total_balance }}
                            </p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-md">
                            <p class="text-sm font-medium text-blue-800">Used</p>
                            <p class="mt-2 text-3xl font-semibold text-blue-900">{{ $currentBalance->used_balance }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-md">
                            <p class="text-sm font-medium text-purple-800">Remaining</p>
                            <p class="mt-2 text-3xl font-semibold text-purple-900">
                                {{ $currentBalance->remaining_balance }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Requests Table --}}
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Leave Requests</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dates</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $request['type'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">{{ $request['dates'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $request['status'] === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $request['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $request['status'] === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $request['status'] === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ ucfirst($request['status']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                                            <button @click="$dispatch('open-modal', 'view-leave-{{ $request['id'] }}')"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                View
                                            </button>

                                            <button
                                                @click="$dispatch('open-modal', 'cancel-leave-{{ $request['id'] }}')"
                                                class="text-red-600 hover:text-red-900 disabled:opacity-50 disabled:cursor-not-allowed"
                                                {{ $request['status'] !== 'pending' ? 'disabled' : '' }}
                                                title="{{ $request['status'] !== 'pending' ? 'Only pending requests can be cancelled' : 'Cancel this request' }}">
                                                Cancel
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No recent leave requests found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Leave Request Modal --}}
    <x-modals.modal name="create-leave" maxWidth="lg">
        <form method="POST" action="{{ route('staff.leave.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 mb-4">New Leave Request</h2>

            {{-- Leave Type --}}
            <div class="mb-4">
                <x-shared.label for="type" value="Leave Type" />
                <x-input.dropdown name="type" label="Select Leave Type" :options="[
                    ['value' => 'annual', 'label' => 'Annual Leave'],
                    ['value' => 'sick', 'label' => 'Sick Leave'],
                    ['value' => 'important', 'label' => 'Important Business'],
                    ['value' => 'other', 'label' => 'Other'],
                ]" />
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Duration Type --}}
            <div class="mb-4" x-data="{ durationType: 'full_day' }">
                <x-shared.label for="duration_type" value="Duration" />
                <x-input.dropdown name="duration_type" label="Select Duration" :options="[
                    ['value' => 'full_day', 'label' => 'Full Day'],
                    ['value' => 'first_half', 'label' => 'First Half (Morning)'],
                    ['value' => 'second_half', 'label' => 'Second Half (Afternoon)'],
                ]"
                    x-model="durationType" />
                @error('duration_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-shared.label for="start_date" value="Start Date" />
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required />
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div x-show="durationType === 'full_day'">
                    <x-shared.label for="end_date" value="End Date" />
                    <input type="date" name="end_date" id="end_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        x-bind:required="durationType === 'full_day'" />
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Reason --}}
            <div class="mt-4">
                <x-shared.label for="reason" value="Reason" />
                <textarea name="reason" id="reason" rows="3"
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required></textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Attachment --}}
            <div class="mt-4">
                <x-shared.label for="attachment" value="Attachment (optional)" />
                <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    class="block mt-1 w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-medium
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100" />
                <p class="mt-1 text-xs text-gray-500">Accepted file types: PDF, DOC, DOCX, JPG, JPEG, PNG (max 2MB)</p>
                @error('attachment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="mt-6 flex justify-end">
                <button type="button" @click="$dispatch('close')"
                    class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                    Submit Request
                </button>
            </div>
        </form>
    </x-modals.modal>

    {{-- View/Cancel Modals for each request --}}
    @foreach ($recentRequests as $request)
        {{-- View Modal --}}
        <x-modals.modal name="view-leave-{{ $request['id'] }}" maxWidth="md">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Leave Request Details</h2>
                <dl class="grid grid-cols-1 gap<dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $request['type'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dates</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $request['dates'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Duration Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if ($request['duration_type'] === 'full_day')
                                Full Day
                            @elseif($request['duration_type'] === 'first_half')
                                First Half (Morning)
                            @else
                                Second Half (Afternoon)
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $request['status'] === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $request['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $request['status'] === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $request['status'] === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($request['status']) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Reason</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $request['reason'] }}</dd>
                    </div>
                    @if ($request['attachment_path'])
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Attachment</dt>
                            <dd class="mt-1">
                                <a href="{{ Storage::url($request['attachment_path']) }}" target="_blank"
                                    class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download Attachment
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
                <div class="mt-6 flex justify-end">
                    <button type="button" @click="$dispatch('close')"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200">
                        Close
                    </button>
                </div>
            </div>
        </x-modals.modal>

        {{-- Cancel Modal --}}
        @if ($request['can_cancel'])
            <x-modals.modal name="cancel-leave-{{ $request['id'] }}" maxWidth="sm">
                @php
                    $cancelRoute = route('staff.leave.cancel', ['leaveRequest' => $request['id']]);
                    \Log::info('Cancel route generated:', ['route' => $cancelRoute]);
                @endphp
                <form method="POST" action="{{ route('staff.leave.cancel', ['leaveRequest' => $request['id']]) }}"
                    class="p-6">
                    @csrf
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Cancel Leave Request</h2>
                    <p class="mb-4 text-sm text-gray-600">
                        Are you sure you want to cancel this leave request? This action cannot be undone.
                    </p>

                    {{-- Show leave details for confirmation --}}
                    <div class="mb-4 bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 gap-2">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Type:</span>
                                <span class="ml-2 text-sm text-gray-900">{{ $request['type'] }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Dates:</span>
                                <span class="ml-2 text-sm text-gray-900">{{ $request['dates'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" @click="$dispatch('close')"
                            class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            No, Keep It
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                            Yes, Cancel Leave
                        </button>
                    </div>
                </form>
            </x-modals.modal>
        @endif
    @endforeach
</x-layouts.staff>
