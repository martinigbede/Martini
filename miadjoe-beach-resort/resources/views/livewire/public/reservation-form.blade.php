{{-- resources/views/livewire/public/reservation-form.blade.php --}}
<div class="w-full">
    <!-- En-tête du formulaire -->
    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-light text-gray-900 mb-3">Réservez Votre Séjour</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Découvrez nos chambres disponibles et planifiez votre escapade inoubliable
        </p>
    </div>

    {{-- Formulaire de Recherche --}}
    <form wire:submit.prevent="searchAvailability" class="space-y-6">
        <!-- Section Dates -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-brown-100">
            <h3 class="text-lg font-semibold text-brown-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-brown-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Vos Dates de Séjour
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Date d'arrivée -->
                <div class="relative">
                    <label for="check_in" class="block text-sm font-medium text-gray-700 mb-2">Date d'Arrivée</label>
                    <div class="relative">
                        <input type="date" 
                               wire:model.live="check_in" 
                               id="check_in" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white"
                               min="{{ now()->format('Y-m-d') }}">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('check_in') 
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </span> 
                    @enderror
                </div>

                <!-- Date de départ -->
                <div class="relative">
                    <label for="check_out" class="block text-sm font-medium text-gray-700 mb-2">Date de Départ</label>
                    <div class="relative">
                        <input type="date" 
                               wire:model.live="check_out" 
                               id="check_out" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white"
                               min="{{ $check_in ? \Carbon\Carbon::parse($check_in)->addDay()->format('Y-m-d') : now()->addDay()->format('Y-m-d') }}">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('check_out') 
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </span> 
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section Type de Chambre -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-brown-100">
            <h3 class="text-lg font-semibold text-brown-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-brown-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Type de Chambre
            </h3>
            
            <div>
                <label for="selectedRoomTypeId" class="block text-sm font-medium text-gray-700 mb-2">Sélectionnez votre type de chambre préféré</label>
                <select wire:model="selectedRoomTypeId" 
                        id="selectedRoomTypeId" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white appearance-none">
                    <option value="" class="text-gray-400">Tous les types de chambres</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" class="text-gray-700">
                            {{ $type->name }} - À partir de {{ number_format($type->base_price, 0, ',', ' ') }} €
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 mt-12">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Bouton de Recherche -->
        <button type="submit" 
                wire:loading.attr="disabled"
                class="w-full py-4 px-6 bg-gradient-to-r from-brown-600 to-brown-800 hover:from-brown-700 hover:to-brown-900 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center group">
            <span wire:loading.remove class="flex items-center">
                Vérifier la Disponibilité
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <span wire:loading class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Recherche en cours...
            </span>
        </button>
    </form>

    {{-- Résultats de la Recherche --}}
    @if($searchPerformed)
        <div class="mt-8 animate-fade-in">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-brown-100">
                <h2 class="text-2xl font-light text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 text-brown-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Résultats de Votre Recherche
                </h2>
                
                @if($availableRoomsCount > 0)
                    <!-- Résultat positif -->
                    <div class="bg-green-50 border-l-4 border-green-500 rounded-r-lg p-6" role="alert">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-green-800 mb-2">🎉 Disponibilité trouvée !</h3>
                                <p class="text-green-700 mb-4">
                                    Nous avons trouvé <strong class="text-green-800">{{ $availableRoomsCount }}</strong> type(s) de chambre(s) correspondant à vos critères pour les dates sélectionnées.
                                </p>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Voir les Tarifs Détaillés
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    <button wire:click="$set('searchPerformed', false)" class="inline-flex items-center justify-center px-6 py-3 border border-green-600 text-green-600 font-semibold rounded-lg hover:bg-green-50 transition-colors duration-200">
                                        Modifier la Recherche
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Résultat négatif -->
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg p-6" role="alert">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-red-800 mb-2">😔 Aucune disponibilité trouvée</h3>
                                <p class="text-red-700 mb-4">
                                    Malheureusement, nous n'avons pas de chambres disponibles pour les dates et critères sélectionnés.
                                </p>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button wire:click="$set('searchPerformed', false)" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors duration-200">
                                        Modifier les Critères
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                    <a href="tel:+33123456789" class="inline-flex items-center justify-center px-6 py-3 border border-red-600 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-colors duration-200">
                                        Nous Contacter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
