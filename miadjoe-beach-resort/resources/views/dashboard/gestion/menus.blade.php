{{-- resources/views/dashboard/gestion/menus.blade.php --}}
<x-app-layout> 
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-amber-900 leading-tight">
                    🍽️ Gestion des Menus
                </h2>
                <p class="text-sm text-amber-600 mt-1">Gestion de la carte et des plats du restaurant</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm font-medium">
                    {{ \App\Models\Menu::count() }} plats
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-600">Total Plats</p>
                            <p class="text-2xl font-bold text-amber-900 mt-1">
                                {{ \App\Models\Menu::count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Plats Disponibles</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">
                                {{ \App\Models\Menu::where('disponibilite', true)->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Prix Moyen</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">
                                {{ number_format(\App\Models\Menu::avg('prix') ?? 0, 0) }} FCFA
                            </p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Catégories</p>
                            <p class="text-2xl font-bold text-purple-900 mt-1">
                                {{ \App\Models\Menu::distinct('category_id')->count('category_id') }}
                            </p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content with Fixed Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-amber-200 overflow-hidden">
                <!-- Fixed Header Section -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-200 p-6 sticky top-0 z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-amber-900">Carte du Restaurant</h3>
                            <p class="text-sm text-amber-600 mt-1">Gérez les plats, catégories et disponibilités</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Filtres -->
                            <select class="bg-white rounded-lg px-3 py-2 border border-amber-200 shadow-sm text-sm text-amber-700">
                                <option>Toutes les catégories</option>
                                <option>Entrées</option>
                                <option>Plats principaux</option>
                                <option>Desserts</option>
                                <option>Boissons</option>
                            </select>
                            <div class="bg-white rounded-lg px-3 py-2 border border-amber-200 shadow-sm">
                                <span class="text-sm text-amber-700 font-medium">
                                    Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="overflow-hidden">
                    <div class="max-h-[calc(100vh-300px)] overflow-y-auto">
                        <div class="p-6">
                            @livewire('menu.menu-management')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar for amber theme */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #fffbeb;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #fcd34d;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #f59e0b;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</x-app-layout>