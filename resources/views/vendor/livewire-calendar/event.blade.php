<div @if ($eventClickEnabled) wire:click.stop="onEventClick('{{ $event['id'] }}')" @endif
    class="group bg-white rounded-lg border border-gray-100 cursor-pointer hover:shadow-md hover:-translate-y-0.5 transform transition-all duration-200 relative overflow-hidden"
    style="background-color: {{ $event['backgroundColor'][1] }}">

    <!-- Left Color Bar -->
    <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-lg"
        style="background-color: {{ $event['backgroundColor'][0] }}">
    </div>

    <!-- Content -->
    <div class="flex-1 p-3 pl-4">
        <!-- Header -->
        <div class="flex items-start justify-between mb-2">
            <div class="flex-1">
                <h4 class="text-sm font-semibold capitalize leading-snug truncate group-hover:text-{{ $event['backgroundColor'][0] }} transition-colors duration-200"
                    style="color: {{ $event['backgroundColor'][0] }}">
                    {{ $event['title'] }}
                </h4>

                <!-- Time if available -->
                @if ($event['start_time'])
                    <div class="flex items-center mt-1 space-x-2">
                        <i class='bx bx-time text-sm' style="color: {{ $event['backgroundColor'][0] }}"></i>
                        <span class="text-xs text-gray-600">
                            {{ \Carbon\Carbon::parse($event['start_time'])->format('H:i') }}
                            @if ($event['end_time'])
                                - {{ \Carbon\Carbon::parse($event['end_time'])->format('H:i') }}
                            @endif
                        </span>
                    </div>
                @endif
            </div>

            <!-- Status Indicator -->
            <div class="relative group">
                <div class="w-2 h-2 rounded-full bg-opacity-50 group-hover:w-auto group-hover:px-2 group-hover:h-5 transition-all duration-200 flex items-center"
                    style="background-color: {{ $event['backgroundColor'][0] }}">
                    <span
                        class="text-[10px] font-medium opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 text-white">
                        {{ ucfirst($event['status']) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if ($event['description'])
            <div class="relative">
                <p class="text-xs text-gray-600 line-clamp-2 group-hover:text-gray-700 transition-colors duration-200">
                    {{ $event['description'] ?? 'No description' }}
                </p>
                <!-- Fade out effect for long descriptions -->
                <div class="absolute bottom-0 right-0 left-0 h-4 bg-gradient-to-t from-white to-transparent"></div>
            </div>
        @endif

        <!-- Footer -->
        <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
            <!-- Tag/Category -->
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-opacity-10"
                    style="background-color: {{ $event['backgroundColor'][0] }}; color: {{ $event['backgroundColor'][0] }}">
                    {{ $event['status'] }}
                </span>
            </div>

            <!-- Quick Actions (visible on hover) -->
            <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                <button class="p-1 rounded hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class='bx bx-pencil text-sm'></i>
                </button>
                <button class="p-1 rounded hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class='bx bx-trash text-sm'></i>
                </button>
            </div>
        </div>
    </div>

    

    <!-- Optional: Progress indicator -->
    @if (isset($event['progress']))
        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-100">
            <div class="h-full transition-all duration-200"
                style="width: {{ $event['progress'] }}%; background-color: {{ $event['backgroundColor'][0] }}">
            </div>
        </div>
    @endif
</div>
