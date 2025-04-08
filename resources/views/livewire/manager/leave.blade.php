<div>
    <x-modals.modal name="signature-modal" maxWidth="md">
        <div x-data="signaturePad()">
            <h1 class="text-xl font-semibold text-gray-700 flex items-center justify-between">
                <div>
                    <canvas x-ref="signature_canvas" class="border rounded shadow">
                    </canvas>
                </div>
            </h1>
        </div>
        <button x-on:click="upload" class="text-white">
            Submit
        </button>
    </x-modals.modal>

    <button @click="$dispatch('open-modal', 'signature-modal')" class="px-4 py-2 bg-blue-500 text-white rounded">
        Sign Document
    </button>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                signaturePadInstance: null,
                init() {
                    this.signaturePadInstance = new SignaturePad(this.$refs.signature_canvas);
                },
            }))
        })
    </script>
</div>
