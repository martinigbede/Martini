<x-layouts.public>
    <div class="container mx-auto px-4 py-8">

        <!-- Titre de la chambre -->
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Chambre {{ $room->numero }} – {{ $room->roomType->nom }}
        </h1>

        <!-- Grille des images -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            @forelse($room->images as $image)
                <img 
                    src="{{ asset('storage/' . $image->image_path) }}" 
                    alt="Photo Chambre {{ $room->numero }}" 
                    class="w-full h-64 object-cover rounded shadow-md"
                >
            @empty
                <div class="col-span-1 md:col-span-3 text-center py-16 border rounded text-gray-500">
                    Aucune image disponible.
                </div>
            @endforelse
        </div>

        <!-- Informations de la chambre -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Informations</h2>
            <ul class="space-y-2 text-gray-600">
                <li><strong>Statut :</strong> {{ $room->statut }}</li>
                <li><strong>Type :</strong> {{ $room->roomType->nom }}</li>
                <li><strong>Prix :</strong> {{ number_format($room->roomType->prix_base, 0, ',', ' ') }} FCFA / nuit</li>
            </ul>
        </div>

        <!-- Bouton de réservation 
        <div class="text-center">
            <a 
                href="{{ route('reservation.public-booking-form', ['room_id' => $room->id]) }}" 
                class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition"
            >
                Réserver cette chambre
            </a>
        </div> -->

    </div>
</x-layouts.public>
