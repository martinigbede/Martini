{{-- resources/views/livewire/calendar/reservation-calendar.blade.php --}}
<div class="p-4 bg-white shadow rounded-lg" wire:poll.10s>

    {{-- Notifications --}}
    @if (session()->has('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('info') }}</span>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="mb-6 border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center uppercase tracking-wide">
            Tableau de Suivi des Réservations
        </h1>

        <div class="flex justify-between items-center mb-4">
            <button wire:click="goToPreviousMonth" type="button"
                class="p-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-gray-800 text-sm font-medium transition">
                &lt; Mois Précédent
            </button>

            <h3 class="text-xl font-bold text-gray-800">{{ $monthName }} {{ $currentYear }}</h3>

            <button wire:click="goToNextMonth" type="button"
                class="p-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-gray-800 text-sm font-medium transition">
                Mois Suivant &gt;
            </button>
        </div>

        {{-- FILTRE PAR TYPE --}}
        <div class="flex justify-center items-center space-x-4">
            <label for="room_type_filter" class="text-sm font-medium text-gray-700 shrink-0">
                Filtrer par Type :
            </label>
            <select wire:model="selectedRoomTypeId" wire:change="loadData" id="room_type_filter"
                class="p-2 border rounded-lg shadow-sm w-full max-w-xs bg-white focus:ring-2 focus:ring-brown-400">
                <option value="">-- Tous les Types --</option>
                @foreach(\App\Models\RoomType::all() as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- GRILLE CALENDRIER --}}
    <div class="overflow-x-auto relative">
        <table class="min-w-full divide-y divide-gray-300 border border-gray-200 rounded-lg overflow-hidden shadow-sm">

            {{-- EN-TÊTE DES JOURS --}}
            <thead class="bg-gray-100 sticky top-0 z-30">
                <tr>
                    <th class="w-48 p-2 text-center text-xs font-bold text-gray-700 uppercase sticky left-0 bg-gray-100 z-40 border-r border-b shadow-inner">
                        Chambres / Statut
                    </th>
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $currentDate = \Carbon\Carbon::create($this->currentYear, $this->currentMonth, $day);
                        @endphp
                        <th class="p-2 text-center text-xs font-bold text-gray-700 uppercase border-r border-b bg-gray-100 min-w-[100px]">
                            <div class="text-[10px] font-semibold">{{ $currentDate->format('d/m') }}</div>
                            <div class="text-xs text-gray-600 font-medium">{{ strtoupper($currentDate->dayName) }}</div>
                        </th>
                    @endfor
                </tr>
            </thead>

            {{-- CORPS --}}
            <tbody class="bg-white divide-y divide-gray-200">

                @php
                    $typeHeaders = collect($roomsData)->filter(fn($d) => isset($d['is_type_header']) && $d['is_type_header']);
                    $roomRows = collect($roomsData)->filter(fn($d) => isset($d['is_type_header']) && !$d['is_type_header']);
                @endphp

                {{-- POUR CHAQUE TYPE DE CHAMBRE --}}
                @foreach ($typeHeaders as $type)
                    {{-- Ligne Type de Chambre --}}
                    <tr class="bg-gradient-to-r from-[#8B5E3C] to-[#5E3B24] text-white sticky left-0 z-30">
                        <td colspan="{{ $daysInMonth + 1 }}"
                            class="p-3 text-sm font-bold uppercase sticky left-0 z-30 bg-gradient-to-r from-[#8B5E3C] to-[#5E3B24] shadow-md">
                            {{ $type['type_name'] }}
                        </td>
                    </tr>

                    {{-- Chambres associées --}}
                    @foreach ($roomRows->where('type_name', $type['type_name']) as $roomData)
                        <tr class="hover:bg-gray-50 transition duration-100">
                            {{-- Chambre fixée à gauche --}}
                            <td class="p-2 whitespace-nowrap text-sm font-semibold text-gray-900 sticky left-0 bg-white border-r border-gray-200 z-20 shadow-sm">
                                {{ $roomData['room_number'] }}
                                <div class="text-xs text-gray-500 truncate">({{ $roomData['type_name'] }})</div>
                            </td>

                            {{-- Jours défilants --}}
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $currentDate = \Carbon\Carbon::create($this->currentYear, $this->currentMonth, $day);
                                    $dateString = $currentDate->toDateString();
                                    $dayStatus = $roomData['days'][$dateString] ?? null;

                                    $cellClasses = "p-0 text-center border-r border-b border-gray-200 h-16 align-top relative";
                                    $content = '<div class="text-xs text-gray-400 flex items-center justify-center h-full">Libre</div>';
                                    $action = null;

                                    $roomStatus = $roomData['status'];
                                    $isFree = $roomStatus === 'Libre';

                                    if ($roomStatus === 'Maintenance' || $roomStatus === 'Nettoyage') {
                                        $cellClasses .= ' bg-red-100/50';
                                        $content = '<div class="text-xs font-semibold text-red-800 flex items-center justify-center h-full">'.$roomStatus[0].'</div>';
                                    }

                                    

                                    if ($dayStatus && $dayStatus['is_reservation']) {
                                        $res = $dayStatus['reservation_details'];
                                        $isCheckIn = $dayStatus['is_checkin'];
                                        $isCheckOut = $dayStatus['is_checkout'];

                                        $cellClasses .= ' shadow-inner border-t-2 border-l-2 border-r-2 border-b-2 z-10';
                                        if ($isCheckIn && $isCheckOut) {
                                            $cellClasses .= ' bg-yellow-400/80';
                                            $content = '<div class="text-[9px] font-bold leading-tight text-white">A/D</div>';
                                        } elseif ($isCheckIn) {
                                            $cellClasses .= ' bg-green-500/70';
                                            $content = '<div class="text-[9px] font-bold leading-tight text-white">ARRIVÉE</div>';
                                        } elseif ($isCheckOut) {
                                            $cellClasses .= ' bg-orange-500/70';
                                            $content = '<div class="text-[9px] font-bold leading-tight text-white">DÉPART</div>';
                                        } else {
                                            $cellClasses .= ' bg-green-300/70';
                                            $content = '<div class="text-[9px] font-bold leading-tight text-white">SÉJOUR</div>';
                                        }
                                        

                                        $action = "wire:click=\"viewReservationDetails({$dayStatus['reservation_details']->id})\"";
                                    } elseif ($isFree) {
                                        $action = "wire:click=\"openQuickBookingModal('{$dateString}')\""; 
                                        //$content = '<div class="text-xs text-gray-400">Libre</div>';
                                    }
                                    
                                @endphp

                                <td class="{{ $cellClasses }}">
                                    {!! $content !!}
                                    @if ($action)
                                        <button {!! $action !!}
                                            class="absolute inset-0 bg-transparent hover:bg-green-50/50 transition cursor-pointer rounded"></button>
                                    @endif

                                </td>
                            @endfor
                        </tr>
                    @endforeach
                @endforeach

                {{-- Ligne Totaux --}}
                <tr class="bg-gray-100 font-bold text-xs border-t-4 border-gray-400">
                    <td class="p-2 sticky left-0 bg-gray-100 border-r border-t border-gray-300 text-gray-700 uppercase font-semibold shadow-inner">
                        Taux / Total
                    </td>
                    <td colspan="{{ $daysInMonth }}" class="p-2 border-t border-gray-300 text-gray-700">
                        Affichage des statistiques mensuelles ici...
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    
    {{-- MODAL DE DÉTAILS (toujours monté) --}}
    @livewire('reservation.reservation-detail-modal')

    {{-- MODAL DE RÉSERVATION RAPIDE (toujours monté) --}}
    @livewire('reservation.reservation-quick-create-form')

</div>
