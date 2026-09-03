<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-900">Email</label>
            <input id="email" type="text"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

<!-- Password -->
<div>
    <label for="password" class="block text-sm font-bold text-gray-900">Password</label>
    <div class="relative">
        <input id="password" type="password"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
            name="password" required autocomplete="current-password" placeholder="Enter your password">
        <button type="button" tabindex="-1" class="absolute right-0 top-1/2 transform -translate-y-1/2 cursor-pointer text-sm text-gray-500 px-2 focus:outline-none" onclick="togglePasswordVisibility('password', this)">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#999999"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
        </button>
    </div>
    @error('password')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-white/80 border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const isPassword = input.type === 'password';

        input.type = isPassword ? 'text' : 'password';

        // Swap the icon: eye (show) <-> eye-off (hide)
        btn.innerHTML = isPassword
            ? `<svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#999999"><path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q146 0 266 81.5T920-500q-23 53-57.5 101T772-302ZM620-829 480-716l-24 24-56-56 140-140 56 56ZM480-280q-146 0-266-81.5T40-500q23-53 57.5-101T188-698l56 56q-38 29-67.5 63.5T128-500q50 101 143.5 160.5T480-280q26 0 51-3.5t49-9.5l58 58q-30 12-62 18.5t-96 6.5ZM380-604l128 128q-16 8-32 8t-32-8q-27-27-27-64t27-64q0-8 8-16Zm168-32-98-98q-8-4-16-6t-18-2q45 0 76.5 31.5T588-680q0 10-2 18t-6 16Z"/></svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#999999"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>`;
    }
</script>