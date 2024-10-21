@props([
    'title' => '',
    'bg' => '',
    'text' => ''
])

<div x-data="{ showModal: false }" x-cloak>
    <!-- Trigger button -->
    <button @click="showModal = true" {{ $attributes->merge(['class' => ''.$bg.' '.$text.' px-4 py-2 rounded']) }}>{{$title}}</button>
    <!-- Modal Background -->
    <div @click="showModal = false" x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <!-- Modal Content -->
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 h-screen overflow-auto" @click.stop>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{$title}}</h3>
                {{$slot}}
                <button @click="showModal = false" class="bg-red-500 text-white px-4 py-2 rounded mt-2">Close</button>
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
