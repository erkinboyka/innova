<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-white antialiased selection:bg-red-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mesh-gradient relative">
            <div class="absolute inset-0 bg-black/40 pointer-events-none"></div>
            
            <div class="relative z-10 w-full flex flex-col items-center">
                <div class="mb-8">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-12 h-12 bg-gradient-to-tr from-red-600 to-green-600 rounded-xl flex items-center justify-center shadow-lg glow-red">
                            <span class="text-white font-black text-2xl">N</span>
                        </div>
                        <span class="text-2xl font-black tracking-tighter text-white uppercase">Innovation<span class="text-red-500">TJ</span></span>
                    </a>
                </div>

                <div class="w-full sm:max-w-xl px-10 py-10 glass-card overflow-hidden rounded-[32px]">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
