<div class="bg-white rounded-2xl shadow-md p-6">
    <h3 class="text-lg font-semibold text-brown-800 mb-4 flex items-center">
        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
        Ventes du jour
    </h3>

    @if($salesToday->isEmpty())
        <p class="text-gray-500 text-sm">Aucune vente enregistrée aujourd’hui.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead>
                    <tr class="bg-green-50 text-green-800">
                        <th class="px-4 py-2">Article</th>
                        <th class="px-4 py-2">Quantité</th>
                        <th class="px-4 py-2">Montant</th>
                        <th class="px-4 py-2">Serveur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesToday as $sale)
                        <tr class="border-b hover:bg-green-50">
                            <td class="px-4 py-2">{{ $sale->menu->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $sale->quantity }}</td>
                            <td class="px-4 py-2 font-semibold">{{ number_format($sale->total, 0, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-2">{{ $sale->user->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
