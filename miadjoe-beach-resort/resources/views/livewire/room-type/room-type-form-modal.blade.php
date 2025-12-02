{{-- MODAL DE CRÉATION/ÉDITION --}}
@if ($isModalOpen)
    <div class="fixed inset-0 overflow-y-auto z-50">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            {{-- Overlay --}}
            <div class="fixed inset-0 transition-opacity bg-brown-900 bg-opacity-50" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal Panel --}}
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-brown-200">
                <form wire:submit.prevent="save">
                    {{-- En-tête du modal --}}
                    <div class="bg-gradient-to-r from-brown-600 to-brown-800 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white" id="modal-title">
                            {{ $isEditing ? '✏️ Modifier le Type de Chambre' : '➕ Créer un Nouveau Type de Chambre' }}
                        </h3>
                    </div>

                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="space-y-5">
                            {{-- Nom --}}
                            <div>
                                <label for="nom" class="block text-sm font-medium text-brown-700 mb-2">Nom du Type</label>
                                <input type="text" id="nom" wire:model.defer="nom" 
                                       class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                @error('nom') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-brown-700 mb-2">Description</label>
                                <textarea id="description" wire:model.defer="description" rows="3" 
                                          class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50 resize-none"></textarea>
                                @error('description') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Prix Base --}}
                                <div>
                                    <label for="prix_base" class="block text-sm font-medium text-brown-700 mb-2">Prix de Base (FCFA)</label>
                                    <input type="number" step="0.01" id="prix_base" wire:model.defer="prix_base" 
                                           class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                    @error('prix_base') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Nombre Personnes Max --}}
                                <div>
                                    <label for="nombre_personnes_max" class="block text-sm font-medium text-brown-700 mb-2">Max Personnes</label>
                                    <input type="number" id="nombre_personnes_max" wire:model.defer="nombre_personnes_max" 
                                           class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                    @error('nombre_personnes_max') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            {{-- Photo Illustrative --}}
                            <div>
                                <label for="photo" class="block text-sm font-medium text-brown-700 mb-2">Photo Illustrative</label>
                                <input type="file" id="photo" wire:model.defer="photo" 
                                       class="mt-1 block w-full text-sm text-brown-600
                                              file:mr-4 file:py-3 file:px-4
                                              file:rounded-xl file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-brown-100 file:text-brown-700
                                              hover:file:bg-brown-200 transition-colors duration-200">
                                @error('photo') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror

                                @if ($photo_path && !$photo)
                                    <div class="mt-3 p-3 bg-brown-50 rounded-xl border border-brown-200">
                                        <p class="text-xs text-brown-600 font-medium mb-2">Image Actuelle :</p>
                                        <img src="{{ asset('storage/' . $photo_path) }}" class="h-20 w-auto rounded-lg shadow-sm">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Pied du Modal --}}
                    <div class="bg-gradient-to-r from-brown-50 to-amber-50 px-6 py-4 border-t border-brown-200">
                        <div class="flex flex-col sm:flex-row gap-3 justify-end">
                            <button type="button" wire:click="closeModal"
                                    class="order-2 sm:order-1 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border-2 border-brown-300 text-brown-700 font-medium rounded-xl hover:bg-brown-100 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Annuler
                            </button>
                            <button type="submit"
                                    class="order-1 sm:order-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $isEditing ? 'Mettre à Jour' : 'Créer' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif