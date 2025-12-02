{{-- resources/views/livewire/reservation/reservation-form-pro.blade.php --}}
<div class="fixed inset-0 flex items-center justify-center z-50 bg-black/40" wire:ignore.self>
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 border border-brown-100 overflow-hidden flex flex-col max-h-[85vh]" wire:key="reservation-form-pro">

        {{-- En-tête compact --}}
        <div class="bg-brown-700 px-6 py-4 relative shrink-0">
            <div class="relative flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-1">Nouvelle Réservation</h3>
                    <p class="text-brown-200 text-xs">Gestion des réservations</p>
                </div>
                <button wire:click="closeModal" class="text-brown-200 hover:text-white transition-colors duration-200 p-1 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-2 mx-6 mt-3 rounded flex items-center text-sm shrink-0">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-2 mx-6 mt-3 rounded flex items-center text-sm shrink-0">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Contenu défilant --}}
        <div class="flex-1 overflow-y-auto">
            <div class="p-6 space-y-4">

                {{-- Client en une ligne --}}
                <div class="grid grid-cols-1 gap-3">
                    <label class="block text-sm font-medium text-brown-800">Client</label>
                    <select wire:model.live="selectedClientId" 
                            class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 transition-colors py-2.5 px-3 text-sm">
                        <option value="">— Sélectionner un client —</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" class="text-brown-700">
                                {{ $client->nom }} {{ $client->prenom }}
                            </option>
                        @endforeach
                        <option value="new" class="font-semibold text-brown-600">➕ Nouveau client</option>
                    </select>
                </div>

                {{-- Nouveau client compact --}}
                @if($isNewClient)
                    <div class="bg-brown-50 border border-brown-200 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-brown-800 mb-3">Nouveau client</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" wire:model.live="client_nom" 
                                   placeholder="Nom *" 
                                   class="text-sm border border-brown-300 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3">
                            <input type="text" wire:model.live="client_prenom" 
                                   placeholder="Prénom *" 
                                   class="text-sm border border-brown-300 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3">
                            <input type="email" wire:model.live="client_email" 
                                   placeholder="Email *" 
                                   class="text-sm border border-brown-300 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3">
                            <input type="text" wire:model.live="client_telephone" 
                                   placeholder="Téléphone" 
                                   class="text-sm border border-brown-300 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2 px-3">
                        </div>
                    </div>
                @endif

                {{-- Dates en une ligne --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-brown-800 mb-2">Arrivée</label>
                        <input type="date" wire:model.live="check_in" 
                               class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2.5 px-3 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-brown-800 mb-2">Départ</label>
                        <input type="date" wire:model.live="check_out" 
                               class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2.5 px-3 text-sm">
                    </div>
                </div>

                {{-- Sélecteur de chambre compact --}}
                <div>
                    <label class="block text-sm font-medium text-brown-800 mb-2">Ajouter une chambre</label>
                    <select wire:model.live="selectedRoomToAdd" 
                            wire:change="addRoomToReservation" 
                            class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2.5 px-3 text-sm">
                        <option value="">— Choisir une chambre —</option>
                        @foreach($rooms as $room)
                            @if(!in_array($room->id, $room_ids))
                                @php $prix = $room->prix_personnalise ?? ($room->roomType->prix_base ?? 0); @endphp
                                <option value="{{ $room->id }}" class="text-brown-700">
                                    Chambre {{ $room->numero }} — {{ number_format($prix,0,',',' ') }} FCFA
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {{-- Liste des chambres compacte --}}
                @if(!empty($reservationItems))
                    <div class="space-y-3">
                        <div class="flex items-center justify-between border-b border-brown-200 pb-2">
                            <h4 class="text-sm font-semibold text-brown-900">Chambres sélectionnées</h4>
                            <span class="text-xs font-medium text-brown-600 bg-brown-100 px-2 py-1 rounded">
                                {{ count($reservationItems) }} chambre(s)
                            </span>
                        </div>

                        @foreach($reservationItems as $index => $item)
                            @php
                                $room = $rooms->firstWhere('id', $item['room_id']);
                            @endphp
                            <div class="border border-brown-200 p-4 rounded-lg relative bg-white">
                                <button type="button" 
                                        wire:click="removeRoom({{ $item['room_id'] }})" 
                                        class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                    ✕
                                </button>

                                {{-- Tout sur une ligne --}}
                                <div class="flex items-center justify-between gap-4">
                                    {{-- Info chambre --}}
                                    <div class="flex-1">
                                        <h4 class="font-medium text-brown-800 text-sm">Chambre {{ $room->numero ?? '??' }}</h4>
                                        <p class="text-brown-600 text-xs">{{ $room->roomType->nom ?? 'Type inconnu' }}</p>
                                    </div>

                                    {{-- Nombre de personnes compact --}}
                                    <div class="w-24">
                                        <label class="block text-xs text-brown-600 mb-1">Personnes</label>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" 
                                                    wire:click="decrementPersons({{ $item['room_id'] }})"
                                                    class="w-6 h-6 bg-brown-100 text-brown-700 rounded hover:bg-brown-200 transition-colors flex items-center justify-center text-xs">
                                                -
                                            </button>
                                            <input type="number" min="1"
                                                   wire:model.live="reservationItems.{{ $index }}.nb_personnes"
                                                   class="flex-1 border border-brown-200 rounded text-center py-1 px-2 text-sm w-12">
                                            <button type="button" 
                                                    wire:click="incrementPersons({{ $item['room_id'] }})"
                                                    class="w-6 h-6 bg-brown-100 text-brown-700 rounded hover:bg-brown-200 transition-colors flex items-center justify-center text-xs">
                                                +
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Lit d'appoint compact --}}
                                    <div class="flex items-center space-x-2">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   wire:model.live="reservationItems.{{ $index }}.lit_dappoint" 
                                                   class="sr-only peer">
                                            <div class="w-8 h-4 bg-brown-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-brown-600"></div>
                                        </label>
                                        <span class="text-xs text-brown-600">Lit app.</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Résumé compact --}}
                <div class="bg-brown-50 p-4 rounded-lg border border-brown-200">
                    <h3 class="text-sm font-semibold text-brown-800 mb-3">Résumé</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-brown-600">Sous-total:</span>
                            <span class="font-medium text-brown-800">{{ number_format($total,0,',',' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-brown-600">Montant dû:</span>
                            <span class="font-medium text-brown-800">{{ number_format($amount_due,0,',',' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-brown-600">Statut:</span>
                            <span class="font-medium px-2 py-1 rounded text-xs 
                                {{ $statut === 'confirmé' ? 'bg-green-100 text-green-800' : 
                                   ($statut === 'en attente' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($statut) }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer compact --}}
        <div class="bg-brown-50 px-6 py-4 border-t border-brown-200 shrink-0">
            <div class="flex flex-col sm:flex-row gap-3 justify-end">
                <button wire:click="closeModal" 
                        class="order-2 sm:order-1 w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 border border-brown-300 text-brown-700 font-medium rounded-lg hover:bg-brown-100 transition-colors text-sm">
                    Annuler
                </button>
                <button wire:click="save" 
                        wire:loading.attr="disabled"
                        class="order-1 sm:order-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-brown-600 text-white font-medium rounded-lg hover:bg-brown-700 transition-colors text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Confirmer</span>
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