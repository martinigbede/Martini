<div class="bg-white rounded-2xl shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold text-brown-800 mb-4 flex items-center">
        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
        Réservations du jour
    </h3>

    @if($reservationsToday->isEmpty())
        <p class="text-gray-500 text-sm">Aucune réservation enregistrée aujourd’hui.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead>
                    <tr class="bg-blue-50 text-blue-800">
                        <th class="px-4 py-2">Client</th>
                        <th class="px-4 py-2">Chambre</th>
                        <th class="px-4 py-2">Montant</th>
                        <th class="px-4 py-2">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservationsToday as $reservation)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="px-4 py-2">{{ $reservation->client->nom ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $reservation->room->nom ?? 'N/A' }}</td>
                            <td class="px-4 py-2 font-semibold">{{ number_format($reservation->total, 0, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $reservation->status === 'confirmée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
