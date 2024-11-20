@props([
    'title' => '',
    'bg' => '',
    'text' => '',
])

<div x-data="{ showModal: false }" x-cloak>
    <!-- Trigger button -->
    <button @click="showModal = true" {{ $attributes->merge(['class' => '' . $bg . ' ' . $text . ' px-4 py-2 rounded']) }}>
        {{ $title }}
    </button>

    <!-- Modal Background -->
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50" @click="showModal = false">

        <!-- Modal Container for Centering -->
        <div class="min-h-screen px-4 text-center">
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div class="inline-block w-full max-w-2xl p-6 my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-lg"
                @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ $title }}
                    </h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
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

                <!-- Modal Footer -->
                <div class="mt-5 sm:mt-6 flex justify-end">
                    <button @click="showModal = false"
                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('dropzone-file');
        const previewImage = document.getElementById('preview-image');
        const uploadText = document.getElementById('upload-text');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    uploadText.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = '';
                previewImage.classList.add('hidden');
                uploadText.classList.remove('hidden');
            }
        });
    });
</script>
