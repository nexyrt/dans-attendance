{{-- resources/views/components/input/dropdown.blade.php --}}

@props([
    'align' => 'right',
    'width' => '56',
    'contentClasses' => 'py-1 bg-white divide-y divide-gray-100',
    'items' => [],
    'wire' => null,
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'left-0',
        'right' => 'right-0',
        'top' => 'top-0',
        'bottom' => 'bottom-0',
        default => 'right-0',
    };

    $widthClasses = "w-{$width}";
@endphp

<div x-data="{ open: false }" class="relative" @click.away="open = false">
    {{-- Trigger --}}
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    {{-- Content --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute {{ $alignmentClasses }} mt-2 {{ $widthClasses }} rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 {{ $contentClasses }}"
        style="display: none;">
        @foreach ($items as $section)
            <div class="py-1">
                @foreach ($section as $item)
                    @if (isset($item['type']) && $item['type'] === 'link')
                        <a href="{{ $item['href'] }}"
                            class="group flex items-center px-4 py-2 text-sm {{ $item['class'] ?? 'text-gray-700 hover:bg-gray-50' }}">
                            @if (isset($item['icon']))
                                <svg class="mr-3 h-5 w-5 {{ $item['iconClass'] ?? 'text-gray-400 group-hover:text-gray-500' }}"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    {!! $item['icon'] !!}
                                </svg>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @elseif (isset($item['type']) && $item['type'] === 'button')
                        <form method="{{ $item['method'] ?? 'POST' }}" action="{{ $item['action'] }}">
                            @csrf
                            <button type="submit"
                                class="group flex w-full items-center px-4 py-2 text-sm {{ $item['class'] ?? 'text-gray-700 hover:bg-gray-50' }}">
                                @if (isset($item['icon']))
                                    <svg class="mr-3 h-5 w-5 {{ $item['iconClass'] ?? 'text-gray-400 group-hover:text-gray-500' }}"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        {!! $item['icon'] !!}
                                    </svg>
                                @endif
                                {{ $item['label'] }}
                            </button>
                        </form>
                    @else
                        {{-- Default to regular option --}}
                        <button wire:click="$set('{{ $wire }}', '{{ $item['value'] }}')" @click="open = false"
                            type="button"
                            class="w-full text-left px-4 py-2 text-sm {{ $item['class'] ?? 'text-gray-700 hover:bg-gray-50' }}">
                            {{ $item['label'] }}
                        </button>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div>
