@props([
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'name' => null,
])

<div
    x-data="{
        open: false,
        selected: @js($selected),
        options: @js($options),
        
        init() {
            // Initialize Livewire property on component load if selected has a value
            if (this.selected !== null && this.$wire) {
                const name = '{{ $name }}';
                if (name) {
                    this.$nextTick(() => {
                        this.$wire.set(name, this.selected);
                    });
                }
            }
        },
        
        select(value, label) {
            this.selected = value;
            this.open = false;

            // For regular forms
            this.$dispatch('input', value);
            
            // For Livewire integration
            if (this.$wire) {
                const name = '{{ $name }}';
                if (name) {
                    this.$wire.set(name, value);
                }
            }
        },
        
        getSelectedLabel() {
            if (!this.selected) {
                return this.placeholder;
            }
            
            const option = this.options.find(opt => 
                (typeof opt === 'object' ? opt.value == this.selected : opt == this.selected)
            );
            
            return option 
                ? (typeof option === 'object' ? option.label : option) 
                : this.placeholder;
        }
    }"
    x-on:click.away="open = false"
    @if($attributes->whereStartsWith('wire:model')->first())
    x-on:{{ $attributes->whereStartsWith('wire:model')->first() }}-changed.window="selected = $event.detail.value"
    @endif
    {{ $attributes->class(['relative']) }}
>
    <button
        type="button"
        class="w-full flex items-center justify-between rounded-md border border-gray-300 px-3 py-2 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
        x-on:click="open = !open"
    >
        <span x-text="getSelectedLabel()" class="block truncate"></span>
        <span class="pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" x-bind:class="{ 'transform rotate-180': open }">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>
    
    <div
        x-show="open"
        x-cloak
        class="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg border border-gray-300"
    >
        <ul
            class="max-h-60 overflow-auto rounded-md py-1 text-base"
            role="listbox"
        >
            <template x-for="option in options" :key="typeof option === 'object' ? option.value : option">
                <li
                    class="cursor-pointer select-none px-3 py-2 hover:bg-blue-100"
                    x-on:click="select(
                        typeof option === 'object' ? option.value : option, 
                        typeof option === 'object' ? option.label : option
                    )"
                    x-bind:class="{ 'bg-blue-50': (typeof option === 'object' ? option.value : option) == selected }"
                >
                    <span x-text="typeof option === 'object' ? option.label : option"></span>
                </li>
            </template>
        </ul>
    </div>
    
    <input type="hidden" name="{{ $name }}" x-bind:value="selected" />
</div>

<style>
    [x-cloak] { display: none !important; }
</style>