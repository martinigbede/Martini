{{-- resources/views/livewire/room/public-room-availability.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- En-tête principal --}}
        <div class="text-center mb-12">
            <div class="relative inline-block mb-4">
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-400 to-indigo-600 rounded-2xl blur-lg opacity-20"></div>
                <h1 class="relative text-4xl lg:text-5xl font-serif font-bold text-gray-900">
                    Chambres <span class="bg-gradient-to-r from-blue-600 to-indigo-800 bg-clip-text text-transparent">Disponibles</span>
                </h1>
            </div>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Découvrez nos chambres disponibles et réservez votre séjour en toute simplicité
            </p>
        </div>

        {{-- Section de recherche améliorée --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/60 p-8 mb-12">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center justify-center space-x-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Vérifier la disponibilité</span>
                </h2>
                <p class="text-gray-600 mt-2">Sélectionnez vos dates pour voir les chambres disponibles</p>
            </div>

            <form wire:submit.prevent="submitSearchDates" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Date Check-in --}}
                <div class="space-y-2">
                    <label for="check_in_public" class="block text-sm font-semibold text-gray-900">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Date d'arrivée</span>
                        </div>
                    </label>
                    <input 
                        type="date" 
                        wire:model.live="check_in_public" 
                        id="check_in_public" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                    />
                    @error('check_in_public') 
                        <span class="text-red-500 text-xs mt-1 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                {{-- Date Check-out --}}
                <div class="space-y-2">
                    <label for="check_out_public" class="block text-sm font-semibold text-gray-900">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Date de départ</span>
                        </div>
                    </label>
                    <input 
                        type="date" 
                        wire:model.live="check_out_public" 
                        id="check_out_public" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                    />
                    @error('check_out_public') 
                        <span class="text-red-500 text-xs mt-1 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                {{-- Filtre Type de Chambre --}}
                <div class="space-y-2">
                    <label for="typeFilter" class="block text-sm font-semibold text-gray-900">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Type de chambre</span>
                        </div>
                    </label>
                    <div class="relative">
                        <select 
                            wire:model="typeFilter" 
                            id="typeFilter" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm appearance-none"
                        >
                            <option value="">🏠 Tous les types</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->nom }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Bouton de recherche --}}
                <div class="flex items-end">
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-800 hover:from-blue-700 hover:to-indigo-900 text-white px-6 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/20 flex items-center justify-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>Rechercher</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Liste des chambres disponibles --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($availableRooms as $room)
                <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    
                    {{-- En-tête de la carte --}}
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">
                                    Chambre {{ $room->numero }}
                                </h3>
                                <p class="text-blue-600 font-semibold mt-1">
                                    {{ $room->roomType->nom ?? 'Type Indéfini' }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 shadow-lg">
                                🟢 DISPONIBLE
                            </span>
                        </div>
                        
                        {{-- Description --}}
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                            {{ $room->description ?? 'Chambre confortable avec tout le nécessaire pour un séjour agréable.' }}
                        </p>
                    </div>

                    {{-- Caractéristiques --}}
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Max {{ $room->roomType->nombre_personnes_max ?? '2' }} pers.</span>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                                </svg>
                                <span>{{ $room->roomType->surface ?? '--' }} m²</span>
                            </div>
                        </div>

                        {{-- Équipements (exemple) --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">🛏️ Lit double</span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">🚿 Salle de bain</span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">📺 TV</span>
                        </div>

                        {{-- Bouton de réservation --}}
                        <button class="w-full bg-gradient-to-r from-blue-600 to-indigo-800 hover:from-blue-700 hover:to-indigo-900 text-white py-3.5 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/20 flex items-center justify-center space-x-2 group/btn disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <span><a href="{{ route('public.reservation') }}" >Réserver maintenant</a></span>
                            <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            <a  href="{{ route('rooms.show', $room->id) }}" class="text-blue-600 underline" >Voir détails</a>
                        </button>
                        
                        @if (!$check_in_public || !$check_out_public)
                            <p class="text-xs text-red-500 mt-2 text-center flex items-center justify-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                <span>Veuillez sélectionner les dates pour réserver</span>
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                {{-- État vide --}}
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white rounded-2xl shadow-lg border border-red-100">
                        <div class="w-24 h-24 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucune chambre disponible</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Aucune chambre ne correspond à vos critères de recherche pour cette période.
                        </p>
                        <button 
                            wire:click="$set('typeFilter', '')" 
                            class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            Voir toutes les chambres
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($availableRooms->hasPages())
            <div class="mt-12 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/60 p-6">
                {{ $availableRooms->links() }}
            </div>
        @endif
    </div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>