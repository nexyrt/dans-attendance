<x-modals.modal name="modal-name" :show="$showModal" max-width="xl">
    <div class="p-8 w-[600px]">
        @if($hasCompletedAttendance)
            <div class="text-center py-8">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-blue-100 mb-4">
                    <svg class="h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900">Already Checked Out</h3>
                <p class="mt-3 text-gray-500">You have already completed your attendance for today.</p>
                <button type="button"
                    wire:click="$dispatch('close-modal', 'modal-name')"
                    class="mt-8 w-full px-4 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Close
                </button>
            </div>
        @elseif(!$attendance)
            <div class="text-center py-8">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100 mb-4">
                    <svg class="h-10 w-10 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900">No Active Check-in</h3>
                <p class="mt-3 text-gray-500">Please check-in first before attempting to check-out.</p>
                <button type="button"
                    wire:click="$dispatch('close-modal', 'modal-name')"
                    class="mt-8 w-full px-4 py-3 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">
                    Close
                </button>
            </div>
        @elseif(!$isSuccess)
            <!-- Clock Display -->
            <div class="text-center mb-8">
                <div class="mx-auto bg-gradient-to-r from-red-50 to-red-100 rounded-full p-8 w-40 h-40 flex items-center justify-center">
                    <div>
                        <div class="text-3xl font-bold text-red-600 font-mono tracking-wider">{{ $currentTime }}</div>
                        <div class="text-sm text-red-500 mt-1">WIB</div>
                    </div>
                </div>
                <h3 class="mt-6 text-2xl font-bold text-gray-900">Ready to Check-Out?</h3>
                <p class="mt-2 text-gray-500">{{ Carbon\Carbon::now()->format('l, d F Y') }}</p>
            </div>

            <!-- Attendance Info -->
            <div class="bg-gray-50 rounded-xl p-6 space-y-4 mb-8">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 font-medium">Check-in Time</span>
                    <span class="text-lg font-semibold text-gray-900">{{ $attendance->check_in->format('H:i:s') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 font-medium">Working Hours</span>
                    <span class="text-lg font-semibold text-gray-900">{{ number_format($workingHours, 1) }} hours</span>
                </div>
            </div>

            <!-- Early Leave Form -->
            @if($showEarlyLeaveForm)
                <div class="bg-yellow-50 rounded-xl p-6 mb-8">
                    <div class="flex items-center space-x-3 text-yellow-800 mb-4">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z"/>
                        </svg>
                        <span class="text-lg font-medium">Early Leave Notice Required</span>
                    </div>
                    <textarea 
                        wire:model="earlyLeaveReason"
                        class="w-full rounded-lg border-yellow-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500"
                        rows="4"
                        placeholder="Please provide a reason for leaving early..."
                    ></textarea>
                    @error('earlyLeaveReason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button type="button"
                    wire:click="$dispatch('close-modal', 'modal-name')"
                    class="flex-1 px-4 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button"
                    wire:click="checkOut"
                    wire:loading.attr="disabled"
                    class="flex-1 px-4 py-3 text-base font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 disabled:opacity-50">
                    <span wire:loading.remove>Confirm Check-Out</span>
                    <span wire:loading class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        @else
            <!-- Success State -->
            <div class="text-center py-8">
                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-green-100 mb-6">
                    <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900">Check-Out Successful!</h3>
                <p class="mt-3 text-gray-500">Have a great rest of your day.</p>
                <button type="button"
                    wire:click="$dispatch('close-modal', 'modal-name')"
                    class="mt-8 w-full px-4 py-3 text-base font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                    Close
                </button>
            </div>
        @endif
    </div>
</x-modals.modal>