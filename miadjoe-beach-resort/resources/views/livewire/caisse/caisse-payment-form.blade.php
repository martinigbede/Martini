<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">

                <h2 class="text-2xl font-bold mb-5 text-gray-800">Paiement de la vente</h2>

                <p class="text-gray-700 mb-4">
                    <span class="font-medium">Vente #{{ $venteId }}</span> – 
                    <span class="font-semibold text-gray-900">
                        {{ number_format($invoice->montant_final ?? 0, 0, ',', ' ') }} F CFA
                    </span>
                </p>

                {{-- Solde restant --}}
                <p class="text-gray-700 mb-4">
                    <span class="font-medium">Reste à payer :</span>
                    <span class="font-bold text-red-600">
                        {{ number_format(max(0, ($invoice->montant_final ?? $invoice->montant_total ?? 0) - ($invoice->montant_paye ?? 0)), 0, ',', ' ') }} F CFA
                    </span>
                </p>

                {{-- Formulaire de paiement --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Montant payé</label>
                    <input type="number" wire:model="paymentAmount"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2"
                           placeholder="Montant en F CFA">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Mode de paiement</label>
                    <select wire:model="paymentMode"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Espèces</option>
                        <option>Mobile Money</option>
                        <option>Carte/TPE</option>
                        <option>Virement</option>
                        <option>Offert</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Remise (F CFA)</label>
                    <input type="number" wire:model="remiseAmount"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2"
                           placeholder="Montant de la remise">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Motif remise</label>
                    <textarea wire:model="motifRemise"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2"
                              rows="2"
                              placeholder="Motif de la remise"></textarea>
                </div>

                {{-- Boutons --}}
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg"
                            wire:click="closeModal">
                        Fermer
                    </button>

                    <button type="button"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg"
                            wire:click="enregistrerPaiement"
                            @if($paymentAmount <= 0 && !$isOffert) disabled @endif>
                        Valider
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
