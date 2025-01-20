@props([
    'label' => 'Select Option',
    'name' => '',
    'options' => [],
    'selected' => 'all',
    'isLivewire' => false
])

<div class="hs-dropdown relative inline-flex">
    <button 
        type="button" 
        class="hs-dropdown-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50"
    >
        {{ $label }}
        <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m6 9 6 6 6-6"/>
        </svg>
    </button>

    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden z-10 mt-2 min-w-[15rem] bg-white shadow-md rounded-lg p-2">
        @foreach($options as $option)
            <button 
                type="button"
                @if($isLivewire)
                    wire:click="$set('{{ $name }}', '{{ $option['value'] }}')"
                @else
                    onclick="this.closest('.hs-dropdown').querySelector('input[type=hidden]').value = '{{ $option['value'] }}'"
                @endif
                class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 w-full text-left"
            >
                {{ $option['label'] }}
            </button>
        @endforeach
    </div>

    @unless($isLivewire)
        <input type="hidden" name="{{ $name }}" value="{{ $selected }}">
    @endunless
</div>