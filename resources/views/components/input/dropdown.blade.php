<div x-data="{ open: false, selected: '{{ $selected }}', options: @json($options) }" class="relative inline-block text-left w-full">
    <div>
        <button @click="open = !open" @click.away="open = false" type="button"
            class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:shadow-blur-spread"
            id="menu-button" aria-expanded="true" aria-haspopup="true">
            <span x-text="selected"></span>
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707 1.707L7.414 8H13a1 1 0 110 2H7.414l3.293 3.293a1 1 0 01-1.414 1.414l-5-5a1 1 0 010-1.414l5-5A1 1 0 0110 3z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div x-show="open" class="origin-top-right absolute right-0 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none backdrop-filter backdrop-blur-lg bg-opacity-70" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1" role="none">
            <template x-for="option in options" :key="option">
                <a @click="selected = option; open = false" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1" :class="{'bg-gray-100': selected === option}">
                    <span x-text="option"></span>
                </a>
            </template>
        </div>
    </div>
</div>
