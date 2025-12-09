<x-app-layout>
    {{-- 🔹 Composant global pour le polling toutes les 5s --}}

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-blue-900 leading-tight">
                    📋 Réservations
                </h2>
                <p class="text-sm text-blue-600 mt-1">Gestion des réservations de l'hôtel</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                    {{ \App\Models\Reservation::count() }} réservations
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Aujourd'hui -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Réservations Aujourd'hui</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">
                                {{ \App\Models\Reservation::whereDate('created_at', today())->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>

                <!-- Confirmées -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Confirmées</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">
                                {{ \App\Models\Reservation::where('statut', 'confirmée')->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>

                <!-- Sejour -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Séjour</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">
                                {{ \App\Models\Reservation::where('statut', 'En séjour')->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>

                <!-- En Attente -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-600">En Attente</p>
                            <p class="text-2xl font-bold text-amber-900 mt-1">
                                {{ \App\Models\Reservation::where('statut', 'En attente')->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <!-- Icon -->
                        </div>
                    </div>
                </div>

                <!-- Chiffre d'Affaires 
                <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Chiffre Affaires</p>
                            <p class="text-2xl font-bold text-purple-900 mt-1">
                                {{ number_format(\App\Models\Reservation::where('statut', 'confirmée')->sum('total') ?? 0, 0) }} FCFA
                            </p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-blue-200 p-6 sticky top-0 z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900">Liste des Réservations</h3>
                            <p class="text-sm text-blue-600 mt-1">Gérez toutes les réservations de l'hôtel</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-blue-700 font-medium">
                                    MAJ : {{ now()->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu avec ReservationManagement -->
                <div class="overflow-hidden">
                    <div class="max-h-[calc(100vh-300px)] overflow-y-auto">
                        <div class="p-6">
                            @livewire('reservation.reservation-management-pro')
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
            background: #f0f9ff;
            border-radius: 3px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #93c5fd;
            border-radius: 3px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #60a5fa;
        }

        [wire\:poll] {
            transition: all 0.3s ease;
        }
    </style>
</x-app-layout>
