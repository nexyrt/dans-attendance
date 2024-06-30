<div>
    <input type="text" wire:model="search" placeholder="Search..." class="mb-4 p-2 border rounded">

    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ ucfirst(str_replace('_', ' ', $column)) }}
                    </th>
                @endforeach
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    @foreach ($columns as $column)
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $item->$column }}
                        </td>
                    @endforeach
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $items->links() }}
</div>
