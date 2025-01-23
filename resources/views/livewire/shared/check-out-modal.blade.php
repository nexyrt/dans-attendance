@php
    use App\Helpers\DateTimeHelper;
@endphp

<x-modals.modal name="checkout" :show="$showModal" max-width="xl" x-cloak>
    <div class="w-[580px] mx-auto">
        @if ($todayAttendance && $todayAttendance->check_out)
            <div class="p-8 text-center">
                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-blue-100 mb-6">
                    <svg class="h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Day Complete</h3>
                <div class="mt-4 bg-gray-50 rounded-xl p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Check-in Time</span>
                        <span class="text-base font-semibold text-gray-900">
                            {{ DateTimeHelper::parse($todayAttendance->check_in)->format('H:i:s') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Check-out Time</span>
                        <span class="text-base font-semibold text-gray-900">
                            {{ DateTimeHelper::parse($todayAttendance->check_out)->format('H:i:s') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                        <span class="text-sm text-gray-600">Total Working Hours</span>
                        <span class="text-base font-semibold text-gray-900">
                            {{ number_format($todayAttendance->working_hours, 1) }} hours
                        </span>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-500">You have completed your attendance for today.</p>
                <button type="button" wire:click="$dispatch('close-modal', 'checkout')"
                    class="mt-6 w-full px-5 py-3 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 transition-all duration-200">
                    Close
                </button>
            </div>
        @else
            <div x-data="{
                time: @entangle('currentTime'),
                hours: '00',
                minutes: '00',
                seconds: '00',
                startTimer() {
                    setInterval(() => {
                        this.time = new Date().toLocaleTimeString('en-US', {
                            hour12: false,
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
            
                        @if($attendance && $attendance->check_in)
                        const checkIn = new Date('{{ $attendance->check_in }}');
                        const now = new Date();
                        const diff = Math.abs(now - checkIn);
            
                        this.hours = String(Math.floor(diff / 3600000)).padStart(2, '0');
                        this.minutes = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
                        this.seconds = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
                        @endif
                    }, 1000);
                }
            }" x-init="startTimer()">
                @if (!$isSuccess)
                    <div class="p-8">
                        <!-- Time Display -->
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Ready to Check-Out?</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ $this->getCurrentDate() }}</p>
                            </div>
                            <div class="bg-rose-50 px-5 py-3 rounded-xl border border-rose-100">
                                <div class="text-2xl font-bold text-rose-600 font-mono" x-text="time"></div>
                                <div class="text-xs text-rose-500 text-center mt-0.5">WIB</div>
                            </div>
                        </div>

                        <!-- Check-in Info -->
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm divide-y divide-gray-100 mb-6">
                            <div class="p-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Check-in Time</span>
                                    <span class="text-base font-semibold text-gray-900">
                                        @if ($attendance && $attendance->check_in)
                                            {{ $this->formatDate($attendance->check_in) }}
                                        @else
                                            --:--:--
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Working Hours Counter -->
                            <div class="p-4">
                                <div class="text-sm text-gray-600 mb-3">Working Hours</div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <div class="text-2xl font-bold text-rose-600 font-mono tracking-wider"
                                            x-text="hours">00
                                        </div>
                                        <div class="text-xs font-medium text-gray-500 mt-1">Hours</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <div class="text-2xl font-bold text-rose-600 font-mono tracking-wider"
                                            x-text="minutes">
                                            00</div>
                                        <div class="text-xs font-medium text-gray-500 mt-1">Minutes</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <div class="text-2xl font-bold text-rose-600 font-mono tracking-wider"
                                            x-text="seconds">
                                            00</div>
                                        <div class="text-xs font-medium text-gray-500 mt-1">Seconds</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($showEarlyLeaveForm)
                            <!-- Early Leave Notice -->
                            <div class="mb-6">
                                <div class="flex items-center space-x-2 mb-3">
                                    <div class="bg-amber-50 p-1.5 rounded-lg">
                                        <svg class="h-4 w-4 text-amber-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Early Leave Notice Required</span>
                                </div>
                                <textarea wire:model="earlyLeaveReason"
                                    class="w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 resize-none text-sm"
                                    rows="3" placeholder="Please provide your reason for leaving early..."></textarea>
                                @error('earlyLeaveReason')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <button type="button" wire:click="$dispatch('close-modal', 'checkout')"
                                class="flex-1 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-offset-1 focus:ring-gray-200 transition-all duration-200">
                                Cancel
                            </button>
                            <button type="button" wire:click="checkOut" wire:loading.attr="disabled"
                                class="flex-1 px-5 py-2.5 text-sm font-medium text-white bg-rose-600 rounded-xl hover:bg-rose-700 disabled:opacity-50 focus:ring-2 focus:ring-offset-1 focus:ring-rose-500 transition-all duration-200">
                                <span wire:loading.remove>Confirm Check-Out</span>
                                <span wire:loading class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-8 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Check-Out Successful!</h3>
                        <p class="mt-2 text-sm text-gray-500">Have a great rest of your day.</p>
                        <button type="button" wire:click="$dispatch('close-modal', 'checkout')"
                            class="mt-6 w-full px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 focus:ring-2 focus:ring-offset-1 focus:ring-green-500 transition-all duration-200">
                            Close
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-modals.modal>
