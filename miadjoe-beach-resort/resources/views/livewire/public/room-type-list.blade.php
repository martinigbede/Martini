{{-- resources/views/livewire/public/room-type-list.blade.php --}}
<div class="w-full">
    {{-- Filtres et Navigation --}}
    <div class="flex flex-wrap justify-center gap-4 mb-12 p-8 border-b border-gray-200 bg-white shadow-sm rounded-xl">
        {{-- Bouton TOUTES --}}
        <button wire:click="setFilter('all')" 
                class="px-6 py-3 rounded-2xl font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg border-2
                       {{ $activeFilter === 'all' 
                          ? 'bg-indigo-600 text-white shadow-xl border-transparent' 
                          : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:border-indigo-300 hover:shadow-xl' }}">
            🌅 Toutes les chambres
        </button>
        
        {{-- Bouton STANDARD --}}
        <button wire:click="setFilter('standard')" 
                class="px-6 py-3 rounded-2xl font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg border-2
                       {{ $activeFilter === 'standard' 
                          ? 'bg-indigo-600 text-white shadow-xl border-transparent' 
                          : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:border-indigo-300 hover:shadow-xl' }}">
            🛏️ Standards
        </button>

        {{-- Bouton LUXE --}}
        <button wire:click="setFilter('luxe')" 
                class="px-6 py-3 rounded-2xl font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg border-2
                       {{ $activeFilter === 'luxe' 
                          ? 'bg-indigo-600 text-white shadow-xl border-transparent' 
                          : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:border-indigo-300 hover:shadow-xl' }}">
            ⭐ Suites & Luxe
        </button>

        {{-- Bouton FAMILLE --}}
        <button wire:click="setFilter('famille')" 
                class="px-6 py-3 rounded-2xl font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg border-2
                       {{ $activeFilter === 'famille' 
                          ? 'bg-indigo-600 text-white shadow-xl border-transparent' 
                          : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:border-indigo-300 hover:shadow-xl' }}">
            👨‍👩‍👧‍👦 Famille
        </button>
    </div>

    {{-- Indicateur de filtre actif --}}
    @if($activeFilter !== 'all')
    <div class="text-center mb-8 px-8">
        <div class="inline-flex items-center space-x-4 bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-200">
            <span class="text-indigo-600 font-medium">Filtre actif :</span>
            <span class="bg-indigo-600 text-white px-4 py-1 rounded-full text-sm font-semibold capitalize">
                {{ $activeFilter === 'standard' ? '🛏️ Chambres Standards' : ($activeFilter === 'luxe' ? '⭐ Suites Luxe' : '👨‍👩‍👧‍👦 Famille') }}
            </span>
            <button wire:click="setFilter('all')" 
                    class="text-indigo-500 hover:text-indigo-700 text-sm font-medium underline transition-colors">
                Tout afficher
            </button>
        </div>
    </div>
    @endif

    {{-- Grille des Chambres --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 p-4">
        @forelse ($filteredRoomTypes as $type)
            <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    {{-- Image/Aperçu --}}
                    <div class="lg:w-2/5 relative overflow-hidden">
                        <div class="aspect-[4/3] bg-gray-100 relative">
                            {{-- NOTE: $type->images doit exister via une relation ou une simulation --}}
                            @if($type->images && $type->images->count() > 0)
                                <img src="{{ asset($type->images->first()->file_path) }}" 
                                     alt="{{ $type->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="text-4xl mb-2 block">🏨</span>
                                        <p class="text-gray-400 font-medium">{{ $type->name }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Badge de catégorie --}}
                            <div class="absolute top-4 left-4 bg-black/70 text-white px-3 py-1 rounded-full text-sm font-semibold backdrop-blur-sm">
                                @if($type->capacity <= 2)
                                    🛏️ Standard
                                @elseif($type->capacity <= 4)
                                    👨‍👩‍👧‍👦 Famille
                                @else
                                    ⭐ Luxe
                                @endif
                            </div>

                            {{-- Indicateur de galerie --}}
                            @if($type->images && $type->images->count() > 1)
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-indigo-600 px-3 py-1 rounded-full text-sm font-semibold">
                                +{{ $type->images->count() - 1 }} photos
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Détails et Prix --}}
                    <div class="lg:w-3/5 p-8">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-2xl lg:text-3xl font-light text-gray-900 mb-2">{{ $type->name }}</h2>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ $type->rating ?? '4.8' }}/5
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                        </svg>
                                        {{ $type->capacity }} personne{{ $type->capacity > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-light text-indigo-700 mb-1">
                                    {{ number_format($type->base_price, 0, ',', ' ') }} €
                                </div>
                                <div class="text-sm text-gray-500">par nuit</div>
                            </div>
                        </div>

                        {{-- Description --}}
                        @if($type->description)
                        <p class="text-gray-600 leading-relaxed mb-6 line-clamp-3">
                            {{ $type->description }}
                        </p>
                        @endif

                        {{-- Équipements --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($this->getRoomFeatures($type) as $feature)
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-full border border-indigo-100">
                                {{ $feature }}
                            </span>
                            @endforeach
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('public.reservation', ['room_type_id' => $type->id]) }}" 
                               class="flex-1 bg-indigo-600 text-white py-3 px-6 rounded-xl font-semibold hover:bg-indigo-700 transition-all duration-300 shadow-md text-center group">
                                <span class="flex items-center justify-center">
                                    Réserver maintenant
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
                            </a>
                            <button class="px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-300 flex items-center justify-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                Favoris
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- État vide --}}
            <div class="col-span-full text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-indigo-100 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-light text-gray-600 mb-4">Aucune chambre active</h3>
                    <p class="text-gray-500 mb-6">
                        @if($activeFilter !== 'all')
                            Aucun type de chambre ne correspond au filtre sélectionné.
                        @else
                            Veuillez contacter l'administration pour configurer les types de chambres.
                        @endif
                    </p>
                    @if($activeFilter !== 'all')
                    <button wire:click="setFilter('all')" 
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all duration-300 shadow-md">
                        Voir toutes les chambres
                    </button>
                    @endif
                </div>
            </div>
        @endforelse
    </div>
</div>