<!-- resources/views/livewire/staff/leave.blade.php -->
<div class="max-w-7xl mx-auto py-6 px-4" 
    x-data="{
        activeTab: '{{ request()->query('tab', 'apply') }}'
    }"
    @leave-submitted.window="window.location.href = '{{ route('staff.leave.index', ['tab' => 'history']) }}'">
    
    <!-- Include the Flash Message Component -->
    <x-shared.flash-message />

    <!-- Tab Navigation - Improved for Mobile -->
    <div class="mb-6 overflow-x-auto">
        <nav class="flex bg-white rounded-lg p-1.5 shadow-sm">
            <button @click="activeTab = 'apply'"
                :class="activeTab === 'apply' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'"
                class="flex items-center px-3 md:px-4 py-2 text-sm font-medium rounded-md transition-all duration-200">
                <svg class="md:mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="hidden md:inline">Apply for Leave</span>
                <span class="inline md:hidden">Apply</span>
            </button>
            <button @click="activeTab = 'history'"
                :class="activeTab === 'history' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'"
                class="flex items-center px-3 md:px-4 py-2 text-sm font-medium rounded-md transition-all duration-200">
                <svg class="md:mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="hidden md:inline">Leave History</span>
                <span class="inline md:hidden">History</span>
            </button>
            <button @click="activeTab = 'balance'"
                :class="activeTab === 'balance' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'"
                class="flex items-center px-3 md:px-4 py-2 text-sm font-medium rounded-md transition-all duration-200">
                <svg class="md:mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <span class="hidden md:inline">Leave Balance</span>
                <span class="inline md:hidden">Balance</span>
            </button>
        </nav>
    </div>

    <!-- Apply for Leave Tab with Improved Layout Consistency -->
    <div x-show="activeTab === 'apply'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-4 md:px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Apply for Leave</h2>
            <p class="mt-1 text-sm text-gray-500">Fill in the details to submit your leave request</p>
        </div>

        <div class="p-4 md:p-6">
            <form wire:submit.prevent="submit">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Leave Type & Duration Section -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Leave Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Leave Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                                <x-input.select name="type" :options="[
                                    ['value' => 'annual', 'label' => 'Annual'],
                                    ['value' => 'sick', 'label' => 'Sick'],
                                    ['value' => 'important', 'label' => 'Important'],
                                    ['value' => 'other', 'label' => 'Other'],
                                ]" :selected="'annual'" placeholder="Select leave type" />
                            </div>
                            
                            <!-- Leave Duration -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Leave Duration</label>
                                <livewire:date-range-picker :start-date="$start_date" :end-date="$end_date" wire:key="leave-date-picker" />
                                @error('start_date')<span class="text-red-500 text-sm block mt-1">{{ $message }}</span>@enderror
                                @error('end_date')<span class="text-red-500 text-sm block mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Date Overlap Error -->
                        @if ($dateOverlapError)
                            <div class="mt-3 flex items-start">
                                <svg class="h-5 w-5 text-red-500 flex-shrink-0 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-red-600 text-sm">{{ $dateOverlapError }}</span>
                            </div>
                        @endif

                        <!-- Calculated Days -->
                        <div class="mt-3 bg-white p-3 rounded-md border border-gray-100 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">Duration:</span>
                                </div>
                                <span class="bg-blue-50 text-blue-700 text-sm font-semibold px-2.5 py-0.5 rounded-full">
                                    {{ $calculatedDays }} {{ Str::plural('working day', $calculatedDays) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 ml-7 mt-1">
                                <svg class="inline-block w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                Weekends (Saturday and Sunday) are excluded from the calculation
                            </p>
                        </div>
                    </div>

                    <!-- Reason Section -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Reason</h3>
                        <div x-data="{ charCount: 0, maxChars: 500 }">
                            <div class="flex justify-between items-center text-sm mb-1">
                                <label for="reason" class="font-medium text-gray-700">Reason for Leave</label>
                                <span x-text="`${charCount}/${maxChars}`"
                                    :class="{ 'text-red-500': charCount > maxChars, 'text-gray-500': charCount <= maxChars }"
                                    class="text-xs"></span>
                            </div>
                            <textarea id="reason" wire:model="reason" rows="3" x-on:input="charCount = $event.target.value.length"
                                :class="{ 'border-red-300 focus:ring-red-500 focus:border-red-500': charCount > maxChars }"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                placeholder="Please provide a detailed reason for your leave request"></textarea>
                            @error('reason')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Supporting Documents Section -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Supporting Documents</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Attachment -->
                            <div x-data="{ fileName: null }">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Attachment (Optional)</label>
                                <div class="mt-1">
                                    <label for="attachment" class="cursor-pointer block">
                                        <div class="px-3 py-2 bg-white border border-gray-300 rounded-md flex items-center justify-between hover:bg-gray-50 transition-colors">
                                            <div class="flex items-center truncate">
                                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                                    <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                                                </svg>
                                                <span x-text="fileName ? fileName : 'Choose file...'" class="text-gray-500 text-sm truncate">Choose file...</span>
                                            </div>
                                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">Browse</span>
                                        </div>
                                        <input type="file" id="attachment" wire:model="attachment"
                                            @change="fileName = $event.target.files[0]?.name || 'No file selected'"
                                            class="sr-only">
                                    </label>
                                    <p class="mt-1 text-xs text-gray-500">Upload supporting documents (PDF, DOC, DOCX, JPG, PNG)</p>
                                    @error('attachment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <!-- Signature -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Signature</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-md p-3 bg-white flex flex-col justify-between h-[calc(100%-1.5rem)]">
                                    <div class="flex-1 flex items-center justify-center">
                                        @if ($signature)
                                            <img src="{{ $signature }}" alt="Your signature" class="border rounded h-16 bg-white shadow-sm mx-auto">
                                        @else
                                            <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <button type="button" @click="$dispatch('open-modal', 'signature-modal')"
                                        class="w-full mt-3 inline-flex justify-center items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        {{ $signature ? 'Change Signature' : 'Add Signature' }}
                                    </button>
                                </div>
                                @error('signature')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="activeTab = 'history'"
                        class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leave History Tab with Consistent Proportional Layout -->
    <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-white shadow-md rounded-lg overflow-hidden">
        
        <div class="border-b border-gray-200 bg-gray-50 px-4 md:px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Leave History</h2>
            <p class="mt-1 text-sm text-gray-500">Review your past and pending leave requests</p>
        </div>

        @if (count($leaveRequests) > 0)
            <div class="divide-y divide-gray-100">
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
                                'label' => 'Pending Manager',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            ],
                            'pending_hr' => [
                                'bg' => 'bg-blue-100', 
                                'text' => 'text-blue-800',
                                'label' => 'Pending HR',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            ],
                            'pending_director' => [
                                'bg' => 'bg-purple-100', 
                                'text' => 'text-purple-800',
                                'label' => 'Pending Director',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            ],
                            'approved' => [
                                'bg' => 'bg-green-100', 
                                'text' => 'text-green-800',
                                'label' => 'Approved',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            ],
                            'rejected_manager' => [
                                'bg' => 'bg-red-100', 
                                'text' => 'text-red-800',
                                'label' => 'Rejected by Manager',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            ],
                            'rejected_hr' => [
                                'bg' => 'bg-red-100', 
                                'text' => 'text-red-800',
                                'label' => 'Rejected by HR',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            ],
                            'rejected_director' => [
                                'bg' => 'bg-red-100', 
                                'text' => 'text-red-800',
                                'label' => 'Rejected by Director',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            ],
                            'cancel' => [
                                'bg' => 'bg-gray-100', 
                                'text' => 'text-gray-800',
                                'label' => 'Cancelled',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />'
                            ],
                        ];
                        
                        $typeColors = [
                            'annual' => [
                                'bg' => 'bg-blue-100', 
                                'text' => 'text-blue-600',
                                'label' => 'Annual'
                            ],
                            'sick' => [
                                'bg' => 'bg-red-100', 
                                'text' => 'text-red-600',
                                'label' => 'Sick'
                            ],
                            'important' => [
                                'bg' => 'bg-purple-100', 
                                'text' => 'text-purple-600',
                                'label' => 'Important'
                            ],
                            'other' => [
                                'bg' => 'bg-gray-100', 
                                'text' => 'text-gray-600',
                                'label' => 'Other'
                            ],
                        ];
                    @endphp
                    
                    <div class="p-4 md:p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <!-- Leave Info Section -->
                            <div class="flex w-full md:w-3/5 mb-3 md:mb-0">
                                <!-- Type indicator -->
                                <div class="mr-4 self-start">
                                    <div class="{{ $typeColors[$request->type]['bg'] ?? 'bg-gray-100' }} {{ $typeColors[$request->type]['text'] ?? 'text-gray-600' }} rounded-full p-2">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Leave details -->
                                <div class="flex flex-col">
                                    <div class="flex items-center mb-1">
                                        <span class="font-medium text-gray-900">{{ $typeColors[$request->type]['label'] ?? 'Leave' }}</span>
                                        <span class="mx-2 text-gray-400">•</span>
                                        <span class="text-sm text-gray-600">{{ $workDays }} {{ Str::plural('day', $workDays) }}</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-800 mb-1">
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Created: {{ $request->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status and Actions Section -->
                            <div class="flex w-full md:w-2/5 justify-between md:justify-end items-center">
                                <!-- Status Badge -->
                                <div class="md:mr-4">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusInfo[$request->status]['bg'] }} {{ $statusInfo[$request->status]['text'] }}">
                                        <svg class="mr-1 h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $statusInfo[$request->status]['icon'] !!}
                                        </svg>
                                        {{ $statusInfo[$request->status]['label'] }}
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    @if (in_array($request->status, ['pending_manager', 'pending_hr', 'pending_director']))
                                        <button wire:click="cancelLeaveRequest({{ $request->id }})"
                                            onclick="return confirm('Are you sure you want to cancel this leave request?')"
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium rounded border border-red-300 text-red-700 bg-white hover:bg-red-50 transition-colors">
                                            <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel
                                        </button>
                                    @endif
                                    <button wire:click="generatePdf({{ $request->id }})"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded border border-blue-300 text-blue-700 bg-white hover:bg-blue-50 transition-colors">
                                        <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-10 flex flex-col items-center justify-center">
                <svg class="h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-base font-medium text-gray-900">No leave requests found</h3>
                <p class="text-sm text-gray-500 mb-4">You haven't submitted any leave requests yet</p>
                <button @click="activeTab = 'apply'"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Apply for Leave
                </button>
            </div>
        @endif
    </div>

    <!-- Leave Balance Tab (Optimized) -->
    <div x-show="activeTab === 'balance'" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-white shadow-md rounded-lg overflow-hidden">
        
        <div class="border-b border-gray-200 bg-gray-50 px-4 md:px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Leave Balance</h2>
            <p class="mt-1 text-sm text-gray-500">View your current leave entitlements and usage</p>
        </div>

        @if ($leaveBalance)
            <div class="p-4 md:p-6">
                <!-- Balance Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Total Annual Leave -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200 shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-2 text-sm font-medium text-blue-600">Total Annual</span>
                            </div>
                            <span class="text-xs font-medium text-blue-700">{{ $leaveBalance->year }}</span>
                        </div>
                        <p class="mt-3 text-3xl font-bold text-blue-900">{{ $leaveBalance->total_balance }}</p>
                        <p class="text-sm text-blue-700">days entitlement</p>
                    </div>

                    <!-- Used Leave -->
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200 shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="bg-yellow-100 p-2 rounded-full">
                                <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="ml-2 text-sm font-medium text-yellow-600">Used Leave</span>
                        </div>
                        <p class="mt-3 text-3xl font-bold text-yellow-900">{{ $leaveBalance->used_balance }}</p>
                        <p class="text-sm text-yellow-700">days taken</p>
                    </div>

                    <!-- Remaining Leave -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg border border-green-200 shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-full">
                                <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="ml-2 text-sm font-medium text-green-600">Remaining</span>
                        </div>
                        <p class="mt-3 text-3xl font-bold text-green-900">{{ $leaveBalance->remaining_balance }}</p>
                        <p class="text-sm text-green-700">days available</p>
                    </div>
                </div>

                <!-- Usage Progress Bar -->
                <div x-data="{
                    total: {{ $leaveBalance->total_balance }},
                    used: {{ $leaveBalance->used_balance }},
                    percentUsed: {{ $leaveBalance->total_balance > 0 ? ($leaveBalance->used_balance / $leaveBalance->total_balance) * 100 : 0 }}
                }" class="mt-6">
                    <div class="flex justify-between items-center mb-1">
                        <h3 class="text-sm font-medium text-gray-700">Leave Usage</h3>
                        <span class="text-xs text-gray-500" x-text="`${Math.round(percentUsed)}% used`"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div :style="`width: ${percentUsed}%`"
                            :class="{
                                'bg-green-500': percentUsed < 50,
                                'bg-yellow-500': percentUsed >= 50 && percentUsed < 75,
                                'bg-red-500': percentUsed >= 75
                            }"
                            class="h-2.5 rounded-full transition-all duration-500"></div>
                    </div>
                </div>

                <!-- Upcoming Leaves -->
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Upcoming Approved Leaves</h3>
                    @php
                        $upcomingLeaves = $leaveRequests
                            ->where('status', 'approved')
                            ->where('end_date', '>=', now())
                            ->sortBy('start_date')
                            ->take(3);
                    @endphp

                    @if (count($upcomingLeaves) > 0)
                        <div class="space-y-2">
                            @foreach ($upcomingLeaves as $leave)
                                <div class="bg-white rounded-md border border-gray-200 shadow-sm p-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="bg-blue-100 p-1.5 rounded-full">
                                                <svg class="h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ ucfirst($leave->type) }} Leave · {{ \Carbon\Carbon::parse($leave->start_date)->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="mr-1 h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Approved
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-gray-500 text-sm">No upcoming approved leaves</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="py-10 flex flex-col items-center justify-center">
                <svg class="h-12 w-12 text-yellow-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-base font-medium text-gray-900">Leave balance unavailable</h3>
                <p class="text-sm text-gray-500 mb-4">Please contact HR for information about your leave entitlements</p>
                <button @click="activeTab = 'apply'"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    Apply for Leave
                </button>
            </div>
        @endif
    </div>

    <!-- Signature Modal -->
    <x-modals.modal name="signature-modal" maxWidth="md">
        <div x-data="signaturePad()">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Sign Your Leave Request</h3>
                <button @click="$dispatch('close-modal', 'signature-modal')" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Please sign in the box below to confirm your leave request.</p>
                </div>

                <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden bg-white">
                    <canvas x-ref="signature_canvas" class="w-full h-60"></canvas>
                </div>

                <div class="mt-4 flex justify-between">
                    <button @click="clearSignature()" class="px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="inline-block mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        Clear
                    </button>
                    <button @click="upload()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">
                        <svg class="inline-block mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Confirm Signature
                    </button>
                </div>
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
                        document.addEventListener('open-modal', (event) => {
                            if (event.detail === 'signature-modal') {
                                setTimeout(() => {
                                    this.initSignaturePad();
                                    this.resizeCanvas();
                                }, 100);
                            }
                        });
                        window.addEventListener('resize', () => this.resizeCanvas());
                    });
                },

                initSignaturePad() {
                    const canvas = this.$refs.signature_canvas;
                    if (!canvas) return;
                    
                    if (this.signaturePadInstance) this.signaturePadInstance.off();
                    
                    this.signaturePadInstance = new SignaturePad(canvas, {
                        penColor: 'rgb(0, 0, 128)'
                    });
                    
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
                    const data = this.signaturePadInstance.toDataURL();
                    
                    canvas.width = width * ratio;
                    canvas.height = height * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);
                    this.signaturePadInstance.clear();
                    
                    if (data !== this.signaturePadInstance.toDataURL()) {
                        this.signaturePadInstance.fromDataURL(data);
                    }
                },

                clearSignature() {
                    if (this.signaturePadInstance) this.signaturePadInstance.clear();
                },

                upload() {
                    if (this.signaturePadInstance && !this.signaturePadInstance.isEmpty()) {
                        const data = this.signaturePadInstance.toDataURL('image/png');
                        @this.set('signature', data);
                        window.dispatchEvent(new CustomEvent('close-modal', { detail: 'signature-modal' }));
                    } else {
                        alert('Please sign before confirming');
                    }
                }
            }));
        });
    </script>
</div>
