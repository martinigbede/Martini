<div>
    @if($show)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
            
            <!-- Boîte blanche avec hauteur max -->
            <div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-xl max-h-[380px] overflow-y-auto">

                <h2 class="text-xl font-semibold mb-4 border-b pb-2">
                    Encaissement des décaissements
                </h2>

                <!-- Sélection de la caisse -->
                <div class="mb-4">
                    <label class="font-medium">Sélectionner la caisse :</label>
                    <select wire:model="caisseId" class="border rounded px-3 py-2 w-full mt-1">
                        <option value="">Choisir une caisse</option>
                        @foreach($caisses as $c)
                            <option value="{{ $c->id }}">
                                {{ $c->nom_compte }} — Solde: {{ number_format($c->solde, 0, ',', ' ') }}
                            </option>
                        @endforeach
                    </select>
                    @error('caisseId') 
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Liste des décaissements (scroll si trop long) -->
                <div class="border rounded-md overflow-hidden mb-4">
                    <table class="w-full table-auto text-sm">
                        <thead class="bg-gray-100 text-left">
                            <tr>
                                <th class="px-3 py-2 border">Montant</th>
                                <th class="px-3 py-2 border">Motif</th>
                                <th class="px-3 py-2 border text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($decaissementsNonEncaisse as $dec)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border font-medium">
                                        {{ number_format($dec->montant, 0, ',', ' ') }} 
                                    </td>
                                    <td class="px-3 py-2 border">{{ $dec->motif }}</td>
                                    <td class="px-3 py-2 border text-center">
                                        <button 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded"
                                            wire:click="encaisserUn({{ $dec->id }})"
                                        >
                                            Encaisser
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            @if($decaissementsNonEncaisse->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-500">
                                        Aucun décaissement en attente.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Boutons actions -->
                <div class="flex justify-between mt-4">

                    @if(!$decaissementsNonEncaisse->isEmpty())
                        <button 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
                            wire:click="encaisserTout"
                        >
                            Encaisser tout
                        </button>
                    @endif

                    <button 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                        wire:click="$set('show', false)"
                    >
                        Fermer
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
