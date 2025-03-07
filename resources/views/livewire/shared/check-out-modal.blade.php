{{-- resources/views/livewire/shared/check-out-modal.blade.php --}}

@php
    use App\Helpers\DateTimeHelper;
@endphp

<x-modals.modal name="checkout" :show="$showModal" maxWidth="2xl">
    <div class="w-full md:w-[640px]">
        @if ($todayAttendance && $todayAttendance->check_out)
            {{-- Completed State --}}
            <div class="p-6">
                <div class="max-w-md mx-auto text-center">
                    {{-- Status Icon --}}
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-6">
                        <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>

                    {{-- Title --}}
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Day Complete</h2>

                    {{-- Time Info Card --}}
                    <div class="bg-gray-50 rounded-xl overflow-hidden mb-6">
                        <div class="grid grid-cols-2 divide-x divide-gray-200">
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">Check In</div>
                                <div class="text-lg font-semibold text-gray-900 font-mono">
                                    {{ DateTimeHelper::parse($todayAttendance->check_in)->format('H:i') }}
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">Check Out</div>
                                <div class="text-lg font-semibold text-gray-900 font-mono">
                                    {{ DateTimeHelper::parse($todayAttendance->check_out)->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-100 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Hours</span>
                                <span class="text-lg font-semibold text-gray-900">
                                    {{ number_format($todayAttendance->working_hours, 1) }}h
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Notes Display --}}
                    @if ($todayAttendance->notes)
                        <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Activity Notes</h3>
                            <p class="text-sm text-gray-600">{{ $todayAttendance->notes }}</p>
                        </div>
                    @endif

                    {{-- Close Button --}}
                    <button type="button" wire:click="$dispatch('close-modal', 'checkout')"
                        class="w-full rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-150">
                        Close
                    </button>
                </div>
            </div>
        @else
            <div x-data="{
                time: '',
                hours: '00',
                minutes: '00',
                seconds: '00',
                isLoadingLocation: false,
                locationError: false,
                isSuccess: false,
                startTimer() {
                    this.updateTime();
                    this.getLocation();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
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
                },
                getLocation() {
                    this.isLoadingLocation = true;
                    this.locationError = false;
            
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                this.isLoadingLocation = false;
                                @this.call('handleLocationUpdate',
                                    position.coords.latitude,
                                    position.coords.longitude
                                );
                            },
                            (error) => {
                                console.error('Error getting location:', error);
                                this.isLoadingLocation = false;
                                this.locationError = true;
                                @this.call('handleLocationUpdate', null, null);
                            }, {
                                enableHighAccuracy: true,
                                timeout: 5000,
                                maximumAge: 0
                            }
                        );
                    } else {
                        this.isLoadingLocation = false;
                        this.locationError = true;
                        @this.call('handleLocationUpdate', null, null);
                    }
                }
            }" x-init="startTimer()" @success-checkout.window="isSuccess = true"
                @refresh-page.window="setTimeout(() => { window.location.reload() }, 1500)" x-cloak>
                @if (!$isSuccess)
                    <div class="divide-y divide-gray-200">
                        {{-- Header Section --}}
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900">Ready to Check Out?</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $this->getCurrentDate() }}</p>
                        </div>

                        {{-- Location Section --}}
                        <div class="p-6 bg-gray-50">
                            <div class="space-y-4">
                                <h3 class="text-sm font-medium text-gray-900">Location Check</h3>

                                @if ($nearestOffice)
                                    <div class="bg-white rounded-lg p-4 space-y-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-blue-100">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $nearestOffice->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $nearestOffice->address }}</div>
                                            </div>
                                        </div>

                                        @if ($nearestOfficeDistance !== null)
                                            <div
                                                class="flex items-center gap-2 {{ $nearestOfficeDistance <= $nearestOffice->radius ? 'text-green-600' : 'text-red-600' }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                <span class="text-sm font-medium">
                                                    {{ round($nearestOfficeDistance) }}m from office (max
                                                    {{ $nearestOffice->radius }}m)
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-white rounded-lg p-4">
                                        <div class="flex items-center gap-3">
                                            <svg class="animate-spin h-5 w-5 text-blue-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            <span class="text-sm text-gray-600">Getting location information...</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($errorMessage)
                                    <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm">
                                        {{ $errorMessage }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Work Duration Section --}}
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Work Duration</h3>

                            <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                {{-- Check-in Time --}}
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Check-in Time</span>
                                    <span class="font-mono font-medium text-gray-900">
                                        {{ $attendance ? $this->formatDate($attendance->check_in) : '--:--:--' }}
                                    </span>
                                </div>

                                {{-- Duration Counter --}}
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="bg-white rounded-lg p-3 text-center">
                                        <div class="text-2xl font-mono font-bold text-blue-600" x-text="hours">00</div>
                                        <div class="text-xs font-medium text-gray-500 mt-1">Hours</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center">
                                        <div class="text-2xl font-mono font-bold text-blue-600" x-text="minutes">00
                                        </div>
                                        <div class="text-xs font-medium text-gray-500 mt-1">Minutes</div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 text-center">
                                        <div class="text-2xl font-mono font-bold text-blue-600" x-text="seconds">00
                                        </div>
                                        <div class="text-xs font-medium text-gray-500 mt-1">Seconds</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                Activity Notes <span class="text-red-500">*</span>
                            </h3>
                            
                            <!-- Alpine.js + Quill integration -->
                            <div x-data="{
                                    quill: null,
                                    content: @entangle('notes').live,
                                    init() {
                                        // Ensure Quill is available
                                        if (typeof window.Quill === 'undefined') {
                                            console.error('Quill is not available. Make sure it is properly imported in app.js');
                                            return;
                                        }
                                        
                                        // Initialize Quill
                                        this.quill = new window.Quill(this.$refs.quillEditor, {
                                            theme: 'snow',
                                        });
                                        
                                        // Set initial content if available
                                        if (this.content) {
                                            this.quill.root.innerHTML = this.content;
                                        }
                                        
                                        // Update Alpine data when editor changes
                                        this.quill.on('text-change', () => {
                                            this.content = this.quill.root.innerHTML;
                                        });
                                    }
                                }" 
                                wire:ignore
                            >
                                <!-- Quill container -->
                                <div x-ref="quillEditor" style="min-height: 120px; border: 1px solid #ccc;"></div>
                            </div>
                            
                            @error('notes')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <p>{{$this->notes}}</p>

                        {{-- Activity Notes Section --}}
                        {{-- <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                Activity Notes <span class="text-red-500">*</span>
                            </h3>
                            <textarea wire:model="notes"
                                class="w-full rounded-lg border-gray-200 resize-none text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                rows="3" placeholder="Summarize your activities for today..."></textarea>
                            @error('notes')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        {{-- Early Leave Form --}}
                        @if ($showEarlyLeaveForm)
                            <div class="p-6">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2 text-amber-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z" />
                                        </svg>
                                        <span class="text-sm font-medium">Early Leave Notice Required</span>
                                    </div>
                                    <textarea wire:model="earlyLeaveReason"
                                        class="w-full rounded-lg border-gray-200 resize-none text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        rows="3" placeholder="Please provide your reason for leaving early..."></textarea>
                                    @error('earlyLeaveReason')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="p-6 bg-gray-50">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" wire:click="$dispatch('close-modal', 'checkout')"
                                    class="w-full sm:w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-150">
                                    Cancel
                                </button>
                                <button type="button" wire:click="checkOut" wire:loading.attr="disabled"
                                    class="w-full sm:w-1/2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150">
                                    <span wire:loading.remove>
                                        Confirm Check Out
                                    </span>
                                    <span wire:loading class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
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
                    </div>
                @else
                    {{-- Success State --}}
                    <div class="p-6">
                        <div class="max-w-md mx-auto text-center">
                            <span
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </span>

                            <h2 class="text-xl font-semibold text-gray-900 mb-2">Check Out Successful!</h2>
                            <p class="text-sm text-gray-500 mb-6">Thank you for your work today. Have a great rest!</p>

                            <button type="button" wire:click="$dispatch('close-modal', 'checkout')"
                                class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-150">
                                Close
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>


</x-modals.modal>
