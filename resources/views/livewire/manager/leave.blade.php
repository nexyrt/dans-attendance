<!-- resources/views/livewire/manager/leave.blade.php -->
<div class="max-w-6xl mx-auto py-6">
    <!-- Put this where you want your "open modal" button -->
    <button @click="$dispatch('open-modal', 'my-modal')">
        Open Modal
    </button>

    <!-- Put this anywhere in your page -->
    <x-modals.modal name="my-modal">
        <div class="p-6">
            <h2>This is my modal title</h2>
            <p>This is the content of my modal</p>

            <button @click="$dispatch('close-modal', 'my-modal')">
                Close Modal
            </button>
        </div>
    </x-modals.modal>

</div>
