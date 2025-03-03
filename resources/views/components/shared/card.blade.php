{{-- resources/views/components/shared/card.blade.php --}}

@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow p-6 ' . $class]) }}>
    {{ $slot }}
</div>