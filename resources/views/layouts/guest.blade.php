<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="font-sans antialiased text-gray-300 bg-gray-900 selection:bg-purple-500 selection:text-white">

    <div class="min-h-screen flex flex-col justify-center items-center pt-6 px-4 sm:pt-0 relative overflow-hidden">
        {{-- Background Effects --}}
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-900 to-gray-850 z-[-2]"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%236366f1\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'1.5\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] z-[-1]"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>

        {{-- Logo --}}
        <div class="mb-8 text-center relative z-10">
            <a href="/" class="group">
                <h1 class="text-5xl font-black tracking-tight text-gradient group-hover:scale-105 transition-transform duration-300">
                    {{ config('app.name', 'ZizzMarket') }}
                </h1>
                <p class="mt-2 text-sm text-gray-400 font-medium tracking-wide uppercaselt">Premium Digital Store</p>
            </a>
        </div>

        {{-- Glass Card --}}
        <div class="w-full sm:max-w-md px-8 py-10 glass-panel rounded-3xl relative z-10 card-hover">
            {{-- Decorative Top Bar --}}
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/3 h-1 bg-gradient-to-r from-purple-500 via-blue-500 to-purple-500 rounded-b-full shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>

            {{ $slot }}
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center text-sm text-gray-500 relative z-10">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>