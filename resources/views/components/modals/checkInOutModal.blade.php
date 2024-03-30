<div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
    <!-- Modal content -->
    <div class="min-w-80 absolute bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex justify-center p-4 md:p-5 rounded-t">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                <p>Time To <span class="text-green-400">{{ $checkOutModal ? 'Check-Out' : 'Check-In' }}</span></p>
            </h3>
        </div>
        <!-- Modal body -->
        <div class="p-4 text-center md:p-5 space-y-4">
            <p>Hey there, {{ $employee->name }}</p>
            <img class="max-w-20 mx-auto" src= {{ $checkOutModal ? asset('images/log-out.gif') : "https://c.tenor.com/Hw7f-4l0zgEAAAAC/tenor.gif" }} alt="Check-In">
        </div>
        <!-- Modal footer --> 
        <form class="flex items-center p-4 md:p-5 rounded-b dark:border-gray-600"
            action="{{ $checkOutModal ? route('check-out') : route('check-in') }}" method="POST">
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
            <input type="hidden" name="check_in_time" value="{{ date('H:i:s') }}">
            <input type="hidden" name="check_in_date" value="{{ now()->toDateString() }}">
            @if ($checkOutModal)
                <input type="hidden" name="check_out_time" value="{{ date('H:i:s') }}">
            @endif
            <button data-modal-hide="default-modal" type="submit"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mx-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                {{ $checkOutModal ? 'Check-Out' : 'Check-In' }}
            </button>
        </form>
    </div>
</div>
