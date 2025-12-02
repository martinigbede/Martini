{{-- resources/views/livewire/room-type/room-type-management.blade.php --}}
<div>
    {{-- Messages de notification --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('warning') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6 space-x-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher par Nom ou Description..."
               class="form-input rounded-lg shadow-sm mt-1 block w-1/3 border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">

        <div class="flex space-x-3 items-center">
            <select wire:model="perPage" class="form-select rounded-lg shadow-sm border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>

            <button wire:click="create"
                    class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Ajouter Type de Chambre</span>
            </button>
        </div>
    </div>

    {{-- Table des Types de Chambres --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-brown-200">
        <table class="min-w-full divide-y divide-brown-200">
            <thead class="bg-brown-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Photo</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Prix Base</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Max Pers.</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-brown-200">
                @forelse ($roomTypes as $rt)
                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($rt->photo)
                                <img src="{{ asset('storage/' . $rt->photo) }}" alt="{{ $rt->nom }}" class="h-12 w-16 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="h-12 w-16 bg-brown-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-brown-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-brown-900">{{ $rt->nom }}</div>
                            @if($rt->description)
                                <div class="text-xs text-brown-600 truncate max-w-xs">{{ $rt->description }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brown-900">
                            {{ number_format($rt->prix_base, 2) }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-brown-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm text-brown-700">{{ $rt->nombre_personnes_max }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                {{-- Bouton Éditer avec icône --}}
                                <button wire:click="edit({{ $rt->id }})" 
                                        class="text-brown-600 hover:text-brown-800 p-2 rounded-lg hover:bg-brown-100 transition-colors duration-200"
                                        title="Éditer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                {{-- Bouton Supprimer avec icône --}}
                                <button wire:click="delete({{ $rt->id }})"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer le type de chambre {{ $rt->nom }} ?"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                        title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center space-y-3 text-brown-500">
                                <svg class="w-12 h-12 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <span class="text-lg font-medium">Aucun type de chambre trouvé</span>
                                <span class="text-sm">Essayez de modifier vos critères de recherche</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $roomTypes->links() }}
    </div>

    {{-- MODAL FORMULAIRE (Création/Édition) --}}
    @if ($isModalOpen)
        @include('livewire.room-type.room-type-form-modal')
    @endif

</div>