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
    <!-- Modern Select Button -->
    <button
        type="button"
        class="w-full flex items-center justify-between text-sm rounded-md border border-gray-300 px-4 py-2.5 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm hover:bg-gray-50"
        x-on:click="open = !open"
    >
        <span class="flex items-center">
            <span x-text="getSelectedLabel()" class="block truncate text-gray-700 font-medium"></span>
        </span>
        <span class="pointer-events-none ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transition-transform duration-200" 
                :class="{ 'transform rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>
    
    <!-- Dropdown Menu with modern styling -->
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 border border-gray-200 overflow-hidden"
        style="max-height: 224px;"
    >
        <ul
            class="max-h-56 overflow-auto py-1 text-sm scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100"
            role="listbox"
        >
            <template x-for="option in options" :key="typeof option === 'object' ? option.value : option">
                <li
                    class="relative cursor-pointer select-none px-4 py-2.5 hover:bg-blue-50 transition-colors duration-150 truncate"
                    x-on:click="select(
                        typeof option === 'object' ? option.value : option, 
                        typeof option === 'object' ? option.label : option
                    )"
                    :class="{
                        'bg-blue-50 text-blue-700 font-medium': (typeof option === 'object' ? option.value : option) == selected,
                        'text-gray-700': (typeof option === 'object' ? option.value : option) != selected
                    }"
                >
                    <div class="flex items-center">
                        <span x-text="typeof option === 'object' ? option.label : option" class="truncate"></span>
                        <svg x-show="(typeof option === 'object' ? option.value : option) == selected" class="h-4 w-4 ml-1.5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </li>
            </template>
        </ul>
    </div>
    
    <input type="hidden" name="{{ $name }}" x-bind:value="selected" />
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Modern scrollbar for webkit browsers */
    .scrollbar-thin::-webkit-scrollbar {
        width: 4px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 20px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 20px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
    
    /* Firefox scrollbar styling */
    .scrollbar-thin {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f1f1f1;
    }
</style>