{{-- resources/views/components/shared/radio.blade.php --}}
@props([
    'label' => '',
    'id' => null,
    'error' => '',
    'disabled' => false,
    'helper' => ''
])

<div class="flex items-start">
    <div class="flex h-5 items-center">
        <input
            type="radio"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => 'h-4 w-4 border-secondary-300 text-primary-600 focus:ring-primary-500' . 
                ($disabled ? ' bg-secondary-50 cursor-not-allowed' : '')
            ]) }}
        >
    </div>
    @if($label)
        <div class="ml-3 text-sm">
            <label for="{{ $id }}" class="font-medium text-secondary-700">{{ $label }}</label>
            @if($helper)
                <p class="text-secondary-500">{{ $helper }}</p>
            @endif
        </div>
    @endif
</div>