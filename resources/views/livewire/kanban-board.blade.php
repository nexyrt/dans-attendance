{{-- resources/views/livewire/kanban-board.blade.php --}}
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Kanban Board</h2>
        <h3 class="text-4xl text-blue-400 font-bold">PUNYA DANS NJENG</h3>
        {{-- Add New Card Form --}}
        <form wire:submit="createCard" class="bg-white rounded-lg p-4 shadow mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" wire:model="newCard.title"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select wire:model="newCard.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ ucwords(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="newCard.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add Card
            </button>
        </form>
    </div>

    {{-- Kanban Board --}}
    <div class="grid grid-cols-4 gap-4">
        @foreach($statuses as $status)
            <div 
                class="bg-gray-100 p-4 rounded-lg min-h-[500px]" {{-- Added min-height for better drag area --}}
                x-data="{ 
                    dropTarget: null,
                    isDraggingOver: false
                }"
                @dragover.prevent="isDraggingOver = true"
                @dragleave.prevent="isDraggingOver = false"
                @drop.prevent="
                    isDraggingOver = false;
                    $wire.updateCardPosition($event.dataTransfer.getData('cardId'), '{{ $status }}', Array.from($el.children).indexOf(dropTarget))
                "
                :class="{ 'bg-gray-200 border-2 border-dashed border-gray-300 transition-all duration-200': isDraggingOver }"
            >
                <h3 class="font-bold mb-4 text-gray-700">
                    {{ ucwords(str_replace('_', ' ', $status)) }}
                    <span class="text-gray-500 text-sm">({{ count($cards->get($status, [])) }})</span>
                </h3>
                
                <div class="space-y-3">
                    @foreach($cards->get($status, []) as $card)
                        <div
                            x-data="{ isDragging: false }"
                            draggable="true"
                            @dragstart="
                                isDragging = true;
                                $event.target.style.opacity = '1';
                                $event.dataTransfer.setData('cardId', {{ $card->id }});
                                $event.dataTransfer.effectAllowed = 'move';
                            "
                            @dragend="
                                isDragging = false;
                                $event.target.style.opacity = '1';
                            "
                            @dragenter="dropTarget = $event.target.closest('[draggable]')"
                            class="bg-white p-4 rounded-lg shadow-sm cursor-move transform transition-all duration-200 hover:shadow-md"
                            :class="{
                                'ring-2 ring-blue-500 opacity-90': isDragging,
                                'hover:-translate-y-0.5 hover:shadow': !isDragging
                            }"
                        >
                            <div class="flex justify-between items-start">
                                <h4 class="font-semibold text-gray-800">{{ $card->title }}</h4>
                                <span @class([
                                    'px-2 py-1 rounded-full text-xs font-medium',
                                    'bg-red-100 text-red-800' => $card->priority === 'high',
                                    'bg-yellow-100 text-yellow-800' => $card->priority === 'medium',
                                    'bg-green-100 text-green-800' => $card->priority === 'low',
                                ])>
                                    {{ ucfirst($card->priority ?? 'medium') }}
                                </span>
                            </div>

                            @if($card->description)
                                <p class="text-sm text-gray-600 mt-2">{{ $card->description }}</p>
                            @endif

                            @if($card->user)
                                <div class="mt-3 flex items-center">
                                    <div class="flex -space-x-2">
                                        <img src="{{ asset($card->user->image) }}" 
                                             class="w-6 h-6 rounded-full ring-2 ring-white"
                                             alt="{{ $card->user->name }}">
                                    </div>
                                    <div class="ml-2 flex items-center text-xs text-gray-500">
                                        <span>{{ $card->user->name }}</span>
                                        @if($card->due_date)
                                            <span class="mx-1">•</span>
                                            <span>{{ \Carbon\Carbon::parse($card->due_date)->format('M d') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <style>
        /* Ghost image when dragging */
        [draggable]:active {
            cursor: grabbing;
        }
        
        /* Smooth transitions */
        .transition-drag {
            transition: transform 200ms ease, opacity 200ms ease;
        }
        
        /* Column highlight effect */
        .column-highlight {
            background-color: rgb(243 244 246);
            border: 2px dashed rgb(209 213 219);
        }
        
        /* Card hover state */
        .card-hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
    </style>
</div>