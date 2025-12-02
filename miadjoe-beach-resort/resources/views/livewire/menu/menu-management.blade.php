{{-- resources/views/livewire/menu/menu-management.blade.php --}}
<div class="min-h-screen bg-gray-50 py-6">
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
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-8 pb-6 border-b border-gray-200">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    Gestion des Menus
                </h2>
                <p class="text-gray-600 mt-2">Gérez vos catégories et menus facilement</p>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                {{-- Sélecteur de mode --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-1 flex">
                    <button wire:click="$set('mode', 'category')" 
                            class="py-2 px-4 text-sm font-medium rounded-md transition-all duration-200 flex items-center space-x-2 {{ $mode === 'category' ? 'bg-indigo-500 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Catégories</span>
                    </button>
                    <button wire:click="$set('mode', 'item')" 
                            class="py-2 px-4 text-sm font-medium rounded-md transition-all duration-200 flex items-center space-x-2 {{ $mode === 'item' ? 'bg-indigo-500 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Menus</span>
                    </button>
                </div>

                {{-- Bouton d'ajout --}}
                <button wire:click="openModal()" 
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Ajouter {{ $mode === 'category' ? 'Catégorie' : 'Menu' }}</span>
                </button>
            </div>
        </div>

        {{-- Tableau dynamique --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
            <div class="p-8">
                {{-- En-tête du tableau --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>Liste des {{ $mode === 'category' ? 'Catégories' : 'Menus' }}</span>
                    </h3>
                    <div class="text-sm text-gray-500">
                        {{ $items->total() }} {{ $mode === 'category' ? 'catégorie(s)' : 'menu(s)' }} au total
                    </div>
                </div>

                @if($mode === 'category')
                    {{-- Tableau des catégories --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($items as $cat)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $cat->name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 max-w-xs truncate">{{ $cat->description ?? '—' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button wire:click="openModal({{ $cat->id }})" 
                                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors duration-200 flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    <span>Éditer</span>
                                                </button>
                                                <button wire:click="delete({{ $cat->id }})" 
                                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible."
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
                                            <div class="text-gray-400 flex flex-col items-center space-y-3">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                                <span class="text-lg font-medium text-gray-500">Aucune catégorie trouvée</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Tableau des menus --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Catégorie</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Unités & Prix</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Prix Défaut</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($items as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">{{ $item->nom }}</div>
                                            @if($item->description)
                                                <div class="text-xs text-gray-500 mt-1 max-w-xs truncate">{{ $item->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $item->category->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-1">
                                                @foreach($item->units as $unit)
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">{{ $unit->unit }}</span>
                                                        <span class="font-medium text-green-600">{{ number_format($unit->price, 2) }} FCFA</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-lg font-bold text-gray-900">{{ $item->prix }} FCFA</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $item->disponibilite ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $item->disponibilite ? 'Disponible' : 'Indisponible' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button wire:click="openModal({{ $item->id }})" 
                                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors duration-200 flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    <span>Éditer</span>
                                                </button>
                                                <button wire:click="deleteItem({{ $item->id }})" 
                                                        wire:confirm="Êtes-vous sûr de vouloir supprimer ce menu ? Cette action est irréversible."
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
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 flex flex-col items-center space-y-3">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-lg font-medium text-gray-500">Aucun menu trouvé</span>
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
                    <div class="flex justify-between items-center border-b border-gray-200 pb-6 mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $editingId ? 'Éditer' : 'Créer' }} {{ $mode === 'category' ? 'Catégorie' : 'Menu' }}
                            </h3>
                            <p class="text-gray-600 mt-1">Remplissez les informations ci-dessous</p>
                        </div>
                        <button wire:click="closeModal" 
                                class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Formulaire --}}
                    <form wire:submit.prevent="{{ $mode === 'category' ? 'storeCategory' : 'storeItem' }}">
                        <div class="space-y-6 max-h-96 overflow-y-auto pr-4">
                            @if ($mode === 'category')
                                {{-- Champs catégorie --}}
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de la catégorie *</label>
                                        <input type="text" wire:model.defer="cat_name" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                        @error('cat_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                        <textarea wire:model.defer="cat_description" rows="3"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"></textarea>
                                        @error('cat_description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @else
                                {{-- Champs menu --}}
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom du menu *</label>
                                            <input type="text" wire:model.defer="item_nom" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                            @error('item_nom') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catégorie *</label>
                                            <select wire:model.defer="item_category_id" 
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                                <option value="">Sélectionner une catégorie</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('item_category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                        <textarea wire:model.defer="item_description" rows="2"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"></textarea>
                                        @error('item_description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prix par défaut (XOF) *</label>
                                            <input type="number" step="0.01" wire:model.defer="item_prix" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                            @error('item_prix') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Disponibilité</label>
                                            <select wire:model.defer="item_disponibilite" 
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                                                <option value="1">Disponible</option>
                                                <option value="0">Indisponible</option>
                                            </select>
                                            @error('item_disponibilite') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{-- Upload photo --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Photo du Menu</label>
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors duration-200">
                                            <input type="file" wire:model="item_photo" 
                                                   class="hidden" id="file-upload">
                                            <label for="file-upload" class="cursor-pointer">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <div class="mt-2">
                                                    <span class="text-sm font-medium text-indigo-600">Télécharger une photo</span>
                                                    <span class="text-xs text-gray-500 block">PNG, JPG jusqu'à 2MB</span>
                                                </div>
                                            </label>
                                        </div>
                                        @if($item_temp_photo_path)
                                            <div class="mt-4 flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                                <img src="{{ asset($item_temp_photo_path) }}" class="w-16 h-16 object-cover rounded-lg shadow">
                                                <span class="text-sm text-gray-600">Image actuelle</span>
                                            </div>
                                        @endif
                                        @error('item_photo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Unités de vente --}}
                                    <div class="border-t pt-6">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8l3 5m0 0l3-5m-3 5v4m-3-5h6m-6 3h6m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Unités de vente</span>
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach($menu_units as $index => $unit)
                                                <div class="flex space-x-3 items-start">
                                                    <input type="text" wire:model.defer="menu_units.{{$index}}.unit" 
                                                           placeholder="Ex: Verre, Bouteille..." 
                                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                                    <input type="number" step="0.01" wire:model.defer="menu_units.{{$index}}.price" 
                                                           placeholder="Prix" 
                                                           class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                                    <button type="button" wire:click="removeUnit({{$index}})" 
                                                            class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded transition-colors duration-200">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                            <button type="button" wire:click="addUnit()" 
                                                    class="w-full py-2 border-2 border-dashed border-gray-300 text-gray-600 rounded-lg hover:border-indigo-400 hover:text-indigo-600 transition-colors duration-200 flex items-center justify-center space-x-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                <span>Ajouter une unité de vente</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions du formulaire --}}
                        <div class="flex justify-end space-x-4 pt-6 mt-6 border-t border-gray-200">
                            <button type="button" wire:click="closeModal" 
                                    class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
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