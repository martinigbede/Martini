<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6 space-x-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher par Menu..."
               class="form-input rounded-lg shadow-sm mt-1 block w-1/3 border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">
        <button  wire:click="openModal" wire:loading.attr="disabled" class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center space-x-2 active:scale-95 relative">
            <!-- Spinner quand on clique -->
            <span wire:loading class="absolute left-3 animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
            <!-- Icône cachée quand ça charge -->
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> 
            <!-- Texte d’origine --> 
            <span wire:loading.remove>Enregistrer Vente</span>
            <!-- Texte pendant l'action --> <span wire:loading>Chargement…</span>
        </button>     

    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow border border-brown-200">
        <table class="min-w-full divide-y divide-brown-200">
            <thead class="bg-brown-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Menus</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Qté Totale</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Total aprés remise</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Montant payé</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Reste à payer</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Réservation / Chambre</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-brown-200">
                @forelse($sales as $sale)
                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brown-900">
                            {{ $sale->date }}
                        </td>
                        <td class="px-6 py-4 text-sm text-brown-700">
                            <ul class="space-y-1">
                                @foreach($sale->items as $item)
                                    <li class="flex justify-between items-center">
                                        <span>{{ $item->menu->nom ?? 'N/A' }}</span>
                                        <span class="text-brown-600 text-xs">
                                            {{ $item->quantite }} x {{ number_format($item->prix_unitaire,2) }} FCFA
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <span class="bg-brown-100 text-brown-800 px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $sale->items->sum('quantite') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                            {{ number_format($sale->total,2) }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                            {{ number_format($sale->montant_final,2) }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                            {{ number_format($sale->montant_paye,2) }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">
                            {{ number_format($sale->reste_a_payer,2) }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $sale->statut_facture === 'Payée' ? 'bg-green-100 text-green-800' : ($sale->statut_facture === 'Partielle' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $sale->statut_facture }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-brown-700">
                            @if($sale->reservation)
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-brown-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Réservation #{{ $sale->reservation->id }}</span>
                                </div>
                                <div class="text-xs text-brown-600 mt-1">
                                    Chambre {{ optional($sale->reservation->items->first()->room)->numero ?? 'N/A' }} <br> {{ $sale->reservation->client->nom ?? 'Inconnu' }}
                                </div>
                            @else
                                <span class="text-brown-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                {{-- Bouton Éditer avec icône --}}
                                <button wire:click="openModal({{ $sale->id }})" 
                                        class="text-brown-600 hover:text-brown-800 p-2 rounded-lg hover:bg-brown-100 transition-colors duration-200"
                                        title="Éditer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                {{-- Bouton Paiement --}}
                                <button wire:click="openPaymentModal({{ $sale->id }})"
                                        class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-100 transition-colors duration-200"
                                        title="Paiement">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                </button>

                                {{-- Bouton Supprimer avec icône --}}
                                <button wire:click="confirmDelete({{ $sale->id }})"
                                        
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                        title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                {{-- Bouton Détails avec icône --}}
                                <button wire:click="openDetailModal({{ $sale->id }})" 
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
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center space-y-3 text-brown-500">
                                <svg class="w-12 h-12 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
                                </svg>
                                <span class="text-lg font-medium">Aucune vente enregistrée</span>
                                <span class="text-sm">Commencez par enregistrer votre première vente</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $sales->links() }}</div>

    @livewire('sale.sale-form-modal', ['saleId' => $saleIdToEdit])
    @livewire('sale.sale-detail-modal')
    {{-- Modal suppression sécurisée --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">

            <h2 class="text-xl font-bold mb-4">Confirmer la suppression</h2>
            <p class="text-gray-600 mb-3">
                Entrez le mot de passe pour supprimer cette vente.
            </p>

            <input type="password"
                wire:model.live="deletePassword"
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
                        wire:click="deleteSecure">
                    Supprimer
                </button>
            </div>

        </div>
    </div>
    @endif
    <livewire:sale.sale-payment-modal />

</div>