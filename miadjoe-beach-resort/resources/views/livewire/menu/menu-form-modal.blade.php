{{-- MODALE --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex justify-center items-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center border-b pb-3 mb-3">
                        <h3 class="text-lg font-bold text-gray-900">{{ $editingId ? 'Éditer' : 'Créer' }} {{ $mode === 'category' ? 'Catégorie' : 'Menu' }}</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl font-semibold">&times;</button>
                    </div>

                    <form wire:submit.prevent="{{ $mode === 'category' ? 'storeCategory' : 'storeItem' }}">
                        @if ($mode === 'category')
                            <label class="block text-sm font-medium text-gray-700">Nom*</label>
                            <input type="text" wire:model.defer="cat_name" class="mt-1 block w-full p-2 border rounded-md mb-2">
                            @error('cat_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model.defer="cat_description" class="mt-1 block w-full p-2 border rounded-md mb-4"></textarea>
                            @error('cat_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        @else
                            <label class="block text-sm font-medium text-gray-700">Nom*</label>
                            <input type="text" wire:model.defer="item_nom" class="mt-1 block w-full p-2 border rounded-md mb-2">
                            @error('item_nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Prix (€)*</label>
                            <input type="number" step="0.01" wire:model.defer="item_prix" class="mt-1 block w-full p-2 border rounded-md mb-2">
                            @error('item_prix') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Disponibilité</label>
                            <select wire:model.defer="item_disponibilite" class="mt-1 block w-full p-2 border rounded-md mb-2">
                                <option value="1">Disponible</option>
                                <option value="0">Indisponible</option>
                            </select>
                            @error('item_disponibilite') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Catégorie*</label>
                            <select wire:model.defer="item_category_id" class="mt-1 block w-full p-2 border rounded-md mb-2">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('item_category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <label class="block text-sm font-medium text-gray-700">Photo du Menu (optionnel)</label>
                            <input type="file" wire:model="item_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @if($item_temp_photo_path)
                                <div class="mt-2 flex items-center space-x-2">
                                    <img src="{{ asset($item_temp_photo_path) }}" class="w-20 h-20 object-cover rounded">
                                    <span class="text-xs text-gray-500">Image actuelle</span>
                                </div>
                            @endif
                            @error('item_image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        @endif

                        <div class="flex justify-end space-x-3 pt-4 border-t mt-4">
                            <button type="button" wire:click="closeModal" class="py-2 px-4 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-150">Annuler</button>
                            <button type="submit" class="py-2 px-4 bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition duration-150">
                                {{ $editingId ? 'Mettre à jour' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
