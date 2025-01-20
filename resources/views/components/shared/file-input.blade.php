{{--  resources/views/components/shared/file-input.blade.php --}}
@props([
    'label' => '',
    'id' => null,
    'error' => '',
    'disabled' => false,
    'required' => false,
    'helper' => '',
    'accept' => ''
])

<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-secondary-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-secondary-300 px-6 pt-5 pb-6">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-secondary-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-secondary-600">
                <label for="{{ $id }}" class="relative cursor-pointer rounded-md bg-white font-medium text-primary-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-primary-500 focus-within:ring-offset-2 hover:text-primary-500">
                    <span>Upload a file</span>
                    <input 
                        id="{{ $id }}" 
                        type="file" 
                        {{ $disabled ? 'disabled' : '' }}
                        {{ $required ? 'required' : '' }}
                        {{ $attributes->merge([
                            'class' => 'sr-only',
                            'accept' => $accept
                        ]) }}
                    >
                </label>
                <p class="pl-1">or drag and drop</p>
            </div>
            @if($helper)
                <p class="text-xs text-secondary-500">{{ $helper }}</p>
            @endif
        </div>
    </div>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>