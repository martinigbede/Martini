<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- CSS compilé -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-BgMLuSsD.css') }}">

    <!-- Vite CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        .main-content {
            transition: margin-left 0.3s ease-in-out;
            min-height: 100vh;
        }
        .sidebar-collapsed .main-content {
            margin-left: 80px;
        }
        .sidebar-expanded .main-content {
            margin-left: 280px;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <x-banner />

    <!-- Sidebar Livewire Component -->
    <livewire:sidebar-navigation />

    <div class="min-h-screen bg-gray-100 main-content" id="mainContent">
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- JS compilé -->
    <script src="{{ asset('build/assets/app-Bj43h_rG.js') }}" defer></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Livewire === 'undefined') {
                console.error('Livewire non chargé !');
                return;
            }

            const mainContent = document.getElementById('mainContent');

            Livewire.on('sidebar-toggled', (data) => {
                if (data.collapsed) {
                    document.body.classList.add('sidebar-collapsed');
                    document.body.classList.remove('sidebar-expanded');
                } else {
                    document.body.classList.add('sidebar-expanded');
                    document.body.classList.remove('sidebar-collapsed');
                }
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                document.body.classList.add('sidebar-collapsed');
            } else {
                document.body.classList.add('sidebar-expanded');
            }

            // Désactiver la navigation si wire:navigate est utilisé
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.hasAttribute('wire:navigate')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
