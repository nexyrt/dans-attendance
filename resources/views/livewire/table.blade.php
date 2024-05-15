<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live="search" placeholder="Search..." class="input">

        <div class="flex space-x-2">
            @foreach ($columns as $column)
                <input type="text" wire:model.live="filters.{{ $column }}"
                    placeholder="{{ ucfirst($column) }}" class="input">
            @endforeach
        </div>
    </div>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th class="py-2 px-4">{{ ucfirst($column) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    @foreach ($columns as $column)
                        <td class="py-2 px-4">{{ $item->$column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>
