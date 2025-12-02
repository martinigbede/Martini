<div class="p-6 bg-white rounded-2xl shadow-lg border border-gray-100">

    {{-- Message de succès --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-700 font-medium">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    {{-- En-tête avec titre et bouton --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 bg-gradient-to-r from-gray-900 to-brown-800 bg-clip-text text-transparent">
                Gestion des Services
            </h2>
            <p class="text-gray-600 mt-1">Liste des services disponibles</p>
        </div>
        <button wire:click="openModal()" 
            class="bg-gradient-to-r from-brown-600 to-brown-800 hover:from-brown-700 hover:to-brown-900 text-white font-semibold px-6 py-3 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Ajouter un service</span>
        </button>
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-brown-50 to-brown-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-brown-900 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-brown-900 uppercase tracking-wider">Prix (FCFA)</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-brown-900 uppercase tracking-wider">Disponible</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-brown-900 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($services as $service)
                        <tr class="hover:bg-brown-50/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-brown-500 to-brown-700 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                        {{ strtoupper(substr($service->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">{{ $service->nom }}</span>
                                        @if($service->description)
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $service->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-lg font-bold text-brown-700">{{ number_format($service->prix, 0, ',', ' ') }} F</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $service->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    @if($service->disponible)
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Disponible
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Indisponible
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-3">
                                    <button wire:click="openModal({{ $service->id }})" 
                                        class="inline-flex items-center space-x-1 text-brown-600 hover:text-brown-800 font-semibold transition-colors duration-200 p-2 rounded-lg hover:bg-brown-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span>Modifier</span>
                                    </button>
                                    <button wire:click="deleteService({{ $service->id }})" 
                                        class="inline-flex items-center space-x-1 text-red-600 hover:text-red-800 font-semibold transition-colors duration-200 p-2 rounded-lg hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span>Supprimer</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center space-y-3">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"></path>
                                    </svg>
                                    <span class="text-gray-500 text-lg font-medium">Aucun service enregistré</span>
                                    <p class="text-gray-400">Commencez par créer votre premier service</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODALE --}}
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-brown-600 to-brown-800 rounded-full flex items-center justify-center text-white">
                            @if($serviceId)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ $serviceId ? 'Modifier le service' : 'Ajouter un service' }}
                        </h3>
                    </div>
                </div>

                <form wire:submit.prevent="saveService" class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nom du service</label>
                        <input type="text" wire:model="nom" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200"
                            placeholder="Entrez le nom du service">
                        @error('nom') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea wire:model="description" rows="3"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200"
                            placeholder="Description du service..."></textarea>
                        @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Prix (FCFA)</label>
                        <input type="number" wire:model="prix" step="0.01"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200"
                            placeholder="0.00">
                        @error('prix') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-xl">
                        <input type="checkbox" wire:model="disponible" 
                            class="w-4 h-4 text-brown-600 border-gray-300 rounded focus:ring-brown-500">
                        <label class="text-sm font-medium text-gray-700">Service disponible</label>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeModal" 
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            Annuler
                        </button>
                        <button type="submit" 
                            class="bg-gradient-to-r from-brown-600 to-brown-800 hover:from-brown-700 hover:to-brown-900 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            {{ $serviceId ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>