<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Zizz Shop') }}</title>

        <link rel="icon" href="https://files.catbox.moe/5z7z6d.png">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('scripts')
    </head>
    <body class="font-sans antialiased text-gray-300 bg-gray-900 selection:bg-purple-500 selection:text-white">
        
        <!-- Background Effects -->
        <div class="fixed inset-0 z-0 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-900 to-gray-850"></div>
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/5 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/5 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%236366f1\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'1.5\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        </div>

        <div class="relative min-h-screen z-10 flex flex-col">
            
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="glass-panel border-b border-white/5 relative z-20">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-4">
                            <div class="w-1 h-8 bg-gradient-to-b from-purple-500 to-blue-500 rounded-full"></div>
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow py-8 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </body>
</html>