<div x-data="{ showModal: @entangle('showModal'), venteId: null }"
     x-on:openPaiementDiversService.window="venteId = $event.detail.venteId; showModal = true;">

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl">
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Paiement – Service #{{ $venteId }}
                </h2>

                {{-- Montant total --}}
                <p class="text-gray-700 mb-2">
                    <span class="font-medium">Montant Total :</span>
                    <span class="font-bold text-gray-900">
                        {{ number_format($total, 0, ',', ' ') }} F CFA
                    </span>
                </p>

                {{-- Déjà payé --}}
                <p class="text-gray-700 mb-2">
                    <span class="font-medium">Déjà payé :</span>
                    <span class="font-bold text-green-700">
                        {{ number_format($alreadyPaid, 0, ',', ' ') }}
                    </span>
                </p>

                {{-- Remise --}}
                <div class="bg-blue-50 p-3 rounded-lg mb-3">
                    <p class="font-medium text-gray-700 mb-2">Remise</p>

                    <div class="flex space-x-2">
                        {{-- Remise % --}}
                        <div class="w-1/2">
                            <label class="text-sm text-gray-700">%</label>
                            <input type="number"
                                wire:model.live="remisePercent"
                                class="w-full border border-gray-300 rounded-lg px-2 py-2"
                                min="0">
                        </div>

                        {{-- Remise montant --}}
                        <div class="w-1/2">
                            <label class="text-sm text-gray-700">Montant</label>
                            <input type="number"
                                wire:model.live="remiseAmount"
                                class="w-full border border-gray-300 rounded-lg px-2 py-2"
                                min="0">
                        </div>
                    </div>

                    {{-- Remise affichée --}}
                    <p class="text-sm text-gray-700 mt-2">
                        Remise appliquée :
                        <span class="font-semibold text-blue-700">
                            {{ number_format($remiseAmount, 0, ',', ' ') }} F
                        </span>
                    </p>
                </div>

                {{-- Montant restant --}}
                <p class="text-gray-800 font-semibold mb-6">
                    Montant restant :
                    <span class="text-blue-700">
                        {{ number_format($remaining, 0, ',', ' ') }}
                    </span>
                </p>

                {{-- Montant à payer --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Montant payé</label>
                    <input 
                        type="number"
                        wire:model="montantPaye"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1"
                    >
                </div>

                {{-- Mode de paiement --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Mode de paiement</label>
                    <select wire:model="modePaiement" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1" >
                        <option value="Espèces">Espèces</option>
                        <option value="Flooz">Flooz</option>
                        <option value="Mix by Yas">Mix by Yas</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Carte/TPE">Carte/TPE</option>
                        <option value="Virement">Virement</option>
                    </select>
                </div>

                {{-- Caisse --}}
                <div class="mb-4 bg-gray-100 rounded-lg p-3">
                    <p class="text-sm text-gray-700">
                        Caisse utilisée :  
                        <span class="font-semibold text-gray-900">
                            {{ $caisseTarget ?? '...' }}
                        </span>
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end space-x-3 mt-6">
                    <button
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg"
                        wire:click="fermer"
                    >
                        Annuler
                    </button>

                    <button
                        class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700"
                        wire:click="payer"
                        @if($remaining <= 0) disabled @endif
                    >
                        Valider Paiement
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
