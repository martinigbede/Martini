{{-- resources/views/dashboard/gestion/sales.blade.php --}}
<x-app-layout> 
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-brown-900 leading-tight">
                    💰 Gestion des Ventes
                </h2>
                <p class="text-sm text-brown-600 mt-1">Suivi et analyse des ventes restaurant & services</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-brown-100 text-brown-700 rounded-full text-sm font-medium">
                    {{ \App\Models\Sale::count() }} ventes
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-brown-50 to-amber-50 rounded-xl p-4 border border-brown-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-brown-600">Total Ventes</p>
                            <p class="text-2xl font-bold text-brown-900 mt-1">{{ \App\Models\Sale::count() }}</p>
                        </div>
                        <div class="p-2 bg-brown-100 rounded-lg">
                            <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">CA du Jour</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">
                                {{ number_format(\App\Models\Sale::whereDate('date', today())->sum('total'), 0) }} FCFA
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">CA du Mois</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">
                                {{ number_format(\App\Models\Sale::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('total'), 0) }} FCFA
                            </p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Panier Moyen</p>
                            <p class="text-2xl font-bold text-purple-900 mt-1">
                                @php
                                    $totalSales = \App\Models\Sale::count();
                                    $totalRevenue = \App\Models\Sale::sum('total');
                                    $averageBasket = $totalSales > 0 ? $totalRevenue / $totalSales : 0;
                                @endphp
                                {{ number_format($averageBasket, 0) }} FCFA
                            </p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content with Fixed Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-brown-200 overflow-hidden">
                <!-- Fixed Header Section -->
                <div class="bg-gradient-to-r from-brown-50 to-amber-50 border-b border-brown-200 p-6 sticky top-0 z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-brown-900">Historique des Ventes</h3>
                            <p class="text-sm text-brown-600 mt-1">Consultez et gérez l'ensemble des transactions</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-white rounded-lg px-3 py-2 border border-brown-200 shadow-sm">
                                <span class="text-sm text-brown-700 font-medium">
                                    Aujourd'hui : {{ number_format(\App\Models\Sale::whereDate('date', today())->sum('total'), 0) }} FCFA
                                </span>
                            </div>
                            <div class="bg-white rounded-lg px-3 py-2 border border-brown-200 shadow-sm">
                                <span class="text-sm text-brown-700 font-medium">
                                    Mise à jour : {{ now()->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="overflow-hidden">
                    <div class="max-h-[calc(100vh-300px)] overflow-y-auto">
                        <div class="p-6">
                            @livewire('sale.sale-management')
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <style>
        /* Custom scrollbar for better appearance */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #fdf8f6;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #d2bab0;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #bfa094;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Sticky header enhancement */
        .sticky {
            position: -webkit-sticky;
            position: sticky;
        }
    </style>
</x-app-layout>