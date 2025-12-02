<?php

namespace App\Livewire\Reception;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\ReservationItem;

class ReceptionDashboard extends Component
{
    // polling interval in seconds (used by the Blade view wire:poll)
    public $pollInterval = 30;

    // KPI values
    public $arrivalsCount = 0;
    public $departuresCount = 0;
    public $confirmedCount = 0;
    public $pendingCount = 0;
    public $occupancyRate = 0.0; // percent

    // Collections for the tables (kept simple — eager load relations in loadCollections)
    public $arrivals = [];
    public $departures = [];

    // date shown on the dashboard (allows future extension for date filter)
    public $date;

    protected $listeners = [
        'refreshDashboard' => 'loadAll',
        'refresh-data' => '$refresh'
    ];

    public function mount($date = null)
    {
        $this->date = $date ? Carbon::parse($date)->toDateString() : Carbon::today()->toDateString();
        $this->loadAll();
    }

    public function loadAll()
    {
        $this->loadMetrics();
        $this->loadCollections();
    }

    protected function loadMetrics()
    {
        $day = $this->date;

        // Arrivées du jour : réservations avec check_in = day et statut Confirmée
        $this->arrivalsCount = Reservation::whereDate('check_in', $day)
            ->where('statut', 'Confirmée')
            ->count();

        // Départs du jour : check_out = day and statut Confirmée
        $this->departuresCount = Reservation::whereDate('check_out', $day)
            ->whereIn('statut', ['Confirmée', 'En séjour'])
            ->count();

        // Confirmées totales
        $this->confirmedCount = Reservation::where('statut', 'Confirmée')->count();

        // En attente
        $this->pendingCount = Reservation::where('statut', 'En attente')->count();

        // Taux d'occupation
        $totalRooms = Room::count() ?: 1;

        // Récupérer les chambres occupées à travers les ReservationItems liés à des réservations confirmées couvrant la date du jour
        $occupiedRooms = ReservationItem::whereHas('reservation', function ($query) use ($day) {
                $query->whereIn('statut', ['Confirmée', 'En séjour'])
                    ->whereDate('check_in', '<=', $day)
                    ->whereDate('check_out', '>', $day);
            })
            ->distinct('room_id')
            ->count('room_id');

        $this->occupancyRate = round(($occupiedRooms / $totalRooms) * 100, 1);
    }

    protected function loadCollections()
    {
        $day = $this->date;

        $this->arrivals = Reservation::with(['client', 'items.room'])
            ->whereDate('check_in', $day)
            ->where('statut', 'Confirmée')
            ->orderBy('check_in')
            ->get();

        $this->departures = Reservation::with(['client', 'items.room'])
            ->whereDate('check_out', $day)
            ->whereIn('statut', ['Confirmée', 'En séjour'])
            ->orderBy('check_out')
            ->get();
    }

    /**
     * Action: check-in a reservation
     * This method will set the reservation statut to "En séjour" (you can change the label)
     */
    public function checkIn($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        if (! $reservation) {
            session()->flash('error', 'Réservation introuvable.');
            return;
        }

        // Update statut. Adjust the target status if you use a different label in your app.
        $reservation->statut = 'En séjour';
        $reservation->save();

        session()->flash('success', 'Client enregistré (check-in) avec succès.');

        // recharge les données
        $this->loadAll();
    }

    /**
     * Action: check-out a reservation
     * This will set statut to "Terminée" and optionally mark the room as disponible
     */
    public function checkOut($reservationId)
    {
        $reservation = Reservation::with('items.room')->find($reservationId);

        if (! $reservation) {
            session()->flash('error', 'Réservation introuvable.');
            return;
        }

        // Mettre la réservation en Terminée
        $reservation->statut = 'Terminée';
        $reservation->save();

        // Libérer toutes les chambres liées à cette réservation
        foreach ($reservation->items as $item) {
            if ($item->room) {
                $item->room->statut = 'Libre';
                $item->room->save();
            }
        }

        session()->flash('success', 'Client check-out effectué et chambres libérées avec succès.');

        $this->loadAll();
    }

    public function render()
    {
        return view('livewire.reception.reception-dashboard');
    }
}