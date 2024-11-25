<div
    x-data="{ show: false, message: '', type: 'success' }"
    x-on:notify.window="
        show = true;
        message = $event.detail.message;
        type = $event.detail.type;
        setTimeout(() => { show = false }, 3000);
    "
    class="fixed top-4 right-4 z-[110]"
>
    <div
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto"
        :class="{
            'bg-green-50': type === 'success',
            'bg-red-50': type === 'error'
        }"
    >
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <!-- Success Icon -->
                    <template x-if="type === 'success'">
                        <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </template>
                    <!-- Error Icon -->
                    <template x-if="type === 'error'">
                        <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </template>
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p 
                        class="text-sm font-medium"
                        :class="{
                            'text-green-800': type === 'success',
                            'text-red-800': type === 'error'
                        }"
                        x-text="message"
                    ></p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button
                        @click="show = false"
                        class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>