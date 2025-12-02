{{-- resources/views/livewire/public/gallery-display.blade.php --}}
<div class="w-full">
    {{-- Navigation par catégories améliorée --}}
    <div class="flex flex-wrap justify-center gap-4 mb-16">
        {{-- Bouton TOUTES LES GALERIES --}}
        <button wire:click="setFilter('all')" 
                class="px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg border-2
                       {{ $activeFilter === 'all' 
                          ? 'bg-gradient-to-r from-brown-600 to-amber-600 text-white shadow-2xl border-transparent' 
                          : 'bg-white text-brown-700 border-brown-200 hover:bg-brown-50 hover:border-brown-300 hover:shadow-xl' }}">
            <span class="flex items-center space-x-2">
                <span class="text-xl">🌅</span>
                <span>Toutes les galeries</span>
            </span>
        </button>
        
        {{-- Bouton PHOTOS --}}
        <button wire:click="setFilter('photo')" 
                class="px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg border-2
                       {{ $activeFilter === 'photo' 
                          ? 'bg-gradient-to-r from-brown-600 to-amber-600 text-white shadow-2xl border-transparent' 
                          : 'bg-white text-brown-700 border-brown-200 hover:bg-brown-50 hover:border-brown-300 hover:shadow-xl' }}">
            <span class="flex items-center space-x-2">
                <span class="text-xl">📸</span>
                <span>Photos</span>
            </span>
        </button>

        {{-- Bouton VIDÉOS --}}
        <button wire:click="setFilter('video')" 
                class="px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:-translate-y-1 shadow-lg border-2
                       {{ $activeFilter === 'video' 
                          ? 'bg-gradient-to-r from-brown-600 to-amber-600 text-white shadow-2xl border-transparent' 
                          : 'bg-white text-brown-700 border-brown-200 hover:bg-brown-50 hover:border-brown-300 hover:shadow-xl' }}">
            <span class="flex items-center space-x-2">
                <span class="text-xl">🎬</span>
                <span>Vidéos</span>
            </span>
        </button>
    </div>

    {{-- Indicateur de filtre actif --}}
    @if($activeFilter !== 'all')
    <div class="text-center mb-12">
        <div class="inline-flex items-center space-x-4 bg-brown-50 px-6 py-3 rounded-2xl border border-brown-200">
            <span class="text-brown-600 font-medium">Filtre actif :</span>
            <span class="bg-brown-600 text-white px-4 py-1 rounded-full text-sm font-semibold capitalize">
                {{ $activeFilter === 'photo' ? '📸 Photos' : '🎬 Vidéos' }}
            </span>
            <button wire:click="setFilter('all')" 
                    class="text-brown-500 hover:text-brown-700 text-sm font-medium underline transition-colors">
                Tout afficher
            </button>
        </div>
    </div>
    @endif

    {{-- Contenu des galeries --}}
    <div class="space-y-20">
        @forelse ($galleries as $gallery)
            <div class="group/gallery">
                {{-- En-tête de galerie --}}
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-brown-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-brown-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-2xl text-white">
                                {{ $gallery->type === 'photo' ? '🖼️' : '🎥' }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-3xl lg:text-4xl font-light text-gray-900">{{ $gallery->title }}</h3>
                            @if($gallery->description)
                            <p class="text-gray-600 mt-2 text-lg">{{ $gallery->description }}</p>
                            @endif
                        </div>
                    </div>
                    <span class="hidden lg:block text-brown-600 bg-brown-50 px-4 py-2 rounded-full text-sm font-semibold">
                        {{ $gallery->items->count() }} {{ $gallery->type === 'photo' ? 'photos' : 'vidéos' }}
                    </span>
                </div>
                
                {{-- Contenu selon le type --}}
                @if ($gallery->type === 'photo')
                    {{-- GRILLE PHOTOS MODERNE --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                        @foreach($gallery->items as $item)
                            <div class="group/item relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer aspect-square bg-gradient-to-br from-brown-50 to-amber-50">
                                <img src="{{ asset($item->file_path) }}" 
                                     alt="{{ $item->caption ?? $gallery->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover/item:scale-110"
                                     loading="lazy">
                                
                                {{-- Overlay moderne --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover/item:opacity-100 transition-all duration-500 flex items-end p-4">
                                    <div class="transform translate-y-6 group-hover/item:translate-y-0 transition-transform duration-500">
                                        @if($item->caption)
                                        <p class="text-white text-sm font-medium mb-2">{{ $item->caption }}</p>
                                        @endif
                                        <div class="flex items-center text-white/80 text-xs">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                            </svg>
                                            Agrandir
                                        </div>
                                    </div>
                                </div>

                                {{-- Badge type --}}
                                <div class="absolute top-3 left-3 bg-black/60 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                    📸
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif ($gallery->type === 'video')
                    {{-- GRILLE VIDÉOS MODERNE --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        @foreach($gallery->items as $item)
                            <div class="group/item relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-brown-100">
                                <div class="aspect-video bg-gradient-to-br from-gray-900 to-brown-900 relative overflow-hidden">
                                    @if(str_contains($item->file_path, 'youtube.com') || str_contains($item->file_path, 'youtu.be'))
                                        {{-- Intégration YouTube améliorée --}}
                                        <iframe 
                                            width="100%" 
                                            height="100%" 
                                            src="{{ $item->file_path }}" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen
                                            class="group-hover/item:scale-105 transition-transform duration-700">
                                        </iframe>
                                    @else
                                        {{-- Lecteur vidéo HTML5 moderne --}}
                                        <video 
                                            controls 
                                            class="w-full h-full group-hover/item:scale-105 transition-transform duration-700"
                                            poster="{{ $item->thumbnail_path ? asset($item->thumbnail_path) : '' }}">
                                            <source src="{{ asset($item->file_path) }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la balise vidéo.
                                        </video>
                                    @endif
                                    
                                    {{-- Overlay play button --}}
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/item:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center transform scale-75 group-hover/item:scale-100 transition-transform duration-300 shadow-lg">
                                            <svg class="w-8 h-8 text-brown-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Badge type --}}
                                    <div class="absolute top-3 left-3 bg-black/60 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                        🎬
                                    </div>
                                </div>
                                
                                {{-- Légende améliorée --}}
                                @if($item->caption)
                                <div class="p-6">
                                    <p class="text-gray-700 font-medium text-lg">{{ $item->caption }}</p>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            {{-- État vide designé --}}
            <div class="text-center py-20">
                <div class="max-w-2xl mx-auto">
                    <div class="w-32 h-32 bg-gradient-to-br from-brown-100 to-amber-100 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                        <svg class="w-16 h-16 text-brown-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-light text-gray-600 mb-4">Aucun contenu trouvé</h3>
                    <p class="text-xl text-gray-500 mb-8 leading-relaxed">
                        @if($activeFilter !== 'all')
                            Aucun {{ $activeFilter === 'photo' ? 'photo' : 'vidéo' }} n'est disponible pour le moment.
                            <br>Essayez de changer de filtre ou revenez plus tard.
                        @else
                            Aucune galerie n'est publiée pour le moment.
                            <br>Revenez bientôt pour découvrir notre contenu.
                        @endif
                    </p>
                    @if($activeFilter !== 'all')
                    <button wire:click="setFilter('all')" 
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-brown-600 to-amber-600 text-white rounded-2xl font-semibold hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Voir toutes les galeries
                    </button>
                    @endif
                </div>
            </div>
        @endforelse
    </div>
</div>