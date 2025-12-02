{{-- resources/views/admin/room-types.blade.php --}}
<x-app-layout> 
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-brown-900 leading-tight">
                    🏨 Types de Chambres
                </h2>
                <p class="text-sm text-brown-600 mt-1">Gestion des catégories de chambres de l'hôtel</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-brown-100 text-brown-700 rounded-full text-sm font-medium">
                    {{ \App\Models\RoomType::count() }} types
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
                            <p class="text-sm font-medium text-brown-600">Total Types</p>
                            <p class="text-2xl font-bold text-brown-900 mt-1">{{ \App\Models\RoomType::count() }}</p>
                        </div>
                        <div class="p-2 bg-brown-100 rounded-lg">
                            <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Prix Moyen</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">
                                {{ number_format(\App\Models\RoomType::avg('prix_base') ?? 0, 0) }} FCFA
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
                            <p class="text-sm font-medium text-blue-600">Capacité Moy.</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">
                                {{ number_format(\App\Models\RoomType::avg('nombre_personnes_max') ?? 0, 1) }} pers.
                            </p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Chambres Actives</p>
                            <p class="text-2xl font-bold text-purple-900 mt-1">
                                {{ \App\Models\Room::count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
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
                            <h3 class="text-lg font-semibold text-brown-900">Liste des Types de Chambres</h3>
                            <p class="text-sm text-brown-600 mt-1">Gérez les différentes catégories de chambres disponibles</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-white rounded-lg px-3 py-2 border border-brown-200 shadow-sm">
                                <span class="text-sm text-brown-700 font-medium">
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
                            @livewire('room-type.room-type-management')
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
    </style>
</x-app-layout>