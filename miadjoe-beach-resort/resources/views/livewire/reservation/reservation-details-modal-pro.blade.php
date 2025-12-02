<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-xl w-11/12 max-w-2xl mx-4 my-8">
                {{-- En-tête de la modale --}}
                <div class="bg-brown-700 px-6 py-4 rounded-t-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-white">📋 Détails réservation</h2>
                            <p class="text-brown-200 text-xs mt-1">#{{ $reservation->id }}</p>
                        </div>
                        <button wire:click="closeModal" 
                                class="text-brown-200 hover:text-white rounded-full p-1 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 max-h-[70vh] overflow-y-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        {{-- Colonne gauche --}}
                        <div class="space-y-4">
                            {{-- Informations Client --}}
                            <div class="bg-brown-50 rounded-lg p-4 border border-brown-200">
                                <h3 class="text-sm font-semibold text-brown-800 mb-2">Client</h3>
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Nom :</span>
                                        <span class="text-brown-800">{{ $reservation->client->nom }} {{ $reservation->client->prenom }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Email :</span>
                                        <span class="text-brown-800">{{ $reservation->client->email }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Téléphone :</span>
                                        <span class="text-brown-800">{{ $reservation->client->telephone }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Dates et Personnes --}}
                            <div class="bg-brown-50 rounded-lg p-4 border border-brown-200">
                                <h3 class="text-sm font-semibold text-brown-800 mb-2">Dates et Personnes</h3>
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Check-in :</span>
                                        <span class="text-brown-800 font-medium">{{ $reservation->check_in }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Check-out :</span>
                                        <span class="text-brown-800 font-medium">{{ $reservation->check_out }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Personnes :</span>
                                        <span class="bg-brown-100 text-brown-800 px-2 py-0.5 rounded text-xs font-medium">
                                            {{ $reservation->items->sum('nb_personnes') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Ventes liées --}}
                            @if($reservation->sales->isNotEmpty())
                                <div class="bg-brown-50 rounded-lg p-4 border border-brown-200">
                                    <h3 class="text-sm font-semibold text-brown-800 mb-2">Ventes liées</h3>
                                    @foreach($reservation->sales as $sale)
                                        <div class="bg-white rounded p-2 border border-brown-100 text-xs mb-1">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <div class="font-medium text-brown-800">Vente #{{ $sale->id }}</div>
                                                    <div class="text-brown-600">Services additionnels</div>
                                                </div>
                                                <div class="font-semibold text-brown-800">
                                                    {{ number_format($sale->total, 0, ',', ' ') }} FCFA
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Historique --}}
                            <div class="bg-brown-50 rounded-lg p-4 border border-brown-200">
                                <h3 class="text-sm font-semibold text-brown-800 mb-2">Historique</h3>
                                <div class="grid grid-cols-1 gap-2 text-xs">
                                    <div class="bg-white rounded p-2 border border-brown-100">
                                        <div class="text-brown-700">Créée par</div>
                                        <div class="text-brown-800 font-medium">{{ $reservation->createdBy->name ?? '-' }}</div>
                                        <div class="text-brown-500 text-xs">
                                            {{ $reservation->created_at?->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="bg-white rounded p-2 border border-brown-100">
                                        <div class="text-brown-700">Modifiée par</div>
                                        <div class="text-brown-800 font-medium">{{ $reservation->updatedBy->name ?? '-' }}</div>
                                        <div class="text-brown-500 text-xs">
                                            {{ $reservation->updated_at?->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Colonne droite --}}
                        <div class="space-y-4">
                            {{-- Chambres --}}
                            <div class="bg-brown-50 rounded-lg p-4 border border-brown-200">
                                <h3 class="text-sm font-semibold text-brown-800 mb-2">Chambres Réservées</h3>
                                <div class="space-y-2">
                                    @foreach($reservation->items as $item)
                                        <div class="bg-white rounded p-3 border border-brown-100 text-xs">
                                            <div class="flex justify-between">
                                                <div>
                                                    <div class="font-semibold text-brown-800">Chambre {{ $item->room->numero }}</div>
                                                    <div class="text-brown-600">{{ $item->room->roomType->nom }}</div>
                                                    <div class="text-brown-500 mt-1">
                                                        {{ $item->nb_personnes }} pers.
                                                        @if($item->lit_dappoint)
                                                            — Lit app.
                                                        @endif
                                                    </div>
                                                    <div class="text-brown-500">
                                                        Prix/nuit : {{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA
                                                    </div>
                                                    <div class="text-brown-500">
                                                        Nuits : {{ \Carbon\Carbon::parse($reservation->check_in)->diffInDays(\Carbon\Carbon::parse($reservation->check_out)) }}
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="font-semibold text-brown-800">
                                                        {{ number_format($item->total, 0, ',', ' ') }} FCFA
                                                    </div>
                                                    <div class="text-brown-500 text-xs">Total</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Paiements --}}
                            <div class="bg-brown-50 rounded-lg p-4 border border-brown-200">
                                <h3 class="text-sm font-semibold text-brown-800 mb-2">Paiements</h3>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Montant facturé :</span>
                                        <span class="font-semibold text-brown-800">
                                            {{ number_format($reservation->invoice->montant_total, 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>

                                    @if($reservation->invoice->is_remise || $reservation->invoice->montant_final < $reservation->invoice->montant_total)
                                        <div class="flex justify-between">
                                            <span class="text-brown-600">Remise :</span>
                                            <span class="text-red-600 font-medium">
                                                @if($reservation->invoice->remise_amount)
                                                    {{ $reservation->invoice->remise_amount }} FCFA
                                                @else
                                                    {{ number_format($reservation->invoice->montant_total - $reservation->invoice->montant_final, 0, ',', ' ') }} FCFA
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                    @foreach($reservation->payments as $payment)
                                        @if($payment->motif_remise)
                                            <div class="flex justify-between">
                                                <span class="text-brown-600">Motif remise :</span>
                                                <span class="text-brown-800 font-medium">
                                                    {{ $payment->motif_remise }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach

                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Total à payer :</span>
                                        <span class="font-semibold text-brown-800">
                                            {{ number_format($reservation->invoice->montant_final, 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Payé :</span>
                                        <span class="text-green-600 font-medium">
                                            {{ number_format($reservation->payments->sum('montant'), 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-brown-600">Reste à payer :</span>
                                        <span class="text-red-600 font-medium">
                                            {{ number_format(max(0, $reservation->invoice->montant_final - $reservation->payments->sum('montant')), 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>

                                    <div class="flex justify-between pt-2 border-t border-brown-200">
                                        <span class="text-brown-600">Statut :</span>
                                        <span class="px-2 py-0.5 rounded text-xs font-medium 
                                            {{ $reservation->statut === 'Confirmée' ? 'bg-green-100 text-green-800' : 
                                            ($reservation->statut === 'En attente' ? 'bg-amber-100 text-amber-800' : 
                                            'bg-gray-100 text-gray-800') }}">
                                            {{ $reservation->statut }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Complet --}}
                            <div class="bg-brown-50 rounded-lg p-4 border border-brown-200">
                                <h3 class="text-sm font-semibold text-brown-800 mb-2">Total Complet</h3>
                                <div class="text-center">
                                    @php
                                        $salesTotal = $reservation->sales->sum('total'); 
                                        $grandTotal = $reservation->invoice->montant_final + $salesTotal;
                                    @endphp
                                    <div class="text-xl font-bold text-brown-800">
                                        {{ number_format($grandTotal, 0, ',', ' ') }} FCFA
                                    </div>
                                    <div class="text-xs text-brown-600 mt-1">Montant final + ventes liées</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Boutons --}}
                <div class="bg-brown-50 border-t border-brown-200 p-4 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row justify-end gap-2">
                        <button wire:click="generateInvoicePDF" 
                                class="bg-brown-600 hover:bg-brown-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors flex items-center justify-center">
                            <span>Générer facture PDF</span>
                        </button>
                        <button wire:click="closeModal" 
                                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg text-sm transition-colors flex items-center justify-center">
                            <span>Fermer</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>