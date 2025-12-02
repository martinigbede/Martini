{{-- resources/views/livewire/reservation/reservation-calendar.blade.php --}}
<div class="p-6">
    <div class="bg-white rounded-lg shadow-lg p-6 border border-brown-200">
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6 gap-4">
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-brown-900">TABLEAU DE SUIVI DES RÉSERVATIONS</h2>
                <p class="text-sm text-brown-600 bg-brown-50 px-3 py-1 rounded-full inline-block">
                    {{ \Carbon\Carbon::create($year, $month, 1)->locale('fr')->translatedFormat('F Y') }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <div class="flex gap-2">
                    <button wire:click="prevMonth" class="px-4 py-2 rounded-lg bg-brown-100 hover:bg-brown-200 text-brown-700 transition-colors duration-200 text-sm font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Précédent
                    </button>
                    <button wire:click="nextMonth" class="px-4 py-2 rounded-lg bg-brown-100 hover:bg-brown-200 text-brown-700 transition-colors duration-200 text-sm font-medium flex items-center gap-1">
                        Suivant
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <select wire:model="typeFilter" class="rounded-lg border-brown-200 bg-white text-brown-700 focus:border-brown-500 focus:ring-brown-500 text-sm">
                    <option value="">Tous les Types</option>
                    @foreach($roomTypes as $rt)
                        <option value="{{ $rt->id }}">{{ $rt->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Tableau Planning avec colonnes fixes --}}
        <div class="relative overflow-hidden border border-brown-200 rounded-lg">
            <div class="overflow-auto">
                <table class="min-w-full divide-y divide-brown-200">
                    <thead class="bg-brown-50">
                        <tr>
                            {{-- Colonne fixe pour les chambres --}}
                            <th class="sticky left-0 z-20 bg-brown-50 px-6 py-4 text-left w-64 border-r border-brown-200">
                                <span class="text-sm font-semibold text-brown-900">CHAMBRES</span>
                            </th>

                            {{-- Entête des jours (défilants) --}}
                            @foreach($days as $date)
                                <th class="px-3 py-3 text-center min-w-16 bg-brown-50">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-semibold text-brown-900">
                                            {{ \Carbon\Carbon::parse($date)->format('d') }}
                                        </span>
                                        <span class="text-xs font-medium text-brown-500 mt-1">
                                            {{ \Carbon\Carbon::parse($date)->locale('fr')->translatedFormat('D') }}
                                        </span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-brown-100">
                        @php
                            $grouped = $rooms->groupBy('room_type_id');
                        @endphp

                        @foreach($grouped as $typeId => $roomsOfType)
                            {{-- Ligne d'entête type --}}
                            <tr class="sticky left-0 z-10 bg-brown-100/50">
                                <td colspan="{{ count($days) + 1 }}" class="px-6 py-3 sticky left-0 z-10">
                                    <div class="sticky left-0 z-10 flex items-center gap-2">
                                        <div class="w-1 h-4 bg-brown-500 rounded-full"></div>
                                        <span class="text-sm font-semibold text-brown-800">
                                            {{ $roomTypes->firstWhere('id', $typeId)->nom ?? 'Type inconnu' }}
                                        </span>
                                        <span class="text-xs text-brown-600 bg-brown-200 px-2 py-1 rounded-full">
                                            {{ $roomsOfType->count() }} chambre(s)
                                        </span>
                                    </div>
                                </td>
                            </tr>

                            {{-- Lignes chambres --}}
                            @foreach($roomsOfType as $room)
                                <tr class="hover:bg-brown-50/50 transition-colors duration-150">
                                    {{-- Cellule fixe pour la chambre --}}
                                    <td class="sticky left-0 z-10 bg-white px-6 py-4 align-top border-r border-brown-200">
                                        <div class="space-y-1">
                                            <div class="font-semibold text-brown-900 text-sm">
                                                {{ $room->numero }}
                                            </div>
                                            <div class="text-xs text-brown-600 bg-brown-100 px-2 py-1 rounded-full inline-block">
                                                {{ $room->roomType->nom ?? '' }}
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Cellules des jours (défilantes) --}}
                                    @foreach($days as $date)
                                        @php
                                            $cell = $this->getCellInfo($room->id, $date);
                                            $status = $cell['status'];
                                            $resa = $cell['reservation'];
                                            
                                            // Classes selon le statut avec votre charte graphique
                                            $bgClasses = match($status) {
                                                'free' => 'bg-white border-brown-100 hover:bg-brown-50',
                                                'arrival' => 'bg-green-100 border-green-300 hover:bg-green-200',
                                                'departure' => 'bg-orange-100 border-orange-300 hover:bg-orange-200',
                                                'stay' => 'bg-green-50 border-green-200 hover:bg-green-100',
                                                default => 'bg-white border-brown-100'
                                            };
                                            
                                            $textClasses = match($status) {
                                                'free' => 'text-brown-400',
                                                'arrival' => 'text-green-800 font-semibold',
                                                'departure' => 'text-orange-800 font-semibold',
                                                'stay' => 'text-green-700',
                                                default => 'text-brown-600'
                                            };
                                        @endphp

                                        <td class="px-2 py-3 align-top">
                                            <div
                                                wire:click="{{ $resa ? "openEditReservation({$resa->id})" : "openCreateAt('{$date}', {$room->id})" }}"
                                                class="cursor-pointer rounded-lg border-2 p-2 h-16 flex flex-col items-center justify-center transition-all duration-200 hover:shadow-md {{ $bgClasses }} {{ $textClasses }} group"
                                                title="{{ $resa ? ($resa->client->nom ?? 'Réservation') . ' — ' . \Carbon\Carbon::parse($resa->check_in)->format('d/m') . ' → ' . \Carbon\Carbon::parse($resa->check_out)->format('d/m') : 'Libre' }}"
                                            >
                                                @if($resa)
                                                    <div class="text-center space-y-1">
                                                        <span class="text-xs font-semibold leading-none block">
                                                            @if($status === 'arrival') 
                                                                <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                                                                ARRIVÉE
                                                            @elseif($status === 'departure')
                                                                <div class="w-2 h-2 bg-orange-500 rounded-full mx-auto mb-1"></div>
                                                                DÉPART
                                                            @elseif($status === 'stay')
                                                                <div class="w-2 h-2 bg-green-400 rounded-full mx-auto mb-1"></div>
                                                                SÉJOUR
                                                            @else
                                                                <div class="w-2 h-2 bg-brown-400 rounded-full mx-auto mb-1"></div>
                                                                RÉSERVÉ
                                                            @endif
                                                        </span>
                                                        @if($resa->client)
                                                            <span class="text-[10px] leading-none block truncate max-w-12">
                                                                {{ $resa->client->nom }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="text-center">
                                                        <div class="w-2 h-2 bg-brown-200 rounded-full mx-auto mb-1"></div>
                                                        <span class="text-xs">Libre</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer: Résumé --}}
        <div class="mt-6 p-4 bg-brown-50 rounded-lg border border-brown-200">
            <div class="flex flex-wrap items-center gap-4 text-sm text-brown-700">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-white border-2 border-brown-200 rounded"></div>
                    <span>Libre</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-100 border-2 border-green-300 rounded"></div>
                    <span>Arrivée</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-50 border-2 border-green-200 rounded"></div>
                    <span>Séjour</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-orange-100 border-2 border-orange-300 rounded"></div>
                    <span>Départ</span>
                </div>
                
                <div class="ml-auto flex items-center gap-4">
                    <span class="font-semibold text-brown-900">{{ $rooms->count() }}</span> chambres
                    <span class="font-semibold text-brown-900">{{ $daysInMonth }}</span> jours
                </div>
            </div>
        </div>
    </div>
        {{-- Modal de création / édition --}}
    <livewire:reservation.reservation-form-calendar />
</div>