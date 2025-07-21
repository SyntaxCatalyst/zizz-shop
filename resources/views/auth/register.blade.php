<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-900 border-gray-700 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="nomor_hp" :value="__('Nomor HP')" />
            <input id="nomor_hp" name="nomor_hp" type="tel"
                   class="block mt-1 w-full bg-gray-900 border-gray-700 focus:border-indigo-500 focus:ring-indigo-500"
                   value="{{ old('nomor_hp') }}" required>
            <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-900 border-gray-700 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-900 border-gray-700 focus:border-indigo-500 focus:ring-indigo-500"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-900 border-gray-700 focus:border-indigo-500 focus:ring-indigo-500"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-gray-800 page-transition-link" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Tambahkan script intl-tel-input --}}
    @push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/css/intlTelInput.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/js/utils.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.querySelector("#nomor_hp");
            const iti = window.intlTelInput(input, {
                initialCountry: "id",
                preferredCountries: ["id", "my", "us"],
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19/build/js/utils.js"
            });

            const form = input.closest('form');
            form.addEventListener('submit', function () {
                input.value = iti.getNumber(); // Kirim dalam format internasional
            });
        });
    </script>
    @endpush
</x-guest-layout>
