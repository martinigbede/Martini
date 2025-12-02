<x-app-layout>
    {{-- 🔹 Composant global pour le polling toutes les 5s --}}

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-br from-brown-600 to-brown-800 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 bg-gradient-to-r from-gray-900 to-brown-800 bg-clip-text text-transparent">
                        Vente de Services
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Gestion des ventes de services divers</p>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center space-x-2 text-sm text-brown-600 bg-brown-50 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Gérez vos ventes en temps réel</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                {{-- Total Ventes --}}
                <div class="bg-gradient-to-br from-brown-50 to-brown-100 rounded-xl p-4 border border-brown-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-brown-600">Total Ventes</p>
                            <p class="text-2xl font-bold text-brown-900 mt-1">
                                {{ \App\Models\DiversServiceVente::count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-brown-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>

                {{-- Ventes du jour --}}
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Ventes Aujourd'hui</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">
                                {{ \App\Models\DiversServiceVente::whereDate('created_at', today())->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>

                {{-- Chiffre d'affaires --}}
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-600">Chiffre d'affaires</p>
                            <p class="text-2xl font-bold text-amber-900 mt-1">
                                {{ number_format(\App\Models\DiversServiceVente::sum('total') ?? 0, 0) }} FCFA
                            </p>
                        </div>
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>

                {{-- Vente Moyenne --}}
                <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Vente Moyenne</p>
                            <p class="text-2xl font-bold text-purple-900 mt-1">
                                {{ number_format(\App\Models\DiversServiceVente::avg('total') ?? 0, 0) }} FCFA
                            </p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-brown-200 overflow-hidden">
                <div class="bg-gradient-to-r from-brown-50 to-brown-100 border-b border-brown-200 p-6 sticky top-0 z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-brown-900">Liste des Ventes</h3>
                            <p class="text-sm text-brown-600 mt-1">Gérez toutes les ventes de services</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-brown-700 font-medium">
                                    MAJ : {{ now()->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu avec VenteServiceComponent -->
                <div class="overflow-hidden">
                    <div class="max-h-[calc(100vh-300px)] overflow-y-auto">
                        <div class="p-6">
                            @livewire('vente-service-component')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #fdf8f6;
            border-radius: 3px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #bfa094;
            border-radius: 3px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a18072;
        }

        [wire\:poll] {
            transition: all 0.3s ease;
        }
    </style>
</x-app-layout>
