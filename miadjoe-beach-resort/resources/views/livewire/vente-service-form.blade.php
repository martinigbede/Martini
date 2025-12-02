<div>
    @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black/40" wire:ignore.self>
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 border border-brown-100 overflow-hidden flex flex-col max-h-[85vh]" wire:key="vente-form-modal">

            {{-- En-tête compact --}}
            <div class="bg-brown-700 px-6 py-4 relative shrink-0">
                <div class="relative flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1">{{ $venteId ? 'Modifier la vente' : 'Nouvelle vente' }}</h3>
                        <p class="text-brown-200 text-xs">Gestion des ventes</p>
                    </div>
                    <button wire:click="fermerModal" class="text-brown-200 hover:text-white transition-colors duration-200 p-1 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Contenu défilant --}}
            <div class="flex-1 overflow-y-auto">
                <div class="p-6 space-y-4">

                    {{-- Informations client --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-brown-800 mb-2">Nom du client</label>
                            <input type="text" wire:model.defer="client_nom" 
                                   class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2.5 px-3 text-sm">
                            @error('client_nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-brown-800 mb-2">Type client</label>
                            <select wire:model.defer="type_client" 
                                    class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2.5 px-3 text-sm">
                                <option value="individuel">Individuel</option>
                                <option value="groupe">Groupe</option>
                            </select>
                            @error('type_client') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Remarque --}}
                    <div>
                        <label class="block text-sm font-medium text-brown-800 mb-2">Remarque</label>
                        <textarea wire:model.defer="remarque" 
                                  class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2.5 px-3 text-sm h-20"></textarea>
                    </div>

                    {{-- Lignes de service --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-brown-800">Lignes de service</h4>
                            <button type="button" wire:click="ajouterLigne" 
                                    class="bg-brown-600 text-white px-3 py-1.5 rounded-lg hover:bg-brown-700 transition text-sm">
                                Ajouter ligne
                            </button>
                        </div>

                        <div class="overflow-x-auto" wire:poll.5000ms>
                            <table class="w-full border-collapse border border-brown-200">
                                <thead>
                                    <tr class="bg-brown-50">
                                        <th class="border border-brown-200 p-2 text-left text-xs font-medium text-brown-800">Service</th>
                                        <th class="border border-brown-200 p-2 text-left text-xs font-medium text-brown-800">Mode</th>
                                        <th class="border border-brown-200 p-2 text-center text-xs font-medium text-brown-800">Qté</th>
                                        <th class="border border-brown-200 p-2 text-center text-xs font-medium text-brown-800">Durée</th>
                                        <th class="border border-brown-200 p-2 text-right text-xs font-medium text-brown-800">Prix</th>
                                        <th class="border border-brown-200 p-2 text-right text-xs font-medium text-brown-800">Total</th>
                                        <th class="border border-brown-200 p-2 text-center text-xs font-medium text-brown-800">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lignes as $index => $ligne)
                                    <tr class="hover:bg-brown-50/50 transition-colors">
                                        <td class="border border-brown-200 p-2">
                                            <select wire:model="lignes.{{ $index }}.service_id" 
                                                    class="w-full border border-brown-200 rounded text-xs py-1 px-2">
                                                <option value="">-- Choisir --</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                                @endforeach
                                            </select>
                                            @error("lignes.$index.service_id") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="border border-brown-200 p-2">
                                            <select wire:model="lignes.{{ $index }}.mode_facturation" 
                                                    class="w-full border border-brown-200 rounded text-xs py-1 px-2">
                                                <option value="fixe">Fixe</option>
                                                <option value="duree">Durée</option>
                                            </select>
                                        </td>
                                        <td class="border border-brown-200 p-2">
                                            <input type="number" wire:model="lignes.{{ $index }}.quantite" min="1" 
                                                   class="w-full border border-brown-200 rounded text-xs py-1 px-2 text-center">
                                        </td>
                                        <td class="border border-brown-200 p-2">
                                            <input type="number" wire:model="lignes.{{ $index }}.duree" min="1" 
                                                   class="w-full border border-brown-200 rounded text-xs py-1 px-2 text-center">
                                        </td>
                                        <td class="border border-brown-200 p-2 text-right text-xs text-brown-700">
                                            {{ $ligne['prix_unitaire'] }}
                                        </td>
                                        <td class="border border-brown-200 p-2 text-right text-xs font-medium text-brown-800">
                                            {{ $ligne['sous_total'] }}
                                        </td>
                                        <td class="border border-brown-200 p-2 text-center">
                                            <button type="button" wire:click="supprimerLigne({{ $index }})" 
                                                    class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">
                                                Suppr
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="text-right font-semibold text-brown-800 border-t border-brown-200 pt-3">
                        Total : {{ $total }}
                    </div>
                </div>
            </div>

            {{-- Footer compact --}}
            <div class="bg-brown-50 px-6 py-4 border-t border-brown-200 shrink-0">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <button type="button" wire:click="fermerModal" 
                            class="order-2 sm:order-1 w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 border border-brown-300 text-brown-700 font-medium rounded-lg hover:bg-brown-100 transition-colors text-sm">
                        Annuler
                    </button>
                    <button type="button" wire:click="validerVente" wire:loading.attr="disabled" 
                            class="order-1 sm:order-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-brown-600 text-white font-medium rounded-lg hover:bg-brown-700 transition-colors text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove>{{ $venteId ? 'Mettre à jour' : 'Enregistrer' }}</span>
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