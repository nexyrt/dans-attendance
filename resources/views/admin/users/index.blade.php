<x-layouts.admin>
    <livewire:admin.user-table />

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
</x-layouts.admin>
