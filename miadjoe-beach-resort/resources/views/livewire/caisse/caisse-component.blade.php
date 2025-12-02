<div class="p-6">
    {{-- Messages de statut --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-700 font-medium">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-red-700 font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- En-tête --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-gray-900 to-brown-800 bg-clip-text text-transparent">
                Gestion de la Caisse
            </h1>
            <p class="text-gray-600 mt-1">Tableau de bord des encaissements</p>
        </div>
    </div>

    {{-- Section KPI --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-blue-700 mb-1">Services Divers</h3>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($totalService, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-amber-700 mb-1">Restaurant</h3>
                    <p class="text-2xl font-bold text-amber-900">{{ number_format($totalResto, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-amber-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-green-700 mb-1">Réservations</h3>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($totalReservation, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-green-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-red-700 mb-1">Dépenses Validées</h3>
                    <p class="text-2xl font-bold text-red-900">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-red-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0h-4m4 0h-4m4 0h-4m-4 0H8m4 0H8m4 0H8"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- SERVICES DIVERS --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Services Divers</span>
                </h2>
            </div>
            <div class="p-4">
                <input type="text" placeholder="Rechercher un service..." 
                       class="w-full mb-4 p-3 border border-gray-300 rounded-xl focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200"
                       wire:model="searchService">

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse ($ventes['services'] as $service)
                        @php
                            $montantPaye = $service->invoice->montant_paye ?? 0;
                            $statut = $montantPaye <= 0 ? 'en attente' : ($montantPaye < ($service->invoice->montant_final ?? $service->invoice->montant_total ?? 0) ? 'partiel' : 'payé');
                        @endphp
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:border-blue-300 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <p class="font-semibold text-gray-800">{{ $service->client_nom ?? 'Client non spécifié' }}</p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600">Montant total</span>
                                        <span class="font-semibold text-gray-900">{{ number_format($service->invoice->montant_final ?? $service->invoice->montant_total ?? 0, 0, ',', ' ') }} FCFA</span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Statut</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $statut === 'payé' ? 'bg-green-100 text-green-800' : 
                                               ($statut === 'partiel' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($statut) }}
                                        </span>
                                    </div>

                                    <div class="mt-3 bg-white rounded-lg p-2 border">
                                        <div class="text-xs text-gray-600 text-center">
                                            {{ number_format($montantPaye, 0, ',', ' ') }} / {{ number_format($service->invoice->montant_final ?? $service->invoice->montant_total ?? 0, 0, ',', ' ') }} FCFA
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                                <button wire:click="ouvrirModal('service', {{ $service->id }})"
                                        class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <span>Payer</span>
                                </button>

                                @if ($service->invoice)
                                    <a href="{{ route('invoice.download', $service->invoice->id) }}" target="_blank"
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Facture</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">Aucune vente de service</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4 border-t border-gray-200 pt-4">
                    {{ $ventes['services']->links() }}
                </div>
            </div>
        </div>

        {{-- RESTAURANT --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-600 to-amber-800 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10"></path>
                    </svg>
                    <span>Restaurant</span>
                </h2>
            </div>
            <div class="p-4">
                <input type="text" placeholder="Rechercher une vente..." 
                       class="w-full mb-4 p-3 border border-gray-300 rounded-xl focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200"
                       wire:model="searchResto">

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse ($ventes['resto'] as $sale)
                        @php
                            $montantPaye = $sale->invoice->montant_paye ?? 0;
                            $statut = $montantPaye <= 0 ? 'en attente' : ($montantPaye < ($sale->invoice->montant_final ?? $sale->invoice->montant_total ?? 0) ? 'partiel' : 'payé');
                        @endphp
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:border-amber-300 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">
                                                @if($sale->reservation_id)
                                                    Réservation #{{ $sale->reservation_id }}
                                                @else
                                                    Vente libre
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $sale->reservation_id ? 'Payée via réservation' : 'Client non logé' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600">Montant total</span>
                                        <span class="font-semibold text-gray-900">{{ number_format($sale->invoice->montant_final ?? $sale->invoice->montant_total ?? 0, 0, ',', ' ') }} FCFA</span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Statut</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $statut === 'payé' ? 'bg-green-100 text-green-800' : 
                                               ($statut === 'partiel' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($statut) }}
                                        </span>
                                    </div>

                                    <div class="mt-3 bg-white rounded-lg p-2 border">
                                        <div class="text-xs text-gray-600 text-center">
                                            {{ number_format($montantPaye, 0, ',', ' ') }} / {{ number_format($sale->invoice->montant_final ?? $sale->invoice->montant_total ?? 0, 0, ',', ' ') }} FCFA
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                                @if ($sale->reservation_id)
                                    <button disabled
                                        class="bg-gray-300 text-gray-500 px-4 py-2 rounded-xl text-sm font-semibold cursor-not-allowed flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Payée via réservation</span>
                                    </button>
                                @else
                                    <button wire:click="ouvrirModal('resto', {{ $sale->id }})"
                                            class="bg-gradient-to-r from-amber-600 to-amber-800 hover:from-amber-700 hover:to-amber-900 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <span>Payer</span>
                                    </button>
                                @endif

                                @if ($sale->invoice)
                                    <a href="{{ route('invoice.download', $sale->invoice->id) }}" target="_blank"
                                       class="text-amber-600 hover:text-amber-800 text-sm font-medium flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Facture</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">Aucune vente restaurant</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4 border-t border-gray-200 pt-4">
                    {{ $ventes['resto']->links() }}
                </div>
            </div>
        </div>

        {{-- RÉSERVATIONS --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Réservations</span>
                </h2>
            </div>
            <div class="p-4">
                <input type="text" placeholder="Rechercher une réservation..." 
                       class="w-full mb-4 p-3 border border-gray-300 rounded-xl focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200"
                       wire:model="searchReservation">

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse ($ventes['reservations'] as $reservation)
                        @php
                            $montantPaye = $reservation->invoice->montant_paye ?? 0;
                            $statut = $montantPaye <= 0 ? 'en attente' : ($montantPaye < ($reservation->invoice->montant_final ?? $reservation->invoice->montant_total ?? 0) ? 'partiel' : 'payé');
                        @endphp
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:border-green-300 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">
                                                {{ $reservation->client ? $reservation->client->nom . ' ' . $reservation->client->prenom : 'Client inconnu' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">Réservation #{{ $reservation->id }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <span class="text-sm text-gray-600">Total</span>
                                            <p class="font-semibold text-gray-900">{{ number_format($reservation->invoice->montant_final ?? $reservation->invoice->montant_total ?? 0, 0, ',', ' ') }} FCFA</p>
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-600">Payé</span>
                                            <p class="font-semibold text-green-600">{{ number_format($montantPaye, 0, ',', ' ') }} FCFA</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between text-sm mb-3">
                                        <span class="text-gray-600">Statut</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $statut === 'payé' ? 'bg-green-100 text-green-800' : 
                                               ($statut === 'partiel' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($statut) }}
                                        </span>
                                    </div>

                                    {{-- Détails des chambres --}}
                                    @if ($reservation->rooms && $reservation->rooms->count() > 0)
                                        <div class="mt-3 bg-white rounded-lg p-3 border">
                                            <p class="text-xs font-semibold text-gray-700 mb-2">Chambres réservées :</p>
                                            <div class="space-y-0">
                                                @foreach ($reservation->rooms as $room)
                                                    <div class="flex justify-between text-xs text-gray-600">
                                                        <span>{{ $room->nom ?? $room->numero ?? 'Chambre inconnue' }}</span>
                                                        <span>{{ $room->pivot->nights ?? 1 }} nuit{{ ($room->pivot->nights ?? 1) > 1 ? 's' : '' }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mt-3 bg-white rounded-lg p-2 border">
                                        <div class="text-xs text-gray-600 text-center">
                                            {{ number_format($montantPaye, 0, ',', ' ') }} / {{ number_format($reservation->invoice->montant_final ?? $reservation->invoice->montant_total ?? 0, 0, ',', ' ') }} FCFA
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                                <button wire:click="ouvrirModal('reservation', {{ $reservation->id }})"
                                        class="bg-gradient-to-r from-green-600 to-green-800 hover:from-green-700 hover:to-green-900 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <span>Payer</span>
                                </button>

                                @if ($reservation->invoice)
                                    <a href="{{ route('invoice.download', $reservation->invoice->id) }}" target="_blank"
                                       class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Facture</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">Aucune réservation enregistrée</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4 border-t border-gray-200 pt-4">
                    {{ $ventes['reservations']->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE PAIEMENT --}}
    <livewire:caisse.caisse-payment-form />
    <livewire:caisse.payment-reservation-modal>
    <livewire:sale.sale-payment-modal />
    <livewire:divers-service-payment-modal />

</div>