<div>
    @if($show)
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-xl">

            <h2 class="text-xl font-semibold mb-4">
                Décaissement - {{ $typeCaisse }}
            </h2>

            {{-- Messages flash --}}
            @if(session('error'))
                <p class="text-red-600 text-sm mb-2">{{ session('error') }}</p>
            @endif

            @if(session('success'))
                <p class="text-green-600 text-sm mb-2">{{ session('success') }}</p>
            @endif

            <div class="space-y-4">
                <div>
                    <label>Montant</label>
                    <input type="number" wire:model="montant" class="w-full border rounded p-2">
                    @error('montant') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label>Motif</label>
                    <input type="text" wire:model="motif" class="w-full border rounded p-2">
                    @error('motif') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label>Mode de paiement</label>
                    <select wire:model="mode" class="w-full border rounded p-2">
                        <option value="Espèces">Espèces</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Flooz">Flooz</option>
                        <option value="Mix by Yas">Mix by Yas</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button wire:click="$set('show', false)"
                    class="px-4 py-2 bg-gray-300 rounded">
                    Annuler
                </button>

                <button wire:click="decaisser"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                    Valider
                </button>
            </div>

        </div>
    </div>
    @endif
</div>
