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

    <style>
        /* Style ini untuk memastikan background dan text utama sesuai tema gelap kita */
        body {
            font-family: 'Inter', sans-serif;
        }
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .page-background-glow {
            background-image:
                radial-gradient(ellipse 50% 50% at 30% -10%, rgba(129, 140, 248, 0.15), transparent),
                radial-gradient(ellipse 50% 50% at 70% 110%, rgba(59, 130, 246, 0.15), transparent);
        }
    </style>
</head>
<body class="font-sans text-gray-900 dark:text-gray-100 antialiased">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 px-4 sm:pt-0 bg-gray-900 page-background-glow">
        {{-- Logo --}}
        <div>
            <a href="/">
                <h1 class="text-4xl font-black text-gradient">
                    {{ config('app.name', 'Zizz-Shop') }}
                </h1>
            </a>
        </div>

        {{-- Kartu Form --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-gray-800/50 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-700">
            {{-- Aksen Garis Gradien di Atas --}}
            <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full mb-8"></div>

            {{-- Di sinilah form login atau register Anda akan ditampilkan --}}
            {{ $slot }}
        </div>
    </div>

</body>
</html>