<div
    @if($eventClickEnabled)
        wire:click.stop="onEventClick('{{ $event['id']  }}')"
    @endif
    class="relative cursor-pointer group transition-colors"
    style="background-color: {{ $event['backgroundColor'][0] }}">

    <!-- Left accent line with darker shade -->
    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l" style="background-color: {{ $event['backgroundColor'][1] }}">
    </div>

    <!-- Content container -->
    <div class="p-2 pl-3">
        <p class="text-sm font-medium capitalize" style="color: {{ $event['backgroundColor'][1] }}">
            {{ $event['title'] }}
        </p>
        <p class="mt-2 text-xs" style="color: {{ $event['backgroundColor'][1] }}">
            {{ $event['description'] ?? 'No description' }}
        </p>
    </div>
</div>