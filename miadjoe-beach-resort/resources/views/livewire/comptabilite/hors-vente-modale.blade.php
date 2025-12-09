<div>

    {{-- Message succès si nécessaire --}}
    @if (session('success'))
        <div class="text-green-600 font-semibold mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

            <div class="bg-white w-full max-w-lg p-6 rounded shadow-lg">

                <h2 class="text-xl font-bold mb-4">Ajouter un apport hors vente</h2>

                <div class="space-y-4">

                    {{-- Montant --}}
                    <div>
                        <label class="block font-semibold mb-1">Montant</label>
                        <input type="number" wire:model="montant" class="w-full border rounded px-3 py-2">
                        @error('montant') 
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Mode paiement --}}
                    <div>
                        <label class="block font-semibold mb-1">Mode de paiement</label>
                        <select wire:model="mode_paiement" class="w-full border rounded px-3 py-2">
                            <option value="Espèces">Espèces</option>
                            <option value="Flooz">Flooz</option>
                            <option value="Mix by Yas">Mix by Yas</option>

                        </select>
                        @error('mode_paiement')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Motif --}}
                    <div>
                        <label class="block font-semibold mb-1">Motif (optionnel)</label>
                        <textarea wire:model="motif" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                    </div>

                </div>

                {{-- Action buttons --}}
                <div class="mt-6 flex justify-end space-x-3">

                    <button 
                        wire:click="$set('showModal', false)"
                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500"
                    >
                        Annuler
                    </button>

                    <button 
                        wire:click="save"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                    >
                        Enregistrer
                    </button>

                </div>

            </div>

        </div>
    @endif

</div>
