<x-admin-layout>
    <livewire:admin.user-table />

    <!-- Modal script -->
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('showEditModal', () => {
                document.getElementById('userModal').classList.remove('hidden');
            });

            document.getElementById('openModalBtn').addEventListener('click', function() {
                document.getElementById('userModal').classList.remove('hidden');
            });

            document.getElementById('closeModalBtn').addEventListener('click', function() {
                document.getElementById('userModal').classList.add('hidden');
            });

            document.getElementById('dropzone-file').addEventListener('change', function(event) {
                const [file] = event.target.files;
                if (file) {
                    const previewImage = document.getElementById('preview-image');
                    const uploadText = document.getElementById('upload-text');
                    previewImage.src = URL.createObjectURL(file);
                    previewImage.classList.remove('hidden');
                    uploadText.classList.add('hidden');
                }
            });
        });
    </script>

    <!-- Custom CSS to remove arrows from input[type=number] -->
    <style>
        /* Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Custom CSS for image preview */
        #dropzone-file {
            position: relative;
        }

        #preview-image {
            object-fit: contain;
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 0.5rem;
        }
    </style>
</x-admin-layout>
