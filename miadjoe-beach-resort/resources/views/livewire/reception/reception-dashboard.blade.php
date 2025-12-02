<div class="p-6 bg-gradient-to-br from-brown-50 to-amber-50/30 min-h-screen">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
        <div class="mb-4 lg:mb-0">
            <h2 class="text-3xl font-bold text-brown-900 mb-2">Dashboard Réception</h2>
            <p class="text-brown-600 text-lg">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-brown-500 bg-white/80 px-3 py-1.5 rounded-full border border-brown-200">
                🔄 Mise à jour automatique toutes les {{ $pollInterval }}s
            </span>
            <button wire:click="loadAll" 
                    class="px-4 py-2.5 bg-gradient-to-r from-brown-600 to-brown-700 text-white rounded-xl hover:from-brown-700 hover:to-brown-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Rafraîchir
            </button>
        </div>
    </div>

    {{-- KPI Cards modernisées --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-gradient-to-br from-white to-brown-50 rounded-2xl p-6 shadow-lg border border-brown-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brown-600 text-sm font-semibold mb-2">Arrivées du jour</p>
                    <p class="text-3xl font-bold text-brown-900">{{ $arrivalsCount }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-brown-50 rounded-2xl p-6 shadow-lg border border-brown-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brown-600 text-sm font-semibold mb-2">Départs du jour</p>
                    <p class="text-3xl font-bold text-brown-900">{{ $departuresCount }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-brown-50 rounded-2xl p-6 shadow-lg border border-brown-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brown-600 text-sm font-semibold mb-2">Taux d'occupation</p>
                    <p class="text-3xl font-bold text-brown-900">{{ $occupancyRate }}%</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-brown-50 rounded-2xl p-6 shadow-lg border border-brown-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brown-600 text-sm font-semibold mb-2">Confirmées</p>
                    <p class="text-3xl font-bold text-brown-900">{{ $confirmedCount }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-brown-50 rounded-2xl p-6 shadow-lg border border-brown-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brown-600 text-sm font-semibold mb-2">En attente</p>
                    <p class="text-3xl font-bold text-brown-900">{{ $pendingCount }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables side-by-side --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" wire:poll.{{ $pollInterval }}s="loadAll">

        {{-- Arrivées du jour --}}
        <div class="bg-white rounded-2xl shadow-lg border border-brown-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-green-200">
                <h3 class="text-lg font-bold text-green-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Arrivées du jour
                    <span class="ml-2 text-sm font-normal text-green-600 bg-white px-2 py-1 rounded-full">
                        {{ count($arrivals) }}
                    </span>
                </h3>
            </div>
            
            <div class="p-4">
                @if(count($arrivals) === 0)
                    <div class="text-center py-8 text-brown-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-lg font-medium">Aucune arrivée prévue aujourd'hui</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-brown-600 text-xs font-semibold uppercase tracking-wide">
                                    <th class="px-4 py-3 border-b border-brown-100">Client</th>
                                    <th class="px-4 py-3 border-b border-brown-100">Chambre</th>
                                    <th class="px-4 py-3 border-b border-brown-100">Statut</th>
                                    <th class="px-4 py-3 border-b border-brown-100 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brown-100">
                                @foreach($arrivals as $r)
                                    <tr class="hover:bg-brown-50/50 transition-colors duration-150">
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-brown-900">{{ data_get($r, 'client.nom', data_get($r,'client.name', '—')) }}</div>
                                            <div class="text-xs text-brown-500">{{ data_get($r,'check_in') }} → {{ data_get($r,'check_out') }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @foreach($r->items as $item)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $item->room?->numero ?? '—' }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ data_get($r,'statut') === 'confirmé' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ data_get($r,'statut') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button wire:click="checkIn({{ $r['id'] }})" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-xs rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-sm">
                                                    Check-in
                                                </button>
                                                <button class="inline-flex items-center px-3 py-1.5 border border-brown-300 text-brown-700 text-xs rounded-lg hover:bg-brown-50 transition-all duration-200">
                                                   <a href="{{ route('dashboard.gestion.reservations') }}" > Voir</a>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Départs du jour --}}
        <div class="bg-white rounded-2xl shadow-lg border border-brown-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-4 border-b border-red-200">
                <h3 class="text-lg font-bold text-red-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Départs du jour
                    <span class="ml-2 text-sm font-normal text-red-600 bg-white px-2 py-1 rounded-full">
                        {{ count($departures) }}
                    </span>
                </h3>
            </div>
            
            <div class="p-4">
                @if(count($departures) === 0)
                    <div class="text-center py-8 text-brown-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <p class="text-lg font-medium">Aucun départ prévu aujourd'hui</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-brown-600 text-xs font-semibold uppercase tracking-wide">
                                    <th class="px-4 py-3 border-b border-brown-100">Client</th>
                                    <th class="px-4 py-3 border-b border-brown-100">Chambre</th>
                                    <th class="px-4 py-3 border-b border-brown-100">Statut</th>
                                    <th class="px-4 py-3 border-b border-brown-100 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brown-100">
                                @foreach($departures as $r)
                                    <tr class="hover:bg-brown-50/50 transition-colors duration-150">
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-brown-900">{{ data_get($r, 'client.nom', data_get($r,'client.name', '—')) }}</div>
                                            <div class="text-xs text-brown-500">{{ data_get($r,'check_in') }} → {{ data_get($r,'check_out') }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @foreach($r->items as $item)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $item->room?->numero ?? '—' }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ data_get($r,'statut') === 'confirmé' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ data_get($r,'statut') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button wire:click="checkOut({{ $r['id'] }})" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-600 to-orange-600 text-white text-xs rounded-lg hover:from-red-700 hover:to-orange-700 transition-all duration-200 shadow-sm">
                                                    Check-out
                                                </button>
                                                <button wire:click="$emit('showReservation', {{ $r['id'] }})" 
                                                        class="inline-flex items-center px-3 py-1.5 border border-brown-300 text-brown-700 text-xs rounded-lg hover:bg-brown-50 transition-all duration-200">
                                                    Voir
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Flash messages --}}
    <div class="fixed bottom-6 right-6 space-y-2">
        @if (session()->has('success'))
            <div class="px-4 py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg flex items-center animate-bounce-in">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="px-4 py-3 rounded-xl bg-gradient-to-r from-red-600 to-orange-600 text-white shadow-lg flex items-center animate-bounce-in">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>