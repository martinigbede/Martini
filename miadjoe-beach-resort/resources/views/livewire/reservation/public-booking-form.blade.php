    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-brown-100">

        {{-- En-tête --}}
        <div class="bg-gradient-to-r from-brown-600 via-brown-700 to-brown-800 px-8 py-6 text-white">
            <h2 class="text-2xl font-bold flex items-center">🏖️ Réserver votre séjour</h2>
            <p class="text-brown-200 mt-1 text-sm">Choisissez vos chambres et confirmez votre réservation</p>
        </div>

        {{-- Formulaire principal --}}
        <div class="p-8 space-y-8">

            {{-- Messages d’erreur / succès --}}
            @if (session()->has('message'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                    ✅ {{ session('message') }}
                </div>
            @endif
            @error('general')
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                    ⚠️ {{ $message }}
                </div>
            @enderror

            {{-- Informations client --}}
            <div class="space-y-4">
                <h3 class="font-bold text-brown-800 text-lg flex items-center">
                    <svg class="w-5 h-5 mr-2 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informations du client
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input type="text" wire:model.lazy="client_nom" placeholder="Nom *"
                        class="border-2 border-brown-200 rounded-xl py-3 px-4 focus:border-brown-500 focus:ring-brown-500/20"
                        required>
                    <input type="text" wire:model.lazy="client_prenom" placeholder="Prénom *"
                        class="border-2 border-brown-200 rounded-xl py-3 px-4 focus:border-brown-500 focus:ring-brown-500/20"
                        required>
                    <input type="email" wire:model.lazy="client_email" placeholder="Email *"
                        class="border-2 border-brown-200 rounded-xl py-3 px-4 focus:border-brown-500 focus:ring-brown-500/20"
                        required>
                    <input type="text" wire:model.lazy="client_telephone" placeholder="Téléphone (+228...) *"
                        class="border-2 border-brown-200 rounded-xl py-3 px-4 focus:border-brown-500 focus:ring-brown-500/20"
                        required>
                </div>

                {{-- Messages d’erreur live --}}
                @error('client_nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('client_prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('client_telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-brown-700">Arrivée *</label>
                    <input type="date" wire:model.lazy="check_in" required
                        class="mt-1 w-full border-2 border-brown-200 rounded-xl py-3 px-4 focus:border-brown-500 focus:ring-brown-500/20">
                </div>
                <div>
                    <label class="text-sm font-semibold text-brown-700">Départ *</label>
                    <input type="date" wire:model.lazy="check_out" required
                        class="mt-1 w-full border-2 border-brown-200 rounded-xl py-3 px-4 focus:border-brown-500 focus:ring-brown-500/20">
                </div>
            </div>

            {{-- Sélection de chambre --}}
            <div>
                <h3 class="font-bold text-brown-800 text-lg mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4h2v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Choisissez vos chambres *
                </h3>

                <select wire:model.lazy="selectedRoomToAdd" wire:change="addRoomToReservation"
                        class="w-full border-2 border-brown-200 rounded-xl py-3 px-4 bg-white focus:border-brown-500 focus:ring-brown-500/20"
                        required>
                    <option value="">— Sélectionner une chambre —</option>
                    @foreach($rooms as $room)
                        @if(!in_array($room->id, $room_ids))
                            @php $prix = $room->prix_personnalise ?? ($room->roomType->prix_base ?? 0); @endphp
                            <option value="{{ $room->id }}">
                                Chambre {{ $room->numero }} — {{ $room->roomType->nom ?? 'Type inconnu' }} 
                                ({{ number_format($prix, 0, ',', ' ') }} FCFA / nuit)
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Liste des chambres sélectionnées --}}
            @if(!empty($reservationItems))
                <div class="space-y-5">
                    @foreach($reservationItems as $index => $item)
                        @php
                            $room = $rooms->firstWhere('id', $item['room_id']);
                            $prix = $room->prix_personnalise ?? ($room->roomType->prix_base ?? 0);
                        @endphp
                        <div class="border-2 border-brown-100 rounded-2xl p-5 bg-white shadow-sm hover:shadow-md transition-all">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-bold text-brown-800">
                                    Chambre {{ $room->numero ?? '??' }} — {{ $room->roomType->nom ?? '' }}
                                </h4>
                                <button wire:click="removeRoom({{ $item['room_id'] }})"
                                        class="text-red-500 hover:text-red-700 text-sm">✕ Retirer</button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                <div>
                                    <label class="block text-sm font-medium text-brown-700 mb-1">Personnes</label>
                                    <input type="number" min="1"
                                           wire:model.lazy="reservationItems.{{ $index }}.nb_personnes"
                                           class="w-full border-2 border-brown-200 rounded-xl py-2 px-3 focus:border-brown-500 focus:ring-brown-500/20 text-center">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <label class="text-sm font-medium text-brown-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                        Lit d'appoint (+2 pers.)
                                    </label>
                                    <input type="checkbox"
                                           wire:model.lazy="reservationItems.{{ $index }}.lit_dappoint"
                                           class="w-5 h-5 text-brown-600 border-brown-300 rounded focus:ring-brown-500">
                                </div>
                                <div class="text-right">
                                    <p class="text-brown-600 text-sm">Prix/nuit</p>
                                    <p class="font-semibold text-brown-800">
                                        {{ number_format($prix, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Paiement immédiat obligatoire --}}
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-100 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-blue-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a5 5 0 00-10 0v2M5 13h14v9H5z"/>
                    </svg>
                    Paiement en ligne (Via CashPay) * <p class="text-sm font-normal ml-2">(Obligatoire)  <a href="{{ route('public.condition') }}" class="text-red-400 hover:text-blue-300 transition-colors duration-300">En savoir plus</a> </p>
                </h3>

                <div class="mt-4">
                    <input type="number" step="1000" wire:model.lazy="payment_now_amount"
                        placeholder="Montant à payer maintenant (FCFA)"
                        class="w-full border-2 border-blue-200 rounded-xl py-3 px-4 focus:border-blue-500 focus:ring-blue-500/20"
                        required>
                    @error('payment_now_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Résumé total --}}
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 text-green-800">
                <div class="flex justify-between items-center text-lg font-semibold">
                    <span>Total estimé :</span>
                    <span>{{ number_format($this->total ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>

            {{-- Bouton de validation --}}
            <div class="flex justify-end">
                <button wire:click="submit" wire:loading.attr="disabled"
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl font-semibold hover:scale-105 transition transform shadow-lg hover:shadow-xl disabled:opacity-50">
                    <span wire:loading.remove>Confirmer la réservation</span>
                    <span wire:loading>
                        <svg class="animate-spin inline-block w-5 h-5 mr-2 text-white" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                        </svg>
                        Traitement...
                    </span>
                </button>
            </div>
        </div>
    </div>

<script>
    window.addEventListener('semoaRedirect', event => {
        window.location.href = event.detail.url;
    });
</script>
