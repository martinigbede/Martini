<x-layouts.public>

    <div class="max-w-6xl mx-auto mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            Chambres disponibles du {{ $check_in }} au {{ $check_out }}
        </h2>

        @if($rooms->isEmpty())
            <p class="text-gray-600">Aucune chambre disponible pour cette période.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($rooms as $room)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $room->numero }}</h3>
                        <p class="text-sm text-gray-500">{{ $room->roomType->nom ?? 'Type inconnu' }}</p>
                        <a href="{{ route('reservation.form', ['room_id' => $room->id, 'check_in' => $check_in, 'check_out' => $check_out]) }}"
                        class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Réserver
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.public>