<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="icon" href="/favicon.ico" />
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <!-- CSS compilé -->
        <link rel="stylesheet" href="{{ secure_asset('build/assets/app-BgMLuSsD.css') }}">

        <!-- JS compilé -->
        <script src="{{ secure_asset('build/assets/app-Bj43h_rG.js') }}" defer></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        
        {{-- 1. HEADER PUBLIC --}}
        <x-public.header /> 

        {{-- Contenu principal du site (page d'accueil ou réservation) --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- 2. FOOTER PUBLIC --}}
        <x-public.footer />

        @livewireScripts
        @stack('scripts') {{-- Pour les scripts spécifiques aux pages publiques --}}
    </body>
</html>