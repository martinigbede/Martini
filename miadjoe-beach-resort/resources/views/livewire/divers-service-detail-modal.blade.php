<div>
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg p-6 rounded-2xl shadow-xl">

                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Détails du Service – #{{ $venteId }}
                </h2>

                {{-- Résumé de la vente --}}
                <p><strong>Date :</strong> {{ $vente->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Créé par :</strong> {{ $vente->user->name }} ({{ $vente->user->roles->first()->name ?? 'N/A' }})</p>

                <hr class="my-4">

                {{-- Tableau des items --}}
                <h3 class="text-lg font-semibold mb-2">Services</h3>

                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Service</th>
                            <th class="p-2 border">Qté</th>
                            <th class="p-2 border">Prix</th>
                            <th class="p-2 border">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vente->items as $item)
                            <tr>
                                <td class="p-2 border">{{ $item->service->nom }}</td>
                                <td class="p-2 border">{{ $item->quantite }}</td>
                                <td class="p-2 border">{{ number_format($item->prix, 0, ',', ' ') }}</td>
                                <td class="p-2 border">{{ number_format($item->total, 0, ',', ' ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right font-bold mt-3">
                    Total : {{ number_format($vente->total, 0, ',', ' ') }} F CFA
                </div>

                <hr class="my-4">

                {{-- Paiements --}}
                <h3 class="text-lg font-semibold mb-2">Paiements</h3>

                @foreach($vente->payments as $payment)
                    <p class="text-sm">
                        • {{ number_format($payment->montant, 0, ',', ' ') }} F ({{ $payment->mode_paiement }})
                        – <span class="text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                @endforeach

                <hr class="my-4">

                {{-- Boutons --}}
                <div class="flex justify-between mt-4">

                    @if($invoice)
                        <a href="{{ route('invoice.download', $invoice->id) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Télécharger la facture
                        </a>
                    @endif

                    <button
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg"
                        wire:click="fermer">
                        Fermer
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
