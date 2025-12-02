<div>
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50" x-data>
            <div class="fixed inset-0 bg-brown-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 my-8 z-50 relative">
                {{-- Header --}}
                <div class="bg-brown-700 px-6 py-4 rounded-t-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-white">💰 Solder / Prolonger</h2>
                            <p class="text-brown-200 text-xs mt-1">Gestion du paiement et prolongation</p>
                        </div>
                        <button wire:click="closeModal" 
                                class="text-brown-200 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-1 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Messages --}}
                <div class="px-6 pt-4">
                    @if(session()->has('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-lg mb-4 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session()->has('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded-lg mb-4 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                {{-- Contenu --}}
                <div class="p-6 space-y-4">
                    {{-- Informations client et chambres fusionnées --}}
                    <div class="bg-brown-50 p-4 rounded-lg border border-brown-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs font-medium text-brown-600 mb-1">Client</div>
                                <div class="text-sm text-brown-800">{{ $reservation->client->nom }} {{ $reservation->client->prenom }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-brown-600 mb-1">Chambres</div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($reservation->rooms as $room)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-brown-100 text-brown-800 border border-brown-200">
                                            {{ $room->numero }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Détails financiers --}}
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="text-center p-3 bg-brown-50 rounded-lg border border-brown-200">
                            <div class="text-xs text-brown-600 mb-1">Montant Final</div>
                            <div class="text-sm font-semibold text-brown-800">{{ number_format($totalInvoice, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="text-xs text-green-600 mb-1">Déjà Payé</div>
                            <div class="text-sm font-semibold text-green-600">{{ number_format($alreadyPaid, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg border border-red-200">
                            <div class="text-xs text-red-600 mb-1">Reste à Payer</div>
                            <div class="text-sm font-semibold text-red-600">{{ number_format($remaining, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>

                    {{-- Prolongation et Paiement sur 2 colonnes --}}
                    <div class="bg-brown-50 p-4 rounded-lg border border-brown-200">
                        <h3 class="text-sm font-semibold text-brown-800 mb-3">Prolongation et Paiement</h3>
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Colonne Prolongation --}}
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-brown-700 mb-1">Nouvelle date de départ</label>
                                    <input type="date" wire:model="newCheckOut" 
                                           class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3 text-sm bg-white">
                                </div>
                            </div>

                            {{-- Colonne Paiement --}}
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-brown-700 mb-1">Montant</label>
                                    <input type="number" wire:model="paymentAmount" 
                                           class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3 text-sm bg-white"
                                           placeholder="Montant en FCFA">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-brown-700 mb-1">Mode de paiement</label>
                                    <select wire:model="paymentMode" 
                                            class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3 text-sm bg-white">
                                        <option>Espèces</option>
                                        <option>Carte/TPE</option>
                                        <option>Mobile Money</option>
                                        <option>Offert</option>
                                        <option>Virement</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Remise sur une ligne complète --}}
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <div>
                                <label class="block text-xs font-medium text-brown-700 mb-1">Remise (FCFA)</label>
                                <input type="number" wire:model="discount"
                                    class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3 text-sm bg-white"
                                    placeholder="Ex: 2000">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-brown-700 mb-1">Motif de la remise</label>
                                <input type="text" wire:model="motifRemise"
                                    class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3 text-sm bg-white"
                                    placeholder="Ex: Promotion spéciale">
                            </div>
                        </div>
                    </div>

                    {{-- Résumé action --}}
                    @if($paymentAmount > 0)
                        <div class="bg-amber-50 p-3 rounded-lg border border-amber-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-xs font-semibold text-amber-800">Action en attente</div>
                                    <div class="text-xs text-amber-600">
                                        @if($newCheckOut && $newCheckOut > $reservation->check_out)
                                            📅 Prolongation + 
                                        @endif
                                        💰 Paiement de {{ number_format($paymentAmount, 0, ',', ' ') }} FCFA
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-amber-600">
                                        Nouveau solde: {{ number_format(max(0, $remaining - $paymentAmount), 0, ',', ' ') }} FCFA
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="bg-brown-50 px-6 py-4 rounded-b-xl border-t border-brown-200">
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <button wire:click="closeModal" 
                                class="order-2 sm:order-1 w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-brown-300 text-brown-700 font-medium rounded-lg hover:bg-brown-100 transition-colors text-sm">
                            Annuler
                        </button>

                        <button wire:click="settlePayment" 
                                wire:loading.attr="disabled"
                                class="order-1 sm:order-2 w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-brown-600 text-white font-medium rounded-lg hover:bg-brown-700 transition-colors text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove class="flex items-center">
                                <span>Enregistrer</span>
                            </span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Traitement...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>