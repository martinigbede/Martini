<div 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    @if(!$showModal) style="display:none;" @endif
>
    <div class="bg-white rounded shadow-lg w-full max-w-lg p-6">

        {{-- Vérifier que la réservation est chargée --}}
        @if($reservation)
            <h2 class="text-xl font-semibold mb-4">
                Paiement réservation #{{ $reservation->id }}
            </h2>

            <div class="mb-4">
                <p><strong>Client :</strong> {{ $reservation->client->nom ?? 'N/A' }}</p>
                <p><strong>Total facture :</strong> {{ number_format($totalInvoice, 2, ',', ' ') }} FCFA</p>
                <p><strong>Déjà payé :</strong> {{ number_format($alreadyPaid, 2, ',', ' ') }} FCFA</p>
                <p><strong>Reste à payer :</strong> {{ number_format($remaining, 2, ',', ' ') }} FCFA</p>
            </div>

            <div class="mb-4">
                <label for="paymentAmount" class="block font-medium">Montant à payer</label>
                <input type="number" id="paymentAmount" wire:model.defer="paymentAmount"
                       class="border rounded w-full p-2" min="0" step="0.01">
            </div>

            <div class="mb-4">
                <label for="paymentMode" class="block font-medium">Mode de paiement</label>
                <select id="paymentMode" wire:model.defer="paymentMode" class="border rounded w-full p-2">
                    <option>Espèces</option>
                    <option>Mobile Money</option>
                    <option>Carte/TPE</option>
                    <option>virement</option>
                    <option>Offert</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="discount" class="block font-medium">Remise</label>
                <input type="number" id="discount" wire:model.defer="discount"
                       class="border rounded w-full p-2" min="0" step="0.01">
            </div>

            <div class="mb-4">
                <label for="motifRemise" class="block font-medium">Motif remise</label>
                <input type="text" id="motifRemise" wire:model.defer="motifRemise"
                       class="border rounded w-full p-2">
            </div>

            <div class="flex justify-end space-x-2">
                <button wire:click="closeModal" class="bg-gray-300 px-4 py-2 rounded">Annuler</button>
                <button wire:click="settlePayment" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Enregistrer
                </button>
            </div>

        @else
            <p>Chargement de la réservation...</p>
        @endif

    </div>
</div>
