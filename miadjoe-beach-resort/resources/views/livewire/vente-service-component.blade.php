<div>
    {{-- Messages de notification --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-sm">
            <span>{{ session('message') }}</span>
            <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-sm">
            <span>{{ session('warning') }}</span>
            <button type="button" class="text-yellow-700 hover:text-yellow-900" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
    {{-- Bouton pour créer une nouvelle vente --}}
    <div class="flex justify-end mb-4">
        <button
            wire:click="openVenteModalProxy"
            wire:loading.attr="disabled"
            class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center space-x-2 active:scale-95 relative">

            <span wire:loading class="absolute left-3 animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>

            <span wire:loading.remove>Nouvelle vente</span>
            <span wire:loading>Chargement…</span>
        </button>

    </div>

    {{-- Table des ventes --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-brown-200">
        <table class="min-w-full divide-y divide-brown-200">
            <thead class="bg-brown-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-brown-200">
                @forelse($ventes as $vente)
                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $vente->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-900">{{ $vente->client_nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-900">{{ $vente->type_client }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-900">
                            @foreach($vente->items as $item)
                                <span class="block">{{ $item->service->nom ?? '—' }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brown-900">{{ number_format($vente->total, 2) }} FCFA</td>
                        <td class="px-4 py-2">
                            @if($vente->statut === 'Payé')
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Payée</span>
                            @else
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">En attente</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button wire:click="editVente({{ $vente->id }})"
                                        class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-100 transition-colors duration-200"
                                        title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                {{-- Bouton Paiement --}}
                                <button wire:click="payerService({{ $vente->id }})"
                                        class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-100 transition-colors duration-200"
                                        title="Paiement">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                </button>
                                <button wire:click="confirmDeleteVente({{ $vente->id }})"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                        title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                {{-- Bouton Détails avec icône --}}
                                <button wire:click="openDetailModal({{ $vente->id }})" 
                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-100 transition-colors duration-200"
                                        title="Voir Détails">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center space-y-3 text-brown-500">
                                <svg class="w-12 h-12 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="text-lg font-medium">Aucune vente trouvée</span>
                                <span class="text-sm">Essayez de modifier vos critères de recherche</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- ✅ Pagination --}}
    <div class="p-4 border-t border-brown-100 bg-brown-50/50">
        {{ $ventes->links() }}
    </div>

    {{-- Formulaire enfant --}}
    <livewire:vente-service-form />
    <livewire:divers-service-detail-modal />

    {{-- Modal suppression sécurisée --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">

            <h2 class="text-xl font-bold mb-4">Confirmer la suppression</h2>
            <p class="text-gray-600 mb-3">
                Entrez le mot de passe pour supprimer définitivement cette vente.
            </p>

            <input type="password" wire:model="deletePassword"
                class="w-full border rounded p-2 mb-2"
                placeholder="Mot de passe">

            @if($errorDeletePassword)
                <p class="text-red-600 text-sm mb-2">{{ $errorDeletePassword }}</p>
            @endif

            <div class="flex justify-end space-x-3 mt-4">
                <button class="px-4 py-2 bg-gray-300 rounded"
                        wire:click="$set('showDeleteModal', false)">
                    Annuler
                </button>

                <button class="px-4 py-2 bg-red-600 text-white rounded"
                        wire:click="deleteVenteSecure">
                    Supprimer
                </button>
            </div>
        </div>
    </div>
    @endif
    <livewire:divers-service-payment-modal />

</div>
