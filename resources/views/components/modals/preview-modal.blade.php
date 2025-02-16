@props([
    'show' => false,
    'previewUrl' => '',
    'previewType' => '',
])

@if ($show)
    <div x-data="{ 
            show: @entangle('showPreview'),
            init() {
                document.body.style.overflow = 'hidden';
                this.$watch('show', value => {
                    document.body.style.overflow = value ? 'hidden' : 'auto';
                });
            }
        }" 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto" 
        @keydown.escape.window="$wire.closePreview()">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <!-- Modal -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden relative"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                @click.away="$wire.closePreview()">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Document Preview</h3>
                    <button wire:click="closePreview" 
                        class="text-gray-400 hover:text-gray-500 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-4">
                    @if ($previewType === 'pdf')
                        <iframe src="{{ $previewUrl }}" class="w-full h-[70vh] border-0"
                            type="application/pdf"></iframe>
                    @elseif(in_array($previewType, ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ $previewUrl }}" alt="Document Preview"
                            class="max-w-full h-auto mx-auto"
                            x-show="show"
                            x-transition:enter="transition ease-out duration-300 delay-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100">
                    @elseif(in_array($previewType, ['doc', 'docx']))
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-blue-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-600 mb-4">Preview not available for Word documents</p>
                            <a href="{{ $previewUrl }}" download
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Document
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif