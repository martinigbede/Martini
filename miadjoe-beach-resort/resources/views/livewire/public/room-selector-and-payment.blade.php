{{-- resources/views/livewire/public/room-selector-and-payment.blade.php --}}
<div>
    <div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow-xl rounded-lg border border-gray-200">
        
        <h2 class="text-2xl font-light text-gray-900 mb-6 border-b pb-2">
            Étape 2/2 : Sélectionnez Votre Chambre & Payez
        </h2>

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Résumé de la recherche (non modifiable ici) --}}
        <div class="mb-6 p-3 border rounded-lg bg-indigo-50 text-sm">
            <p><strong>Dates:</strong> {{ $check_in }} au {{ $check_out }} ({{ $nights }} nuit(s))</p>
            <p><strong>Nb Pers:</strong> {{ $search_nb_personnes }} (Lit d'appoint: {{ $lit_dappoint ? 'Oui' : 'Non' }})</p>
        </div>
        
        {{-- ÉTAPE 2A: SÉLECTION DE LA CHAMBRE --}}
        <div class="mb-6 p-4 border rounded-lg bg-gray-50">
            <h3 class="font-semibold mb-2">Choisissez une chambre parmi les disponibles :</h3>
            
            <div class="space-y-2">
                @forelse($availableRooms as $room)
                    <div class="flex items-center justify-between p-3 border rounded-lg bg-white hover:bg-gray-50">
                        <div class="flex-1">
                            <p class="font-bold">{{ $room['numero'] }} (Type: {{ $room['roomType']['nom'] ?? 'N/A' }})</p>
                            <p class="text-xs text-gray-500">Capacité: {{ $room['roomType']['nombre_personnes_max'] }} max</p>
                        </div>
                        
                        {{-- Option de sélection --}}
                        <div class="flex items-center space-x-4">
                            <span class="text-lg font-bold text-green-700">
                                {{ number_format($room['roomType']['prix_base'], 2) }} FCFA
                            </span>
                            <button type="button" wire:click="$set('selectedRoomId', {{ $room['id'] }})"
                                    class="px-4 py-2 border rounded-lg text-sm font-medium transition-colors 
                                           {{ $selectedRoomId == $room['id'] ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-indigo-600 border-indigo-300 hover:bg-indigo-50' }}">
                                {{ $selectedRoomId == $room['id'] ? 'Sélectionné' : 'Sélectionner' }}
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-red-500">Aucune chambre exacte disponible. Veuillez revenir à l'étape précédente.</p>
                @endforelse
            </div>
            @error('selectedRoomId') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
        </div>

        {{-- ÉTAPE 2B: INFORMATIONS CLIENT & PAIEMENT --}}
        @if($selectedRoomId)
        <div class="space-y-6">
            {{-- Bloc Client (Tous les champs sont requis pour une réservation publique) --}}
            <div class="p-4 border rounded-lg bg-gray-50">
                <h3 class="font-semibold mb-3">Vos Coordonnées</h3>
                <div class="grid grid-cols-2 gap-4">
                    <input type="email" wire:model.defer="client_email" placeholder="Email *" class="form-input w-full">
                    @error('client_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                    <input type="text" wire:model.defer="client_nom" placeholder="Nom *" class="form-input w-full">
                    @error('client_nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                    <input type="text" wire:model.defer="client_prenom" placeholder="Prénom (Optionnel)" class="form-input w-full">
                    @error('client_prenom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                    <input type="text" wire:model.defer="client_telephone" placeholder="Téléphone *" class="form-input w-full">
                    @error('client_telephone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Bouton de Finalisation & Paiement --}}
            <div class="p-4 border-t pt-4">
                <button type="submit" wire:click="processOnlinePayment" 
                        class="w-full py-4 bg-indigo-600 text-white font-bold text-lg rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        @if(!$selectedRoomId || !$check_in || !$check_out || !$total || !$client_nom) disabled @endif
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        Payer {{ number_format($total, 2) }} FCFA et Réserver
                    </span>
                    <span wire:loading>
                         <svg class="animate-spin h-5 w-5 text-white mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Redirection Paiement...
                    </span>
                </button>
            </div>
        </div>
        @else
            <p class="text-center text-gray-500 mt-8">Veuillez effectuer une recherche valide pour commencer.</p>
        @endif

    </div>
</div>