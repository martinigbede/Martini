<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="/favicon.ico" />

    <link rel="stylesheet" href="{{ asset('build/assets/app-BgMLuSsD.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Largeurs desktop */
        body.sidebar-collapsed .sidebar-wrapper {
            width: 80px;
        }
        body.sidebar-expanded .sidebar-wrapper {
            width: 280px;
        }

        /* Mobile : sidebar en overlay */
        @media(max-width: 768px) {
            .sidebar-wrapper {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform .3s ease;
            }
            body.sidebar-expanded .sidebar-wrapper {
                transform: translateX(0);
            }
            body.sidebar-expanded .content-wrapper {
                filter: blur(1px);
            }
        }
    </style>
</head>

<body class="font-sans antialiased sidebar-expanded">

    <x-banner />

    <!-- CONTENEUR PRINCIPAL FLEXBOX -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <div class="sidebar-wrapper transition-all duration-300 bg-white shadow-lg">
            <livewire:sidebar-navigation />
        </div>

        <!-- Contenu -->
        <div class="content-wrapper flex-1 bg-gray-100">
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

    </div>

    @stack('modals')
    @livewireScripts
    <script src="{{ asset('build/assets/app-Bj43h_rG.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

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
        });
    </script>

</body>
</html>