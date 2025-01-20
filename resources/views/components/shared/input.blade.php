{{-- resources/views/components/shared/input.blade.php --}}

@props([
    'label' => '',
    'id' => null,
    'error' => '',
    'type' => 'text',
    'disabled' => false,
    'required' => false,
    'helper' => ''
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

    <input 
        type="{{ $type }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'mt-1 block w-full rounded-md border-secondary-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm' . 
            ($error ? ' border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : '') . 
            ($disabled ? ' bg-secondary-50 cursor-not-allowed' : '')
        ]) }}
    >

    @if($helper)
        <p class="mt-1 text-sm text-secondary-500">{{ $helper }}</p>
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>