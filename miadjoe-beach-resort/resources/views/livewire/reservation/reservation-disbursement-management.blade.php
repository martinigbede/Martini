<div class="space-y-4">

    <h2 class="text-xl font-bold mb-4">Gestion des décaissements</h2>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left">Réservation</th>
                <th class="px-4 py-2 text-left">Client</th>
                <th class="px-4 py-2 text-right">Total Ventes</th>
                <th class="px-4 py-2 text-right">Décaissements</th>
                <th class="px-4 py-2 text-right">Reste à décaisser</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($reservations as $reservation)
                @php
                    $totalVentes = $reservation->sales->sum('total');
                    $totalDecaissements = $reservation->disbursements->sum('montant');
                    $reste = max(0, $totalVentes - $totalDecaissements);
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 font-semibold">#{{ $reservation->id }}</td>
                    <td class="px-4 py-2">{{ $reservation->client?->nom ?? '—' }}</td>
                    <td class="px-4 py-2 text-right font-bold text-gray-800">{{ number_format($totalVentes,0,',',' ') }} FCFA</td>
                    <td class="px-4 py-2 text-right text-red-500">{{ number_format($totalDecaissements,0,',',' ') }} FCFA</td>
                    <td class="px-4 py-2 text-right font-medium text-amber-600">{{ number_format($reste,0,',',' ') }} FCFA</td>
                    <td class="px-4 py-2 text-center">
                        @if($reste > 0)
                            <button wire:click="decaisser({{ $reservation->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Décaisser
                            </button>
                        @else
                            <span class="text-gray-400">Décaissement fait</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        Aucune réservation avec ventes.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
