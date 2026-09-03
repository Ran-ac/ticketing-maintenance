<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ticketing Maintenance') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-cover bg-center"
             style="background-image: url('{{ asset('img/warehouse-bg.jpg') }}');">

            <!-- Dark overlay so the form stays legible over the photo -->
            <div class="absolute inset-0 bg-gray-900/70"></div>

            <!-- App name, replaces the logo -->
            <div class="flex justify-center pb-2">
                <a href="#" class="flex flex-col items-center space-x-2">
                    <img src="{{ asset('img/ggclogo.png') }}" alt="Logo" class="h-[70px] invert brightness-0 w-auto">
                    <div class="hidden lg:block text-xl font-nunito font-semibold text-white drop-shadow-md">Ticketing System Maintenance</div>
                </a>
            </div>

            <!-- Auth card -->
            <div class="relative z-10 w-full sm:max-w-md">
                <div class="bg-white/95 backdrop-blur-sm shadow-xl rounded-2xl overflow-hidden">
                    <div class="px-8 py-8">
                        {{ $slot }}
                    </div>
                </div>

                <p class="mt-6 text-center text-sm text-white/80">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Ticketing Maintenance') }}. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
