<x-app-layout>
    @livewire('table', ['model' => \App\Models\User::class, 'columns' => ['name', 'email', 'department', 'position']])
</x-app-layout>