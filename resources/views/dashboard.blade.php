<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Hello, {{ $user->name }}
            </h2>
            <p class="text-black my-4"><span>Today's time : </span>{{ now()->hour }}.{{ now()->minute }}</p>
        </div>
        <a href="{{ route('activity-logs.edit', ['id' => $user->id]) }}" class='p-2 bg-blue-600 hover:bg-blue-800 focus:bg-blue-500 rounded-lg text-white'>Add Activity</a>
    </x-slot>

    @if (auth()->user()->isAdmin($user->role))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-admin.
                x :dataVariable="$admin_attendance" :employee="$user"></x-admin.index>
            </div>
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-staff.index :dataVariable="$user_attendance" :employee="$user"></x-staff.index>
            </div>
        </div>
    @endif

    {{-- Modal Pop Up Condition --}}

    @if (now()->hour >= 3 && now()->hour < 15.59 && !$attendanceRecordExists)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = false" />
    @elseif (now()->hour >= 16 && now()->hour < 23 && !$hasCheckedOut)
        <x-modals.checkInOutModal :user="$user" :checkOutModal="$checkOutModal = true" />
    @endif

</x-app-layout>
