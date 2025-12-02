<div class="space-y-6">
    {{-- Formulaire recherche --}}
    <div class="flex space-x-4">
        <input type="date" wire:model="check_in" class="border p-2 rounded" />
        <input type="date" wire:model="check_out" class="border p-2 rounded" />
        <input type="number" wire:model="nb_personnes" min="1" class="border p-2 rounded w-20" />
        <button wire:click="search" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Rechercher</button>
    </div>

    {{-- Liste des chambres disponibles --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        @forelse($rooms as $room)
            <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                <img src="{{ $room->photo_url ?? 'https://via.placeholder.com/400x250' }}" alt="Chambre {{ $room->numero }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-bold">Chambre {{ $room->numero }}</h3>
                    <p class="text-gray-600">{{ $room->roomType->nom ?? 'Type inconnu' }}</p>
                    <p class="font-semibold mt-2">{{ number_format($room->prix_personnalise ?? $room->roomType->prix_base ?? 0,0,',',' ') }} FCFA</p>
                    <a href="{{ route('public.reservation') }}" 
                       class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Réserver
                    </a>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">Aucune chambre disponible pour ces dates.</p>
        @endforelse
    </div>
</div>
