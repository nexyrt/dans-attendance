<div>
    <div x-data="{
        show: @entangle('showModal').live,
        isSuccess: false,
        time: '',
        isLoadingLocation: false,
        locationError: false,
        startTimer() {
            this.updateTime();
            setInterval(() => this.updateTime(), 1000);
        },
        updateTime() {
            const now = new Date();
            this.time = now.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
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
    }" x-init="startTimer();
    getLocation()" @success-checkin.window="isSuccess = true"
        @refresh-page.window="setTimeout(() => { window.location.reload() }, 1500)">

        <div x-show="show" x-cloak class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-[99]"></div>

        <div x-show="show" x-cloak class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div x-show="!isSuccess">
                        {{-- Location Information Card --}}
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Location Requirements
                            </h4>
                            @if ($nearestOffice)
                                <div class="space-y-2 text-sm text-blue-800">
                                    <p class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Office: {{ $nearestOffice->name }}
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        Address: {{ $nearestOffice->address }}
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        Required Distance: Within {{ $nearestOffice->radius }}m
                                    </p>
                                    @if ($nearestOfficeDistance !== null)
                                        <p
                                            class="flex items-center font-medium {{ $nearestOfficeDistance <= $nearestOffice->radius ? 'text-green-600' : 'text-red-600' }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                            </svg>
                                            Current Distance: {{ round($nearestOfficeDistance) }}m
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="text-sm text-blue-800 flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Loading office location information...
                                </div>
                            @endif
                        </div>

                        {{-- Error Message --}}
                        @if ($errorMessage)
                            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $errorMessage }}
                            </div>
                        @endif

                        {{-- Location Status --}}
                        <div x-show="isLoadingLocation"
                            class="mb-4 p-4 text-sm text-blue-700 bg-blue-100 rounded-lg flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Getting your location...
                        </div>

                        {{-- Digital Clock --}}
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-indigo-100">
                            <div class="text-center">
                                <div class="text-2xl font-semibold text-indigo-600" x-text="time"></div>
                            </div>
                        </div>

                        {{-- Status Message --}}
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-xl font-semibold leading-6 text-gray-900">
                                Selamat Datang!
                            </h3>
                            <div class="mt-2">
                                @if ($schedule)
                                    @php
                                        $startTime = \Cake\Chronos\Chronos::parse($schedule->start_time)->format('H:i');
                                        $toleranceLimit = \Cake\Chronos\Chronos::parse($schedule->start_time)->modify(
                                            "+{$schedule->late_tolerance} minutes",
                                        );
                                        $toleranceTime = $toleranceLimit->format('H:i');
                                        $currentTime = \Cake\Chronos\Chronos::now();
                                    @endphp

                                    @if ($currentTime->timestamp > $toleranceLimit->timestamp)
                                        <p class="text-red-500">
                                            Anda terlambat. Check-in setelah {{ $toleranceTime }} akan dihitung sebagai
                                            keterlambatan.
                                        </p>
                                    @else
                                        <p>
                                            Silakan check-in. Batas waktu check-in tanpa keterlambatan adalah
                                            {{ $toleranceTime }}.
                                        </p>
                                    @endif
                                @else
                                    <p class="text-gray-500">
                                        Tidak ada jadwal kerja untuk hari ini.
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Check-in Button --}}
                        <div class="mt-5 sm:mt-6">
                            <button type="button" wire:click="checkIn" wire:loading.attr="disabled"
                                wire:target="checkIn"
                                x-bind:disabled="isLoadingLocation || locationError || {{ $errorMessage ? 'true' : 'false' }}"
                                class="inline-flex w-full justify-center items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="checkIn">Check In Now</span>
                                <span wire:loading wire:target="checkIn" class="inline-flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>

                            {{-- Retry Location Button --}}
                            @if ($errorMessage)
                                <button type="button" @click="getLocation()"
                                    class="mt-2 inline-flex w-full justify-center rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-200">
                                    Retry Getting Location
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Success State --}}
                    <div x-show="isSuccess">
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Check In Berhasil!
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Selamat bekerja dan semoga hari Anda menyenangkan.
                                </p>
                                @if ($nearestOffice)
                                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                                        <p>Checked in at {{ $nearestOffice->name }}</p>
                                        <p>Distance: {{ round($nearestOfficeDistance) }}m from office</p>
                                        @if ($latitude && $longitude)
                                            <p>Location: {{ number_format($latitude, 6) }},
                                                {{ number_format($longitude, 6) }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-6">
                            <button type="button" @click="closeModal()"
                                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
