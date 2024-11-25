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
        {{-- Modal Backdrop --}}
        <div x-show="show" x-cloak class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-[99]"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            style="position: fixed; top: 0; right: 0; bottom: 0; left: 0;">
        </div>

        {{-- Modal Panel --}}
        <div x-show="show" x-cloak class="fixed inset-0 z-[100] overflow-y-auto"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div x-show="!isSuccess">
                        {{-- Clock Display --}}
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-indigo-100">
                            <div class="text-center">
                                <div class="text-2xl font-semibold text-indigo-600" x-text="time"></div>
                            </div>
                        </div>

                        {{-- Modal Content --}}
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-xl font-semibold leading-6 text-gray-900">
                                Selamat Datang!
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Silakan check-in untuk memulai hari kerja Anda.
                                </p>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-5 sm:mt-6">
                            <button type="button" wire:click="checkIn" wire:loading.attr="disabled"
                                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50">
                                <span wire:loading.remove>Check In Sekarang</span>
                                <span wire:loading>
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
                        </div>
                    </div>

                    {{-- Success State --}}
                    <div x-show="isSuccess" x-transition:enter="transform ease-out duration-300 transition"
                        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0">
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
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
                            </div>
                        </div>

                        {{-- Close Button --}}
                        <div class="mt-5 sm:mt-6">
                            <button type="button" @click="closeModal()"
                                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
