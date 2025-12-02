{{-- MODAL DE CRÉATION/ÉDITION --}}
@if ($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            {{-- Overlay avec animation --}}
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm animate-fade-in" 
                 wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal Panel --}}
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full animate-scale-in">
                {{-- En-tête du modal --}}
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-blue-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-blue-900" id="modal-title">
                                {{ $isEditing ? '✏️ Modifier la Chambre' : '➕ Créer une Nouvelle Chambre' }}
                            </h3>
                            <p class="text-sm text-blue-600 mt-1">
                                {{ $isEditing ? 'Mettez à jour les informations de la chambre' : 'Remplissez les informations de la nouvelle chambre' }}
                            </p>
                        </div>
                        <button wire:click="closeModal" 
                                class="text-blue-400 hover:text-blue-600 hover:bg-blue-100 rounded-full p-2 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="save">
                    <div class="bg-white px-6 py-6 max-h-[70vh] overflow-y-auto">
                        <div class="space-y-6">
                            {{-- Numéro --}}
                            <div>
                                <label for="numero" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    <span>Numéro de Chambre *</span>
                                </label>
                                <input type="text" id="numero" wire:model.defer="numero" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400">
                                @error('numero') 
                                    <span class="text-red-500 text-xs mt-2 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>

                            {{-- Type de Chambre --}}
                            <div>
                                <label for="room_type_id" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>Type de Chambre *</span>
                                </label>
                                <select id="room_type_id" wire:model.defer="room_type_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    <option value="" class="text-gray-400">-- Sélectionner un type --</option>
                                    @foreach($roomTypes as $type)
                                        <option value="{{ $type->id }}" class="text-gray-700">
                                            {{ $type->nom }} - {{ number_format($type->prix_base, 0, ',', ' ') }} FCFA
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_type_id') 
                                    <span class="text-red-500 text-xs mt-2 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>

                            {{-- Statut --}}
                            <div>
                                <label for="statut" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Statut *</span>
                                </label>
                                <select id="statut" wire:model.defer="statut" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                    <option value="Libre" class="text-green-600">🟢 Libre</option>
                                    <option value="Occupée" class="text-red-600">🔴 Occupée</option>
                                    <option value="Nettoyage" class="text-yellow-600">🟡 Nettoyage</option>
                                    <option value="Maintenance" class="text-orange-600">🟠 Maintenance</option>
                                </select>
                                @error('statut') 
                                    <span class="text-red-500 text-xs mt-2 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>

                            {{-- Prix Personnalisé --}}
                            <div>
                                <label for="prix_personnalise" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    <span>Prix Personnalisé (Optionnel)</span>
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.01" id="prix_personnalise" wire:model.defer="prix_personnalise" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 pr-12"
                                           placeholder="Laisser vide pour le prix par défaut">
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">FCFA</span>
                                </div>
                                @error('prix_personnalise') 
                                    <span class="text-red-500 text-xs mt-2 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                    <span>Description/Commentaire</span>
                                </label>
                                <textarea id="description" wire:model.defer="description" rows="3" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none placeholder-gray-400"
                                          placeholder="Notes supplémentaires sur la chambre..."></textarea>
                                @error('description') 
                                    <span class="text-red-500 text-xs mt-2 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>

                            {{-- Upload Photos Multiples --}}
                            <div>
                                <label for="photos" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Photos {{ !$isEditing ? '(Min. 4 à la création)' : '' }}</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition-colors duration-200">
                                    <input type="file" id="photos" wire:model.defer="newPhotos" multiple 
                                           class="hidden">
                                    <label for="photos" class="cursor-pointer">
                                        <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="mt-2">
                                            <span class="text-sm font-medium text-blue-600">Cliquez pour télécharger des photos</span>
                                            <span class="text-xs text-gray-500 block mt-1">PNG, JPG jusqu'à 2MB par fichier</span>
                                        </div>
                                    </label>
                                </div>
                                
                                @if ($this->newPhotos)
                                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <p class="text-sm text-blue-700 font-medium flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ count($this->newPhotos) }} fichier(s) sélectionné(s)</span>
                                        </p>
                                    </div>
                                @endif
                                
                                @error('newPhotos.*') 
                                    <span class="text-red-500 text-xs mt-2 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Une ou plusieurs photos sont invalides</span>
                                    </span>
                                @enderror
                                @error('newPhotos') 
                                    <span class="text-red-500 text-xs mt-2 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Pied du Modal --}}
                    <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 rounded-b-2xl">
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                            <button type="button" wire:click="closeModal"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center justify-center space-x-2 order-2 sm:order-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>Annuler</span>
                            </button>
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2 order-1 sm:order-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ $isEditing ? 'Mettre à jour' : 'Créer la chambre' }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
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

        /* Scrollbar personnalisée */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endif