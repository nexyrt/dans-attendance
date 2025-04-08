<div>
    <x-modals.modal name="signature-modal" maxWidth="md">
        <div x-data="signaturePad()">
            <h1 class="text-xl font-semibold text-gray-700 flex items-center justify-between">
                <div>
                    <canvas x-ref="signature_canvas" class="border rounded shadow">
                    </canvas>
                </div>
            </h1>
            <button x-on:click="upload" class="text-black bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 1a9 9 0 100 18 9 9 0 000-18zm1 14.414V11h3.586l-4.293-4.293L8.414 7.586l4.293 4.293H11v4.414z"/>
                </svg>
                Submit
            </button>
        </div>
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
                upload(){
                    @this.set('signature', this.signaturePadInstance.toDataURL('image/png'));
                    @this.call('submit');
                }
            }))
        })
    </script>
</div>