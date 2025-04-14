<!-- resources/views/livewire/staff/leave.blade.php -->
<div class="max-w-7xl mx-auto" x-data="{
    activeTab: 'apply',
    showSuccess: {{ session()->has('success') ? 'true' : 'false' }},
    showError: {{ session()->has('error') ? 'true' : 'false' }},
    successMessage: '{{ session('success') }}',
    errorMessage: '{{ session('error') }}',
    setActiveTab(tab) {
        this.activeTab = tab;
        @this.set('activeTab', tab);
    },
    closeAlert(type) {
        if (type === 'success') this.showSuccess = false;
        if (type === 'error') this.showError = false;
    }
}">
    <!-- Success Alert -->
    <div x-show="showSuccess" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800" x-text="successMessage"></p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="closeAlert('success')"
                        class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Alert -->
    <div x-show="showError" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800" x-text="errorMessage"></p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="closeAlert('error')"
                        class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6">
        <nav class="flex space-x-4 bg-white rounded-lg p-1.5 shadow-sm">
            <button @click="setActiveTab('apply')"
                :class="{ 'bg-blue-600 text-white': activeTab === 'apply', 'text-gray-700 hover:text-gray-900 hover:bg-gray-100': activeTab !== 'apply' }"
                class="flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-all duration-200">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Apply for Leave
            </button>
            <button @click="setActiveTab('history')"
                :class="{ 'bg-blue-600 text-white': activeTab === 'history', 'text-gray-700 hover:text-gray-900 hover:bg-gray-100': activeTab !== 'history' }"
                class="flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-all duration-200">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Leave History
            </button>
            <button @click="setActiveTab('balance')"
                :class="{ 'bg-blue-600 text-white': activeTab === 'balance', 'text-gray-700 hover:text-gray-900 hover:bg-gray-100': activeTab !== 'balance' }"
                class="flex items-center px-4 py-2.5 text-sm font-medium rounded-md transition-all duration-200">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Leave Balance
            </button>
        </nav>
    </div>

    <!-- Apply for Leave Tab -->
    <div x-show="activeTab === 'apply'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Apply for Leave</h2>
            <p class="mt-1 text-sm text-gray-500">Fill in the details to submit your leave request</p>
        </div>

        <div class="p-6">
            <form wire:submit="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                    <!-- Leave Type -->
                    <div x-data="{ open: false, selectedType: @entangle('type') }" class="relative">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full bg-white border border-gray-300 rounded-md py-2.5 pl-3 pr-10 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                <span class="block truncate capitalize">{{ ucfirst($type) }} Leave</span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto max-h-60 focus:outline-none sm:text-sm">
                                <div @click="selectedType = 'annual'; open = false"
                                    :class="{ 'bg-blue-100 text-blue-900': selectedType === 'annual' }"
                                    class="cursor-pointer select-none relative py-2.5 pl-10 pr-4 hover:bg-gray-100">
                                    <span :class="{ 'font-medium': selectedType === 'annual' }"
                                        class="block truncate">Annual Leave</span>
                                    <span x-show="selectedType === 'annual'"
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div @click="selectedType = 'sick'; open = false"
                                    :class="{ 'bg-blue-100 text-blue-900': selectedType === 'sick' }"
                                    class="cursor-pointer select-none relative py-2.5 pl-10 pr-4 hover:bg-gray-100">
                                    <span :class="{ 'font-medium': selectedType === 'sick' }"
                                        class="block truncate">Sick Leave</span>
                                    <span x-show="selectedType === 'sick'"
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div @click="selectedType = 'important'; open = false"
                                    :class="{ 'bg-blue-100 text-blue-900': selectedType === 'important' }"
                                    class="cursor-pointer select-none relative py-2.5 pl-10 pr-4 hover:bg-gray-100">
                                    <span :class="{ 'font-medium': selectedType === 'important' }"
                                        class="block truncate">Important Leave</span>
                                    <span x-show="selectedType === 'important'"
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div @click="selectedType = 'other'; open = false"
                                    :class="{ 'bg-blue-100 text-blue-900': selectedType === 'other' }"
                                    class="cursor-pointer select-none relative py-2.5 pl-10 pr-4 hover:bg-gray-100">
                                    <span :class="{ 'font-medium': selectedType === 'other' }"
                                        class="block truncate">Other</span>
                                    <span x-show="selectedType === 'other'"
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Replace the Start Date and End Date fields in your leave form with this -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Leave Duration</label>
                        <livewire:date-range-picker :start-date="$start_date" :end-date="$end_date" wire:key="leave-date-picker" />
                        @error('start_date')
                            <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                        @enderror
                        @error('end_date')
                            <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                        @enderror

                        <!-- Calculated Days (keep this part) -->
                        <div class="mt-2 bg-gray-100 p-2 rounded-md">
                            <span class="text-sm text-gray-700">Duration: <span
                                    class="font-medium">{{ $calculatedDays }}
                                    {{ Str::plural('day', $calculatedDays) }}</span></span>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="md:col-span-2" x-data="{ charCount: 0, maxChars: 500 }">
                        <label for="reason"
                            class="flex justify-between items-center text-sm font-medium text-gray-700 mb-1">
                            <span>Reason for Leave</span>
                            <span x-text="`${charCount}/${maxChars}`"
                                :class="{ 'text-red-500': charCount > maxChars, 'text-gray-500': charCount <= maxChars }"
                                class="text-xs"></span>
                        </label>
                        <textarea id="reason" wire:model="reason" rows="4" x-on:input="charCount = $event.target.value.length"
                            :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': charCount > maxChars }"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            placeholder="Please provide a detailed reason for your leave request"></textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attachment - Fixed Version -->
                    <div x-data="{ fileName: null }">
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">
                            Attachment (Optional)
                        </label>
                        <div class="mt-1 flex items-center">
                            <span class="inline-block h-12 w-12 rounded-md overflow-hidden bg-gray-100">
                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M6 2a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6H6zm7 1.5L18.5 9H13V3.5z" />
                                </svg>
                            </span>
                            <div class="ml-4 flex-1">
                                <label for="attachment" class="cursor-pointer flex items-center">
                                    <span
                                        class="py-2 px-3 bg-white border border-gray-300 rounded-md inline-block w-full">
                                        <span x-text="fileName ? fileName : 'Choose file...'"
                                            class="text-gray-500 text-sm"></span>
                                    </span>
                                    <input type="file" id="attachment" wire:model="attachment"
                                        @change="fileName = $event.target.files[0]?.name || 'No file selected'"
                                        class="sr-only">
                                </label>
                                <p class="mt-1 text-xs text-gray-500">
                                    Upload supporting documents (PDF, DOC, DOCX, JPG, PNG)
                                </p>
                            </div>
                        </div>
                        @error('attachment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Signature -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                        <div class="mt-1 border-2 border-dashed border-gray-300 rounded-md p-4 bg-gray-50">
                            @if ($signature)
                                <div class="mb-3">
                                    <img src="{{ $signature }}" alt="Your signature"
                                        class="border rounded h-20 bg-white shadow-sm mx-auto">
                                </div>
                            @else
                                <div class="space-y-1 text-center mb-3">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <p class="text-sm text-gray-500">A signature is required to process your leave
                                        request</p>
                                </div>
                            @endif

                            <div class="flex justify-center">
                                <button type="button" @click="$dispatch('open-modal', 'signature-modal')"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    {{ $signature ? 'Change Signature' : 'Add Signature' }}
                                </button>
                            </div>
                        </div>
                        @error('signature')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button" @click="setActiveTab('history')"
                        class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Submit Leave Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leave History Tab -->
    <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Leave History</h2>
            <p class="mt-1 text-sm text-gray-500">Review your past and pending leave requests</p>
        </div>

        @if (count($leaveRequests) > 0)
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
                                Days</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($leaveRequests as $request)
                            <tr x-data="{ showActions: false }">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div @class([
                                            'flex-shrink-0 h-10 w-10 rounded-md flex items-center justify-center',
                                            'bg-blue-100' => $request->type === 'annual',
                                            'bg-red-100' => $request->type === 'sick',
                                            'bg-purple-100' => $request->type === 'important',
                                            'bg-gray-100' => $request->type === 'other',
                                        ])>
                                            <svg @class([
                                                'h-6 w-6',
                                                'text-blue-600' => $request->type === 'annual',
                                                'text-red-600' => $request->type === 'sick',
                                                'text-purple-600' => $request->type === 'important',
                                                'text-gray-600' => $request->type === 'other',
                                            ]) xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 capitalize">
                                                {{ $request->type }} Leave</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $request->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}</div>
                                    @if ($request->start_date != $request->end_date)
                                        <div class="text-sm text-gray-500">to
                                            {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1 }}
                                        days</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'pending_manager' => 'bg-yellow-100 text-yellow-800',
                                            'pending_hr' => 'bg-blue-100 text-blue-800',
                                            'pending_director' => 'bg-purple-100 text-purple-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected_manager' => 'bg-red-100 text-red-800',
                                            'rejected_hr' => 'bg-red-100 text-red-800',
                                            'rejected_director' => 'bg-red-100 text-red-800',
                                            'cancel' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $statusIcons = [
                                            'pending_manager' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'pending_hr' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'pending_director' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'approved' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'rejected_manager' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'rejected_hr' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'rejected_director' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'cancel' =>
                                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />',
                                        ];
                                        $statusText = [
                                            'pending_manager' => 'Pending Manager',
                                            'pending_hr' => 'Pending HR',
                                            'pending_director' => 'Pending Director',
                                            'approved' => 'Approved',
                                            'rejected_manager' => 'Rejected by Manager',
                                            'rejected_hr' => 'Rejected by HR',
                                            'rejected_director' => 'Rejected by Director',
                                            'cancel' => 'Cancelled',
                                        ];
                                    @endphp
                                    <div class="flex items-center">
                                        <div @class([
                                            'px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full',
                                            $statusClasses[$request->status],
                                        ])>
                                            <svg class="-ml-0.5 mr-1.5 h-3 w-3" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                {!! $statusIcons[$request->status] !!}
                                            </svg>
                                            {{ $statusText[$request->status] }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative"
                                    @mouseenter="showActions = true" @mouseleave="showActions = false">
                                    <div x-show="showActions || window.innerWidth < 640"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100" class="inline-flex">
                                        @if (in_array($request->status, ['pending_manager', 'pending_hr', 'pending_director']))
                                            <button wire:click="cancelLeaveRequest({{ $request->id }})"
                                                onclick="return confirm('Are you sure you want to cancel this leave request?')"
                                                class="text-red-600 hover:text-red-900 bg-white rounded-md text-sm font-medium p-2 transition-colors duration-150 ease-in-out hover:bg-red-50 mr-1">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                        <button wire:click="generatePdf({{ $request->id }})"
                                            class="text-blue-600 hover:text-blue-900 bg-white rounded-md text-sm font-medium p-2 transition-colors duration-150 ease-in-out hover:bg-blue-50">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12">
                <div class="max-w-lg mx-auto text-center">
                    <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">No leave requests found</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't submitted any leave requests yet.</p>
                    <div class="mt-6">
                        <button @click="setActiveTab('apply')"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Apply for Leave
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Leave Balance Tab -->
    <div x-show="activeTab === 'balance'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Leave Balance</h2>
            <p class="mt-1 text-sm text-gray-500">View your current leave entitlements and usage</p>
        </div>

        @if ($leaveBalance)
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 overflow-hidden rounded-lg border border-blue-200 shadow-sm p-6">
                        <dt class="text-sm font-medium text-blue-600 truncate flex items-center">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Total Annual Leave
                        </dt>
                        <dd class="mt-4 flex items-baseline justify-between">
                            <p class="text-4xl font-extrabold text-blue-900">{{ $leaveBalance->total_balance }}</p>
                            <p class="text-sm text-blue-700 truncate">days for {{ $leaveBalance->year }}</p>
                        </dd>
                    </div>

                    <div
                        class="bg-gradient-to-br from-yellow-50 to-yellow-100 overflow-hidden rounded-lg border border-yellow-200 shadow-sm p-6">
                        <dt class="text-sm font-medium text-yellow-600 truncate flex items-center">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Used Leave
                        </dt>
                        <dd class="mt-4 flex items-baseline justify-between">
                            <p class="text-4xl font-extrabold text-yellow-900">{{ $leaveBalance->used_balance }}</p>
                            <p class="text-sm text-yellow-700 truncate">days used</p>
                        </dd>
                    </div>

                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 overflow-hidden rounded-lg border border-green-200 shadow-sm p-6">
                        <dt class="text-sm font-medium text-green-600 truncate flex items-center">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Remaining Leave
                        </dt>
                        <dd class="mt-4 flex items-baseline justify-between">
                            <p class="text-4xl font-extrabold text-green-900">{{ $leaveBalance->remaining_balance }}
                            </p>
                            <p class="text-sm text-green-700 truncate">days available</p>
                        </dd>
                    </div>
                </dl>

                <!-- Leave Usage Visualization -->
                <div x-data="{
                    total: {{ $leaveBalance->total_balance }},
                    used: {{ $leaveBalance->used_balance }},
                    remaining: {{ $leaveBalance->remaining_balance }},
                    percentUsed: {{ $leaveBalance->total_balance > 0 ? ($leaveBalance->used_balance / $leaveBalance->total_balance) * 100 : 0 }}
                }" class="mt-8">
                    <h3 class="text-base font-medium text-gray-900 mb-3">Leave Usage Overview</h3>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div :style="`width: ${percentUsed}%`"
                            :class="{
                                'bg-green-500': percentUsed < 50,
                                'bg-yellow-500': percentUsed >= 50 && percentUsed < 75,
                                'bg-red-500': percentUsed >= 75
                            }"
                            class="h-4 rounded-full transition-all duration-500"></div>
                    </div>
                    <div class="mt-2 flex justify-between text-sm">
                        <span class="text-gray-600"><span x-text="used"></span> days used</span>
                        <span class="text-gray-600"><span x-text="remaining"></span> days remaining</span>
                    </div>
                </div>

                <!-- Upcoming Leaves Section -->
                <div class="mt-8">
                    <h3 class="text-base font-medium text-gray-900 mb-3">Upcoming Approved Leaves</h3>
                    @php
                        $upcomingLeaves = $leaveRequests
                            ->where('status', 'approved')
                            ->where('end_date', '>=', now())
                            ->sortBy('start_date')
                            ->take(3);
                    @endphp

                    @if (count($upcomingLeaves) > 0)
                        <ul class="space-y-3">
                            @foreach ($upcomingLeaves as $leave)
                                <li class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                    <div class="border-l-4 border-blue-500 pl-4 py-3 pr-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} -
                                                    {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }}
                                                    {{ Str::plural('day', \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1) }}
                                                    ·
                                                    {{ ucfirst($leave->type) }} Leave
                                                </p>
                                            </div>
                                            <div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="-ml-0.5 mr-1.5 h-3 w-3"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Approved
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-gray-500 text-sm">No upcoming approved leaves</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="py-12">
                <div class="max-w-lg mx-auto text-center">
                    <svg class="h-16 w-16 text-yellow-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Leave balance information not available</h3>
                    <p class="mt-1 text-sm text-gray-500">Please contact HR for information about your leave
                        entitlements.</p>
                    <div class="mt-6">
                        <button @click="setActiveTab('apply')"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Apply for Leave
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Signature Modal with Fixed Submit Button -->
    <x-modals.modal name="signature-modal" maxWidth="md">
        <div x-data="signaturePad()">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Sign Your Leave Request</h3>
                <button @click="$dispatch('close-modal', 'signature-modal')"
                    class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Please sign in the box below to confirm your leave request.</p>
                </div>

                <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden bg-white">
                    <canvas x-ref="signature_canvas" class="w-full h-60">
                    </canvas>
                </div>

                <div class="mt-6 flex justify-between">
                    <button x-on:click="clearSignature()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Clear
                    </button>

                    <button x-on:click="upload()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Confirm Signature
                    </button>
                </div>
            </div>
        </div>
    </x-modals.modal>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <!-- Updated JavaScript for Signature Pad -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                signaturePadInstance: null,

                init() {
                    this.$nextTick(() => {
                        this.initSignaturePad();

                        // Listen for modal open events to initialize pad if needed
                        document.addEventListener('open-modal', (event) => {
                            if (event.detail === 'signature-modal') {
                                setTimeout(() => {
                                    this.initSignaturePad();
                                    this.resizeCanvas();
                                }, 100);
                            }
                        });

                        // Handle window resize
                        window.addEventListener('resize', () => {
                            this.resizeCanvas();
                        });
                    });
                },

                initSignaturePad() {
                    const canvas = this.$refs.signature_canvas;
                    if (!canvas) return;

                    if (this.signaturePadInstance) {
                        this.signaturePadInstance.off();
                    }

                    this.signaturePadInstance = new SignaturePad(canvas, {
                        backgroundColor: 'rgb(255, 255, 255)',
                        penColor: 'rgb(0, 0, 128)'
                    });

                    // If we already have signature data, try to restore it
                    if (@this.get('signature')) {
                        this.signaturePadInstance.fromDataURL(@this.get('signature'));
                    }

                    this.resizeCanvas();
                },

                resizeCanvas() {
                    if (!this.signaturePadInstance) return;

                    const canvas = this.signaturePadInstance.canvas;
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const width = canvas.offsetWidth;
                    const height = canvas.offsetHeight;

                    // Save current signature data
                    const data = this.signaturePadInstance.toDataURL();

                    // Resize canvas
                    canvas.width = width * ratio;
                    canvas.height = height * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);

                    // Clear canvas
                    this.signaturePadInstance.clear();

                    // Restore signature if it wasn't empty
                    if (data !== this.signaturePadInstance.toDataURL()) {
                        this.signaturePadInstance.fromDataURL(data);
                    }
                },

                clearSignature() {
                    if (this.signaturePadInstance) {
                        this.signaturePadInstance.clear();
                    }
                },

                upload() {
                    console.log('Upload function called');
                    if (this.signaturePadInstance) {
                        // Check if signature is empty, if not upload it
                        if (!this.signaturePadInstance.isEmpty()) {
                            console.log('Signature is not empty, setting signature data');
                            const data = this.signaturePadInstance.toDataURL('image/png');
                            @this.set('signature', data);

                            // Close the modal
                            const closeEvent = new CustomEvent('close-modal', {
                                detail: 'signature-modal'
                            });
                            window.dispatchEvent(closeEvent);
                        } else {
                            alert('Please sign before confirming');
                        }
                    } else {
                        console.error('Signature pad instance is null');
                    }
                }
            }));
        });
    </script>
</div>
