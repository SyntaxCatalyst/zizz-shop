<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300 font-medium" />
            <x-text-input id="email" class="block mt-2 w-full bg-gray-900/50 border border-gray-700 text-gray-200 focus:border-purple-500 focus:ring-purple-500 rounded-xl px-4 py-3 transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-300 font-medium" />
            <x-text-input id="password" class="block mt-2 w-full bg-gray-900/50 border border-gray-700 text-gray-200 focus:border-purple-500 focus:ring-purple-500 rounded-xl px-4 py-3 transition-colors"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-800 border-gray-700 text-purple-600 shadow-sm focus:ring-purple-500 group-hover:border-purple-500 transition-colors" name="remember">
                <span class="ms-2 text-sm text-gray-400 group-hover:text-gray-300 transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Buttons -->
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 focus:ring-purple-500 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-purple-500/25">
                {{ __('Masuk Sekarang') }}
            </button>
        </div>
    </form>
    
    <!-- Google Login -->
    <div class="mt-8">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-800"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-opacity-0 text-gray-500 bg-gray-900/50 backdrop-blur-xl rounded-full">Atau masuk dengan</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl shadow-sm hover:scale-[1.02] transition-all duration-300 group">
                <svg class="h-5 w-5 transition-transform group-hover:scale-110" aria-hidden="TRUE" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.11c-.22-.66-.35-1.36-.35-2.11s.13-1.45.35-2.11V7.05H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.95l3.66-2.84z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.05l3.66 2.84c.87-2.6 3.3-4.51 6.16-4.51z" fill="#EA4335"/>
                </svg>
                <span class="font-semibold tracking-wide text-gray-300 group-hover:text-white transition-colors">Google</span>
            </a>
        </div>
    </div>

    <!-- Registration Link -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 hover:from-purple-300 hover:to-blue-300 transition-all duration-300 ml-1">
                Daftar sekarang
            </a>
        </p>
    </div>
</x-guest-layout>