<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'InnovationTJ') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @isset($head)
            {{ $head }}
        @endisset
    </head>
    <body class="bg-[#080d12] font-sans antialiased text-slate-100 selection:bg-emerald-400 selection:text-slate-950">
        <div class="min-h-screen bg-[#080d12]">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-white/8 bg-[#0c131a]">
                    <div class="mx-auto max-w-[1480px] px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
