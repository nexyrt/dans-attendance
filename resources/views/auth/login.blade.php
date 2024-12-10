<x-layouts.guest>
    <!-- Login Header -->
    <div class="space-y-4 mb-8">
        <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-800">
            Login to Your Account
        </h1>
        <p class="text-gray-500 dark:text-gray-400">Welcome back! Please enter your details</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email
            </label>
            <div class="relative group">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg blur opacity-25 group-hover:opacity-40 transition duration-200">
                </div>
                <x-input.text type="email" name="email" id="email" :value="old('email')"
                    class="relative w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                    placeholder="Enter your email" required autofocus autocomplete="username" />
            </div>
            <x-shared.error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password
            </label>
            <div class="relative group">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg blur opacity-25 group-hover:opacity-40 transition duration-200">
                </div>
                <x-input.text type="password" name="password" id="password"
                    class="relative w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                    placeholder="Enter your password" required autocomplete="current-password" />
            </div>
            <x-shared.error :messages="$errors->get('password')" class="mt-1 text-sm text-red-500" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                    Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
                class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                Forgot Password?
            </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="relative w-full group">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200">
                </div>
                <div
                    class="relative w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-lg transform transition-all duration-200 group-hover:scale-[0.99] group-active:scale-95">
                    Sign In
                </div>
            </button>
        </div>
    </form>
</x-layouts.guest>