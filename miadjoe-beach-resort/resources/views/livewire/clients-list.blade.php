<div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Liste des clients</h2>

    <button wire:click="exportPdf" class="px-4 py-2 bg-blue-600 text-white rounded">
        Exporter en PDF
    </button>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nom</th>
                <th class="border p-2">Prénom</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Téléphone</th>
                <th class="border p-2">Nombre de réservations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td class="border p-2">{{ $client->nom }}</td>
                    <td class="border p-2">{{ $client->prenom }}</td>
                    <td class="border p-2">{{ $client->email }}</td>
                    <td class="border p-2">{{ $client->telephone }}</td>
                    <td class="border p-2">{{ $client->reservations_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
