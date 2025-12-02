{{-- resources/views/livewire/direction/direction-dashboard.blade.php --}}
<div wire:poll.60s class="p-6 bg-gradient-to-br from-brown-50 to-amber-50/30 min-h-screen">

    {{-- HEADER --}}
<div class="mb-8 flex items-center justify-between">

    {{-- TITRE À GAUCHE --}}
    <div>
        <h2 class="text-3xl font-bold text-brown-900 mb-1 flex items-center">
            <span class="inline-flex items-center justify-center w-10 h-10 bg-brown-100 rounded-xl mr-3">📊</span>
            Tableau de Bord - Direction
        </h2>
        <p class="text-brown-600 text-lg">Vue d'ensemble des revenus et performances globales</p>
    </div>

    {{-- BOUTONS À DROITE --}}
    <div class="flex gap-2">

        <button wire:click="$set('filterMode', 'week'); refreshData()" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Hebdomadaire
        </button>

        <button wire:click="$set('filterMode', 'month'); refreshData()" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Mensuel
        </button>

        <button wire:click="$set('filterMode', 'custom')" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Personnalisé
        </button>

        <button wire:click="exportPDF" 
                class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
            Export PDF
        </button>
        <button wire:click="refreshData"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
            Actualiser
        </button>

    </div>
    </div>

    {{-- FILTRE PERSONNALISÉ --}}
    @if($filterMode === 'custom')
    <div class="flex gap-2 mb-4 items-center">
        <input type="date" wire:model="startDate" class="form-control rounded-lg border-gray-300">
        <input type="date" wire:model="endDate" class="form-control rounded-lg border-gray-300">

        <button wire:click="refreshData" 
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            Filtrer
        </button>
    </div>
    @endif

    {{-- KPI PRINCIPAUX --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Revenu Hôtel --}}
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl p-6 shadow-lg border border-blue-100 hover:-translate-y-1 hover:shadow-xl transition-all">
            <p class="text-sm font-semibold text-blue-600 mb-2">Revenu Hôtel (Mois)</p>
            <p class="text-2xl font-bold text-blue-900">{{ number_format($totalRevenueHotel, 0, ',', ' ') }} FCFA</p>
        </div>

        {{-- Revenu Restaurant --}}
        <div class="bg-gradient-to-br from-white to-green-50 rounded-2xl p-6 shadow-lg border border-green-100 hover:-translate-y-1 hover:shadow-xl transition-all">
            <p class="text-sm font-semibold text-green-600 mb-2">Revenu Restaurant (Mois)</p>
            <p class="text-2xl font-bold text-green-900">{{ number_format($totalRevenueRestaurant, 0, ',', ' ') }} FCFA</p>
        </div>

        {{-- Revenu Divers Services --}}
        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl p-6 shadow-lg border border-amber-100 hover:-translate-y-1 hover:shadow-xl transition-all">
            <p class="text-sm font-semibold text-amber-600 mb-2">Revenu Services Divers</p>
            <p class="text-2xl font-bold text-amber-900">{{ number_format($totalRevenueDivers, 0, ',', ' ') }} FCFA</p>
        </div>

        {{-- Total Global --}}
        <div class="bg-gradient-to-br from-white to-purple-50 rounded-2xl p-6 shadow-lg border border-purple-100 hover:-translate-y-1 hover:shadow-xl transition-all">
            <p class="text-sm font-semibold text-purple-600 mb-2">Revenu Global (Mois)</p>
            <p class="text-2xl font-bold text-purple-900">{{ number_format($totalRevenueGlobal, 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    {{-- AUTRES INDICATEURS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        {{-- Paiements totaux --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-amber-100">
            <p class="text-sm font-semibold text-amber-600 mb-1">Paiements reçus</p>
            <p class="text-xl font-bold text-amber-900">{{ number_format($totalPayments, 0, ',', ' ') }} FCFA</p>
        </div>

        {{-- Montant dû --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100">
            <p class="text-sm font-semibold text-red-600 mb-1">Montant dû (non payé)</p>
            <p class="text-xl font-bold text-red-900">{{ number_format($totalDue, 0, ',', ' ') }} FCFA</p>
        </div>

        {{-- Taux d’occupation --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-blue-100">
            <p class="text-sm font-semibold text-blue-600 mb-1">Taux d’occupation</p>
            <p class="text-xl font-bold text-blue-900">{{ $occupationRate }} %</p>
            <p class="text-sm text-gray-500 mt-1">Chambres occupées : {{ $occupiedRooms }} / {{ $totalRooms }}</p>
        </div>
    </div>

    {{-- TABLEAUX DU JOUR --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

        {{-- Arrivées du jour --}}
        <div class="bg-white rounded-2xl shadow-lg border border-brown-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-blue-200">
                <h3 class="text-lg font-bold text-blue-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Arrivées du jour
                    <span class="ml-2 text-sm text-blue-600 bg-white px-2 py-1 rounded-full">
                        {{ count($reservationsToday) }}
                    </span>
                </h3>
            </div>

            <div class="p-4">
                @if(count($reservationsToday) === 0)
                    <p class="text-center text-gray-500 py-6">Aucune arrivée aujourd'hui</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-brown-600 text-xs font-semibold uppercase tracking-wide">
                                <th class="px-4 py-2 border-b">Client</th>
                                <th class="px-4 py-2 border-b">Check-in</th>
                                <th class="px-4 py-2 border-b">Check-out</th>
                                <th class="px-4 py-2 border-b">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brown-100">
                            @foreach($reservationsToday as $res)
                                <tr>
                                    <td class="px-4 py-2">{{ $res['client'] }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($res['check_in'])->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($res['check_out'])->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded
                                        @if($res['statut'] === 'En attente') bg-gray-200 text-gray-700
                                        @elseif($res['statut'] === 'Confirmée') bg-green-100 text-green-700
                                        @elseif($res['statut'] === 'Terminée') bg-black text-white
                                        @elseif($res['statut'] === 'Annulée') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif">
                                        {{ $res['statut'] }}
                                    </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Ventes du jour --}}
        <div class="bg-white rounded-2xl shadow-lg border border-brown-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-green-200">
                <h3 class="text-lg font-bold text-green-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Ventes du jour
                    <span class="ml-2 text-sm text-green-600 bg-white px-2 py-1 rounded-full">
                        {{ count($salesToday) }}
                    </span>
                </h3>
            </div>

            <div class="p-4">
                @if(count($salesToday) === 0)
                    <p class="text-center text-gray-500 py-6">Aucune vente enregistrée aujourd'hui</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-brown-600 text-xs font-semibold uppercase tracking-wide">
                                <th class="px-4 py-2 border-b">ID Vente</th>
                                <th class="px-4 py-2 border-b">Articles</th>
                                <th class="px-4 py-2 border-b text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brown-100">
                            @foreach($salesToday as $sale)
                                <tr>
                                    <td class="px-4 py-2">#{{ $sale['id'] }}</td>
                                    <td class="px-4 py-2">{{ $sale['items_count'] }}</td>
                                    <td class="px-4 py-2 text-right text-green-700 font-semibold">
                                        {{ number_format($sale['total'], 0, ',', ' ') }} FCFA
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- INDICATEUR DE MISE À JOUR --}}
    <div class="mt-8 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-brown-100 text-brown-700">
            <svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Mise à jour automatique toutes les 60 secondes
        </span>
    </div>
</div>
