<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative border border-brown-200">
        <!-- En-tête -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-brown-800">
                {{ $expenseId ? 'Modifier une dépense' : 'Nouvelle dépense' }}
            </h2>
            <button type="button" wire:click="$dispatch('closeModal')" 
                    class="text-brown-400 hover:text-brown-600 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form wire:submit.prevent="save" class="space-y-5">
            <!-- Catégorie -->
            <div>
                <label class="block text-sm font-medium text-brown-700 mb-2">Catégorie</label>
                <select wire:model="categorie" 
                        class="w-full border border-brown-300 rounded-lg shadow-sm px-4 py-3 focus:ring-brown-400 focus:border-brown-400 transition-colors duration-200">
                    <option value="">-- Sélectionnez une catégorie --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Champ visible uniquement si "Autre" est choisi -->
                @if ($categorie === 'Autre')
                    <input type="text" wire:model="categorie_autre" placeholder="Entrez une nouvelle catégorie"
                        class="mt-3 w-full border border-brown-300 rounded-lg shadow-sm px-4 py-3 focus:ring-brown-400 focus:border-brown-400 transition-colors duration-200" />
                @endif

                @error('categorie') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-brown-700 mb-2">Description</label>
                <textarea wire:model="description" rows="3" placeholder="Description de la dépense..."
                          class="w-full border border-brown-300 rounded-lg shadow-sm px-4 py-3 focus:ring-brown-400 focus:border-brown-400 transition-colors duration-200 resize-none"></textarea>
                @error('description') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Montant et Date -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-brown-700 mb-2">Montant</label>
                    <div class="relative">
                        <input type="number" wire:model="montant" placeholder="0"
                               class="w-full border border-brown-300 rounded-lg shadow-sm px-4 py-3 focus:ring-brown-400 focus:border-brown-400 transition-colors duration-200">
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-brown-500 text-sm">FCFA</span>
                    </div>
                    @error('montant') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-brown-700 mb-2">Date de dépense</label>
                    <input type="date" wire:model="date_depense"
                           class="w-full border border-brown-300 rounded-lg shadow-sm px-4 py-3 focus:ring-brown-400 focus:border-brown-400 transition-colors duration-200">
                    @error('date_depense') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>
            </div>

            <!-- Mode de paiement et Statut -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-brown-700 mb-2">Mode de paiement</label>
                    <select wire:model="mode_paiement"
                            class="w-full border border-brown-300 rounded-lg shadow-sm px-4 py-3 focus:ring-brown-400 focus:border-brown-400 transition-colors duration-200">
                        <option value="Espèces">Espèces</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Carte/TPE">Carte/TPE</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-brown-700 mb-2">Statut</label>
                    <select wire:model="statut"
                            class="w-full border border-brown-300 rounded-lg shadow-sm px-4 py-3 focus:ring-brown-400 focus:border-brown-400 transition-colors duration-200">
                        <option value="validée">Validée</option>
                        <option value="en attente">En attente</option>
                    </select>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end gap-3 pt-4 border-t border-brown-100">
                <button type="button" wire:click="$dispatch('closeModal')" 
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Annuler</span>
                </button>
                
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="px-6 py-3 bg-brown-600 text-white rounded-lg hover:bg-brown-700 
                            transition-colors duration-200 font-medium flex items-center space-x-2 active:scale-95 relative">

                    <!-- Spinner -->
                    <span wire:loading class="absolute left-3 animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>

                    <!-- Icône / texte normal -->
                    <span wire:loading.remove class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Enregistrer</span>
                    </span>

                    <!-- Texte pendant chargement -->
                    <span wire:loading>Chargement…</span>
                </button>   
            </div>
        </form>
    </div>
</div>