<?php

namespace App\Livewire\Reservation;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class ReservationCalendar extends Component
{
    // Mois/année affichés
    public int $year;
    public int $month;

    // Données utilisées pour l'affichage
    public Collection $rooms;
    public Collection $roomTypes;
    public Collection $reservations;

    // Filtre (room_type_id) ; vide = tous
    public $typeFilter = '';

    // Calculs de structure
    public array $days = []; // tableaux des jours du mois ['YYYY-MM-DD', ...]
    public int $daysInMonth = 0;

    // Option : regrouper par type
    public bool $groupByType = true;

    #[On('reservationSaved')]
    public function reloadData()
    {
        $this->loadReservations(); // ta méthode qui recharge $this->reservations
    }

    protected $listeners = [
        'refreshCalendar' => 'loadData',
        'reservationUpdated' => 'loadData', // si tu veux émettre après modif ailleurs
    ];

    public function mount($year = null, $month = null)
    {
        $now = Carbon::now();
        $this->year = $year ?? (int)$now->format('Y');
        $this->month = $month ?? (int)$now->format('n');

        $this->roomTypes = RoomType::all();
        $this->loadReservations(); 
        $this->loadData();
    }

        public function loadReservations()
    {
        $query = Reservation::with('client', 'room.roomType')
            ->whereMonth('check_in', $this->month)
            ->whereYear('check_in', $this->year);

        if ($this->typeFilter) {
            $query->whereHas('room', fn($q) => $q->where('room_type_id', $this->typeFilter));
        }

        $this->reservations = $query->get();
    }

    /**
     * Charge rooms, réservations et calcule le tableau des jours.
     */
    public function loadData()
    {
        // Charger les chambres en respectant le filtre si présent
        $query = Room::with('roomType')->orderBy('room_type_id')->orderBy('numero');

        if ($this->typeFilter) {
            $query->where('room_type_id', $this->typeFilter);
        }

        $this->rooms = $query->get();

        // Jours du mois
        $firstOfMonth = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth();
        $this->daysInMonth = (int)$firstOfMonth->daysInMonth;
        $this->days = [];

        for ($d = 1; $d <= $this->daysInMonth; $d++) {
            $date = Carbon::createFromDate($this->year, $this->month, $d)->toDateString();
            $this->days[] = $date;
        }

        // Récupérer toutes les réservations qui touchent le mois affiché (début ou fin dans le mois)
        $monthStart = $firstOfMonth->copy()->startOfDay();
        $monthEnd = $firstOfMonth->copy()->endOfMonth()->endOfDay();

        // On récupère les résas dont la période intersecte le mois
        $this->reservations = Reservation::with('room', 'client')
            ->where(function ($q) use ($monthStart, $monthEnd) {
                $q->whereBetween('check_in', [$monthStart, $monthEnd])
                  ->orWhereBetween('check_out', [$monthStart, $monthEnd])
                  ->orWhere(function ($qq) use ($monthStart, $monthEnd) {
                      // Résas qui commencent avant le mois et finissent après le mois
                      $qq->where('check_in', '<', $monthStart)
                         ->where('check_out', '>', $monthEnd);
                  });
            })
            ->get();
    }

    /* --- Navigation mois --- */
    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->year = (int)$date->format('Y');
        $this->month = (int)$date->format('n');
        $this->loadData();
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->year = (int)$date->format('Y');
        $this->month = (int)$date->format('n');
        $this->loadData();
    }

    public function updatedTypeFilter()
    {
        // Recharger les chambres et réservations lorsque le filtre change
        $this->loadData();
    }

    /**
     * Retourne un tableau d'informations pour la case (room, date).
     * - status: 'free'|'arrival'|'stay'|'departure'|'pending' ...
     * - reservation: instance Reservation|null (la première correspondante)
     */
    public function getCellInfo($roomId, $date)
    {
        $day = Carbon::parse($date)->startOfDay();

        // On cherche une réservation qui contient un item pour cette chambre
        $reservation = $this->reservations->first(function ($res) use ($roomId, $day) {
            return collect($res->items)->contains(function ($item) use ($roomId, $day, $res) {
                if ($item->room_id != $roomId) {
                    return false;
                }

                $checkIn = Carbon::parse($res->check_in)->startOfDay();
                $checkOut = Carbon::parse($res->check_out)->startOfDay();

                // On considère la période [check_in, check_out] incluse
                return $day->betweenIncluded($checkIn, $checkOut);
            });
        });

        if (!$reservation) {
            return ['status' => 'free', 'reservation' => null];
        }

        $checkIn = Carbon::parse($reservation->check_in)->startOfDay();
        $checkOut = Carbon::parse($reservation->check_out)->startOfDay();

        if ($day->equalTo($checkIn)) {
            return ['status' => 'arrival', 'reservation' => $reservation];
        }

        if ($day->equalTo($checkOut)) {
            return ['status' => 'departure', 'reservation' => $reservation];
        }

        if ($day->greaterThan($checkIn) && $day->lessThan($checkOut)) {
            return ['status' => 'stay', 'reservation' => $reservation];
        }

        return ['status' => 'free', 'reservation' => null];
    }

    /**
     * Ouvre le formulaire en mode création rapide : émet l'événement écouté par ReservationForm
     * date en 'YYYY-MM-DD', roomId optionnel.
     */
    public function openCreateAt($date, $roomId = null)
    {
        $this->dispatch('setCheckInDate', date: $date, roomId: $roomId)
        ->to(\App\Livewire\Reservation\ReservationFormCalendar::class);

        $this->dispatch('openReservationFormCalendar', date: $date, roomId: $roomId);
    }

    /**
     * Ouvre l'édition / détail d'une réservation (en émettant l'ID)
     */
    public function openEditReservation($reservationId)
    {
        // Ici on émet pour que ReservationForm (ou ReservationManagement) sache ouvrir le formulaire en édition
        $this->dispatch('openReservationForm', $reservationId);
    }

    public function render()
    {
        return view('livewire.reservation.reservation-calendar', [
            'rooms' => $this->rooms,
            'days' => $this->days,
            'roomTypes' => $this->roomTypes,
        ]);
    }
}
