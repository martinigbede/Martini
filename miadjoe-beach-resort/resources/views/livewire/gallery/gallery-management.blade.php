{{-- resources/views/livewire/gallery/gallery-management.blade.php --}}
<div class="min-h-screen bg-brown-50 py-6">
    {{-- Notification Messages avec animation --}}
    @if (session()->has('message'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 animate-fade-in-down">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-lg flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-green-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- En-tête avec onglets améliorés --}}
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-8 pb-6 border-b border-brown-200">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-3xl font-bold text-brown-900 bg-gradient-to-r from-brown-800 to-brown-600 bg-clip-text text-transparent">
                    Gestion des Galeries
                </h2>
                <p class="text-brown-600 mt-2">Organisez vos albums photos et vidéos</p>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                {{-- Sélecteur de mode --}}
                <div class="bg-white rounded-lg shadow-sm border border-brown-200 p-1 flex">
                    <button wire:click="$set('mode', 'gallery')" 
                            class="py-2 px-4 text-sm font-medium rounded-md transition-all duration-200 flex items-center space-x-2 {{ $mode === 'gallery' ? 'bg-brown-500 text-white shadow-md' : 'text-brown-600 hover:text-brown-900 hover:bg-brown-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Albums</span>
                    </button>
                    <button wire:click="$set('mode', 'item')" 
                            class="py-2 px-4 text-sm font-medium rounded-md transition-all duration-200 flex items-center space-x-2 {{ $mode === 'item' ? 'bg-brown-500 text-white shadow-md' : 'text-brown-600 hover:text-brown-900 hover:bg-brown-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Médias</span>
                    </button>
                </div>

                {{-- Bouton d'ajout --}}
                <button wire:click="openModal()" 
                        class="bg-gradient-to-r from-brown-500 to-brown-700 hover:from-brown-600 hover:to-brown-800 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Ajouter {{ $mode === 'gallery' ? 'Album' : 'Média' }}</span>
                </button>
            </div>
        </div>

        {{-- Tableau dynamique --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-brown-200 transition-all duration-300 hover:shadow-xl">
            <div class="p-8">
                {{-- En-tête du tableau --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-brown-800 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-brown-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>Liste des {{ $mode === 'gallery' ? 'Albums' : 'Médias' }}</span>
                    </h3>
                    <div class="text-sm text-brown-500">
                        {{ $items->total() }} {{ $mode === 'gallery' ? 'album(s)' : 'média(s)' }} au total
                    </div>
                </div>

                @if($mode === 'gallery')
                    {{-- Tableau des albums --}}
                    <div class="overflow-x-auto rounded-lg border border-brown-200">
                        <table class="min-w-full divide-y divide-brown-200">
                            <thead class="bg-gradient-to-r from-brown-50 to-brown-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-brown-700 uppercase tracking-wider">Titre</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-brown-700 uppercase tracking-wider">Type & Contenu</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-brown-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-brown-200">
                                @forelse ($items as $gal)
                                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-brown-900">{{ $gal->title }}</div>
                                            @if($gal->description)
                                                <div class="text-xs text-brown-500 mt-1 max-w-xs truncate">{{ $gal->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium capitalize {{ $gal->type === 'photo' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ $gal->type === 'photo' ? '📷 Photos' : '🎥 Vidéos' }}
                                                </span>
                                                <span class="text-sm text-brown-600">
                                                    {{ $gal->items->count() }} élément(s)
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button wire:click="openModal({{ $gal->id }})" 
                                                        class="text-brown-600 hover:text-brown-900 bg-brown-50 hover:bg-brown-100 px-3 py-1 rounded-md transition-colors duration-200 flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    <span>Éditer</span>
                                                </button>
                                                <button wire:click="deleteGallery({{ $gal->id }})" 
                                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cet album et tous ses médias ? Cette action est irréversible."
                                                        class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors duration-200 flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    <span>Supprimer</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="text-brown-400 flex flex-col items-center space-y-3">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-lg font-medium text-brown-500">Aucun album trouvé</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Tableau des médias --}}
                    <div class="overflow-x-auto rounded-lg border border-brown-200">
                        <table class="min-w-full divide-y divide-brown-200">
                            <thead class="bg-gradient-to-r from-brown-50 to-brown-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-brown-700 uppercase tracking-wider">Aperçu</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-brown-700 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-brown-700 uppercase tracking-wider">Ordre</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-brown-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-brown-200">
                                @forelse ($items as $item)
                                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($item->gallery && $item->gallery->type === 'photo' && $item->file_path)
                                                <img src="{{ asset($item->file_path) }}" class="w-20 h-20 object-cover rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                            @elseif($item->gallery && $item->gallery->type === 'video' && $item->file_path)
                                                <div class="relative">
                                                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                    <span class="absolute -top-1 -right-1 bg-purple-500 text-white text-xs px-1 rounded">VID</span>
                                                </div>
                                            @else
                                                <div class="w-20 h-20 bg-brown-100 rounded-lg flex items-center justify-center">
                                                    <span class="text-xs text-brown-400">Aucun média</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-brown-900">{{ $item->caption ?? 'Sans description' }}</div>
                                            @if($item->gallery)
                                                <div class="text-xs text-brown-500 mt-1">Album: {{ $item->gallery->title }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-brown-100 text-brown-800 rounded-full text-sm font-semibold">
                                                {{ $item->order_index }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button wire:click="openModal({{ $item->id }})" 
                                                        class="text-brown-600 hover:text-brown-900 bg-brown-50 hover:bg-brown-100 px-3 py-1 rounded-md transition-colors duration-200 flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    <span>Éditer</span>
                                                </button>
                                                <button wire:click="deleteItem({{ $item->id }})" 
                                                        wire:confirm="Êtes-vous sûr de vouloir supprimer ce média ? Cette action est irréversible."
                                                        class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors duration-200 flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    <span>Supprimer</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="text-brown-400 flex flex-col items-center space-y-3">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-lg font-medium text-brown-500">Aucun média trouvé</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODALE AMÉLIORÉE --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full flex justify-center items-center z-50 transition-opacity duration-300 animate-fade-in">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 my-8 transform transition-all duration-300 animate-scale-in">
                <div class="p-8">
                    {{-- En-tête de la modale --}}
                    <div class="flex justify-between items-center border-b border-brown-200 pb-6 mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-brown-900">
                                {{ $editingId ? 'Éditer' : 'Créer' }} {{ $mode === 'gallery' ? 'Album' : 'Média' }}
                            </h3>
                            <p class="text-brown-600 mt-1">Remplissez les informations ci-dessous</p>
                        </div>
                        <button wire:click="closeModal" 
                                class="text-brown-400 hover:text-brown-600 hover:bg-brown-100 rounded-full p-2 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Formulaire --}}
                    <form wire:submit.prevent="{{ $mode === 'gallery' ? 'storeGallery' : 'storeItem' }}">
                        <div class="space-y-6 max-h-96 overflow-y-auto pr-4">
                            @if ($mode === 'gallery')
                                {{-- Champs album --}}
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-brown-700 mb-2">Titre de l'album *</label>
                                        <input type="text" wire:model.defer="gal_title" 
                                               class="w-full px-4 py-3 border border-brown-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-brown-50"
                                               placeholder="Ex: Photos de la plage">
                                        @error('gal_title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-brown-700 mb-2">Description</label>
                                        <textarea wire:model.defer="gal_description" rows="3"
                                                  class="w-full px-4 py-3 border border-brown-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-brown-50"
                                                  placeholder="Description optionnelle de l'album"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-brown-700 mb-2">Type de contenu *</label>
                                        <select wire:model.defer="gal_type" 
                                                class="w-full px-4 py-3 border border-brown-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-brown-50">
                                            <option value="photo">📷 Album Photos</option>
                                            <option value="video">🎥 Album Vidéos</option>
                                        </select>
                                        @error('gal_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @else
                                {{-- Champs média --}}
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-brown-700 mb-2">Album parent *</label>
                                        <select wire:model.defer="item_gallery_id" 
                                                class="w-full px-4 py-3 border border-brown-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-brown-50">
                                            <option value="">Sélectionner un album</option>
                                            @foreach(\App\Models\Gallery::all() as $gal) 
                                                <option value="{{ $gal->id }}">{{ $gal->title }} ({{ $gal->type }})</option>
                                            @endforeach
                                        </select>
                                        @error('item_gallery_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-brown-700 mb-2">Fichier média *</label>
                                        <div class="border-2 border-dashed border-brown-300 rounded-lg p-6 text-center hover:border-brown-400 transition-colors duration-200 bg-brown-50">
                                            <input type="file" wire:model="item_file" class="hidden" id="file-upload">
                                            <label for="file-upload" class="cursor-pointer">
                                                <svg class="mx-auto h-12 w-12 text-brown-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <div class="mt-2">
                                                    <span class="text-sm font-medium text-brown-600">Télécharger un fichier</span>
                                                    <span class="text-xs text-brown-500 block">PNG, JPG, MP4 jusqu'à 10MB</span>
                                                </div>
                                            </label>
                                        </div>
                                        @if($item_temp_path)
                                            <div class="mt-4 flex items-center space-x-4 p-4 bg-brown-50 rounded-lg">
                                                <img src="{{ asset($item_temp_path) }}" class="w-16 h-16 object-cover rounded-lg shadow" onerror="this.style.display='none'">
                                                <span class="text-sm text-brown-600">Fichier actuel</span>
                                            </div>
                                        @endif
                                        @error('item_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-brown-700 mb-2">Légende</label>
                                        <input type="text" wire:model.defer="item_caption" 
                                               class="w-full px-4 py-3 border border-brown-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-brown-50"
                                               placeholder="Description du média">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-brown-700 mb-2">Ordre d'affichage *</label>
                                        <input type="number" wire:model.defer="item_order_index" 
                                               class="w-full px-4 py-3 border border-brown-300 rounded-lg focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-brown-50"
                                               placeholder="Position dans l'album">
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions du formulaire --}}
                        <div class="flex justify-end space-x-4 pt-6 mt-6 border-t border-brown-200">
                            <button type="button" wire:click="closeModal" 
                                    class="px-6 py-3 border border-brown-300 text-brown-700 font-medium rounded-lg hover:bg-brown-50 transition-colors duration-200">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-brown-500 to-brown-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ $editingId ? 'Mettre à jour' : 'Créer' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <style>
        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</div>