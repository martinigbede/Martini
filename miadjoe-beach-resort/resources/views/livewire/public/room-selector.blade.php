<div class="w-full max-w-4xl mx-auto p-4">

    <h1 class="text-3xl font-semibold text-gray-900 mb-6">Sélectionnez votre chambre</h1>

    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    {{-- Liste des chambres disponibles --}}
    @if($availableRooms->count() > 0)
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <label for="selectedRoomId" class="block text-sm font-medium text-gray-700 mb-2">Chambres disponibles :</label>
            <select id="selectedRoomId" wire:model="selectedRoomId"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                <option value="">-- Choisir une chambre --</option>
                @foreach ($availableRooms as $room)
                    <option value="{{ $room->id }}">
                        {{ $room->numero }} - {{ $room->roomType?->name ?? 'N/A' }}
                        ({{ number_format($room->roomType?->base_price ?? 0, 0, ',', ' ') }} €/nuit)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Lit supplémentaire --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6 flex items-center gap-4">
            <input type="checkbox" id="hasExtraBed" wire:model="hasExtraBed" class="h-5 w-5 text-green-600">
            <label for="hasExtraBed" class="text-gray-700 font-medium">Ajouter un lit supplémentaire (20€/nuit)</label>
        </div>

        {{-- Prix total --}}
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-6 rounded-lg mb-6">
            <h3 class="text-lg font-semibold mb-2">Prix total pour {{ $nights }} nuit(s) :</h3>
            <p class="text-xl font-bold">{{ number_format($calculatedTotal, 2, ',', ' ') }} €</p>
        </div>

        {{-- Bouton payer --}}
        <button wire:click="proceedToPayment"
                class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
            Finaliser la réservation
        </button>

    @else
        <div class="p-6 bg-red-50 text-red-800 rounded-lg">
            Aucune chambre disponible pour ces dates.
        </div>
    @endif
</div>
