<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-gray-300 font-medium" />
            <x-text-input id="name" class="block mt-2 w-full bg-gray-900/50 border border-gray-700 text-gray-200 focus:border-purple-500 focus:ring-purple-500 rounded-xl px-4 py-3 transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nomor HP -->
        <div class="mt-4">
            <x-input-label for="nomor_hp" :value="__('WhatsApp Number')" class="text-gray-300 font-medium" />
            <div class="relative mt-2">
                <input id="nomor_hp" name="nomor_hp" type="tel"
                       class="block w-full bg-gray-900/50 border border-gray-700 text-gray-200 focus:border-purple-500 focus:ring-purple-500 rounded-xl px-4 py-3 transition-colors"
                       value="{{ old('nomor_hp') }}" required>
            </div>
            <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-300 font-medium" />
            <x-text-input id="email" class="block mt-2 w-full bg-gray-900/50 border border-gray-700 text-gray-200 focus:border-purple-500 focus:ring-purple-500 rounded-xl px-4 py-3 transition-colors" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-300 font-medium" />
            <x-text-input id="password" class="block mt-2 w-full bg-gray-900/50 border border-gray-700 text-gray-200 focus:border-purple-500 focus:ring-purple-500 rounded-xl px-4 py-3 transition-colors"
                          type="password"
                          name="password"
                          required autocomplete="new-password" placeholder="Min. 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-300 font-medium" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full bg-gray-900/50 border border-gray-700 text-gray-200 focus:border-purple-500 focus:ring-purple-500 rounded-xl px-4 py-3 transition-colors"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 focus:ring-purple-500 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-purple-500/25">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 hover:from-purple-300 hover:to-blue-300 transition-all duration-300 ml-1">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>

    {{-- Script Intl Tel Input --}}
    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/css/intlTelInput.min.css" />
    <style>
        .iti { width: 100%; }
        .iti__dropdown-content { background-color: #1f2937; border-color: #374151; color: white; }
        .iti__country-list { background-color: #1f2937; border-color: #374151; }
        .iti__country.iti__highlight { background-color: #374151; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/js/utils.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.querySelector("#nomor_hp");
            const iti = window.intlTelInput(input, {
                initialCountry: "id",
                preferredCountries: ["id", "my", "us"],
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/js/utils.js",
                separateDialCode: true,
            });

            const form = input.closest('form');
            form.addEventListener('submit', function () {
                input.value = iti.getNumber(); // Kirim format internasional
            });
        });
    </script>
    @endpush
</x-guest-layout>
