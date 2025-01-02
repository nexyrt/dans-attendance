<div>
    <div x-data="{
        show: @entangle('showModal').live,
        isSuccess: false,
        time: @entangle('currentTime'),
        startTimer() {
            setInterval(() => {
                this.time = new Date().toLocaleTimeString('en-US', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }, 1000);
        },
        closeModal() {
            this.show = false;
            this.isSuccess = false;
        }
    }" x-init="startTimer()" @success-checkin.window="isSuccess = true">

        {{-- Holiday Notice Banner - Always visible at the top of the page --}}
        @if($holidayInfo)
        <div class="fixed top-0 left-0 w-full bg-yellow-50 border-b border-yellow-200 z-50">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-yellow-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-medium text-yellow-800">
                                {{ $holidayInfo['title'] ?? 'Holiday Notice' }}
                            </p>
                            <p class="text-sm text-yellow-700">
                                {{ $holidayInfo['description'] ?? 'Today is a holiday. Check-in is not required.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Modal Content --}}
        <div x-show="show" x-cloak class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-[99]">
        </div>

        <div x-show="show" x-cloak class="fixed inset-0 z-[100] overflow-y-auto">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    
                    {{-- Check-in Form State --}}
                    <div x-show="!isSuccess">
                        {{-- Digital Clock Display --}}
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-indigo-100">
                            <div class="text-center">
                                <div class="text-2xl font-semibold text-indigo-600" x-text="time"></div>
                            </div>
                        </div>

                        {{-- Welcome Message and Schedule Information --}}
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-xl font-semibold leading-6 text-gray-900">
                                Selamat Datang!
                            </h3>
                            <div class="mt-2">
                                @if($schedule)
                                    @php
                                        $startTime = \App\Helpers\DateTimeHelper::parse($schedule->start_time)->format('H:i');
                                        $toleranceTime = \App\Helpers\DateTimeHelper::parse($schedule->start_time)
                                            ->addMinutes($schedule->late_tolerance)
                                            ->format('H:i');
                                        $currentTime = \App\Helpers\DateTimeHelper::now();
                                        $toleranceLimit = \App\Helpers\DateTimeHelper::parse($schedule->start_time)
                                            ->addMinutes($schedule->late_tolerance);
                                    @endphp
                                    
                                    @if($currentTime->greaterThan($toleranceLimit))
                                        <p class="text-red-500">
                                            Anda terlambat. Check-in setelah {{ $toleranceTime }} akan dihitung sebagai keterlambatan.
                                        </p>
                                    @else
                                        <p>
                                            Silakan check-in. Batas waktu check-in tanpa keterlambatan adalah {{ $toleranceTime }}.
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
                                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50">
                                <span wire:loading.remove>Check In Sekarang</span>
                                <span wire:loading class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </div>

                    {{-- Success State --}}
                    <div x-show="isSuccess">
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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