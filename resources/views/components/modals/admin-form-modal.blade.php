<!-- resources/views/components/modals/admin-form-modal.blade.php -->
@props([
    'title' => '',
    'bg' => '',
    'text' => '',
])

<div x-data="{ 
        showModal: false,
        closeModal() { this.showModal = false }
     }" 
     x-cloak
     @close-modal.window="closeModal">
    <!-- Trigger button -->
    <button @click="showModal = true" {{ $attributes->merge(['class' => ' ' . $bg . ' ' . $text . ' px-4 py-2 rounded']) }}>
        {{ $title }}
    </button>

    <!-- Modal Background -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50" 
         @click="closeModal">

        <!-- Modal Container for Centering -->
        <div class="min-h-screen px-4 text-center">
            <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div class="inline-block w-full max-w-2xl p-6 my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-lg"
                @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ $title }}
                    </h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body with Scroll -->
                <div class="max-h-[calc(100vh-16rem)] overflow-y-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>