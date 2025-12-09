<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
                <h2 class="text-2xl font-bold mb-5 text-gray-800">Paiement de la vente</h2>

                <p class="text-gray-700 mb-4">
                    <span class="font-medium">Vente #{{ $saleId }}</span> – 
                    <span class="font-semibold text-gray-900">
                        {{ number_format($sale->total, 0, ',', ' ') }} F CFA
                    </span>
                </p>

                {{-- Vente liée à réservation : affichage simplifié --}}
                @if ($isLinkedToReservation)
                    <p class="text-gray-700 mb-4">
                        <span class="font-medium">Montant à encaisser (décaissements non encaissés) :</span>
                        <span class="font-bold text-green-700">
                            {{ number_format($montantAEncaisser, 0, ',', ' ') }} F CFA
                        </span>
                    </p>

                    @if ($montantAEncaisser <= 0)
                        <div class="text-red-600 font-semibold mb-4">
                            Aucun décaissement non encaissé trouvé pour cette réservation. Encaissement impossible.
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Mode d'encaissement</label>
                        <select wire:model="modePaiement"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option>Espèces</option>
                            <option>Flooz</option>
                            <option>Mix by Yas</option>
                            <option>Mobile Money</option>
                            <option>Carte/TPE</option>
                            <option>Virement</option>
                        </select>
                    </div>

                @else
                    {{-- Formulaire complet pour vente libre --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Montant payé</label>
                        <input type="number" wire:model="montantPaye"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Mode de paiement</label>
                        <select wire:model="modePaiement"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option>Espèces</option>
                            <option>Flooz</option>
                            <option>Mix by Yas</option>
                            <option>Mobile Money</option>
                            <option>Carte/TPE</option>
                            <option>Virement</option>
                            <option>Offert</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Remise (F CFA)</label>
                        <input type="number" wire:model="remise"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Motif remise</label>
                        <textarea wire:model="motifRemise"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2"
                                  rows="2"></textarea>
                    </div>
                @endif

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg"
                            wire:click="$set('showModal', false)">
                        Fermer
                    </button>

                    <button type="button"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg"
                            wire:click="savePayment"
                            @if($isLinkedToReservation && $montantAEncaisser <= 0) disabled @endif>
                        @if ($isLinkedToReservation)
                            Encaisser
                        @else
                            Valider
                        @endif
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
