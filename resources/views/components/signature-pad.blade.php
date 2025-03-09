{{-- resources/views/components/signature-pad.blade.php --}}
<div x-data="signatureCapture(@entangle($attributes->wire('model')))" class="w-full">
    <div class="mb-4">
        <h3 class="text-sm font-medium text-gray-700 mb-2">{{ $attributes->get('label', 'Your Signature') }}</h3>
        
        <div class="border rounded-lg overflow-hidden bg-white">
            <canvas x-ref="signature_canvas" class="w-full" height="200"></canvas>
        </div>
        
        <div class="flex justify-between items-center mt-2">
            <button type="button" @click="clearSignature" 
                class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none">
                Clear Signature
            </button>
            
            <span x-show="!signature" class="text-xs text-gray-500">
                Please sign above
            </span>
            
            <span x-show="signature" class="text-xs text-green-600">
                Signature captured
            </span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('signatureCapture', (wireModel) => ({
            signaturePad: null,
            signature: wireModel,
            
            init() {
                const canvas = this.$refs.signature_canvas;
                
                // Adjust canvas size to match container width with proper DPI
                const context = canvas.getContext('2d');
                const devicePixelRatio = window.devicePixelRatio || 1;
                const rect = canvas.getBoundingClientRect();
                
                canvas.width = rect.width * devicePixelRatio;
                canvas.height = canvas.height * devicePixelRatio;
                context.scale(devicePixelRatio, devicePixelRatio);
                
                // Initialize SignaturePad
                this.signaturePad = new SignaturePad(canvas, {
                    minWidth: 1,
                    maxWidth: 3,
                    penColor: "rgb(0, 0, 0)"
                });
                
                // If there's already a signature, load it
                if (this.signature) {
                    this.signaturePad.fromDataURL(this.signature);
                }
                
                // Update wire model on signature end
                this.signaturePad.addEventListener("endStroke", () => {
                    this.signature = this.signaturePad.toDataURL('image/png');
                });
                
                // Handle window resize
                window.addEventListener('resize', this.resizeCanvas.bind(this));
            },
            
            clearSignature() {
                this.signaturePad.clear();
                this.signature = '';
            },
            
            resizeCanvas() {
                const canvas = this.$refs.signature_canvas;
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const rect = canvas.getBoundingClientRect();
                
                canvas.width = rect.width * ratio;
                canvas.height = canvas.height * ratio;
                const context = canvas.getContext('2d');
                context.scale(ratio, ratio);
                
                // Save signature data
                const data = this.signature ? this.signature : null;
                
                // Clear and redraw
                this.signaturePad.clear();
                if (data) {
                    this.signaturePad.fromDataURL(data);
                }
            }
        }));
    });
</script>