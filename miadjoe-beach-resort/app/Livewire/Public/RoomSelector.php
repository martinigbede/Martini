<?php

namespace App\Livewire\Public;

use App\Models\Room;
use App\Models\Reservation;
use Livewire\Component;
use Carbon\Carbon;

class RoomSelector extends Component
{
    // Propriétés reçues via l'URL
    public $check_in, $check_out, $type_id, $room_ids = null, $extra_bed = false;

    // Sélection
    public $selectedRoomId = null;
    public $hasExtraBed = false;

    // Résultats
    public $availableRooms = [];
    public $calculatedTotal = 0;
    public $nights = 0;

    public function mount()
    {
        // Récupération paramètres GET
        $this->check_in = request()->query('check_in');
        $this->check_out = request()->query('check_out');
        $this->type_id = request()->query('type_id') ?? null;
        $this->room_ids = request()->query('room_ids') ? explode(',', request()->query('room_ids')) : null;
        $this->hasExtraBed = (bool) request()->query('extra_bed', 0);

        // Validation initiale
        $this->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ], [], ['check_in' => 'Date d\'arrivée', 'check_out' => 'Date de départ']);

        // Calcul des nuits
        $this->nights = Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out));

        // Charger les chambres disponibles
        $this->loadAvailableRooms();

        // Calcul du prix initial
        $this->calculatePrice();
    }

    protected function loadAvailableRooms()
    {
        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);

        $query = Room::with('roomType');

        // Si la recherche est limitée à certains IDs de chambres
        if ($this->room_ids) {
            $query->whereIn('id', $this->room_ids);
        }

        // Filtrer par type de chambre si fourni
        if ($this->type_id) {
            $query->where('room_type_id', $this->type_id);
        }

        // Exclure les chambres déjà réservées
        $query->whereNotIn('id', function ($q) use ($checkIn, $checkOut) {
            $q->select('room_id')
              ->from('reservations')
              ->where('statut', '!=', 'Annulée')
              ->where('check_in', '<', $checkOut)
              ->where('check_out', '>', $checkIn);
        });

        // Tri par numéro
        $this->availableRooms = $query->orderBy('numero', 'asc')->get();
    }

    public function updatedSelectedRoomId()
    {
        $this->calculatePrice();
    }

    public function updatedHasExtraBed()
    {
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        if (!$this->selectedRoomId) {
            $this->calculatedTotal = 0;
            return;
        }

        $room = Room::with('roomType')->find($this->selectedRoomId);
        if (!$room) {
            $this->calculatedTotal = 0;
            return;
        }

        $basePrice = $room->roomType?->base_price ?? 0;
        $extraBedCost = $this->hasExtraBed ? 20.00 : 0.00; // 20€/nuit pour lit supplémentaire
        $this->calculatedTotal = ($basePrice + $extraBedCost) * $this->nights;
    }

    public function proceedToPayment()
    {
        $this->validate([
            'selectedRoomId' => 'required|integer|exists:rooms,id',
        ]);

        // Ici tu peux créer la réservation ou rediriger vers le paiement
        session()->flash('message', 'Étape de paiement à venir !');
    }

    public function render()
    {
        return view('livewire.public.room-selector')->layout('layouts.public');
    }
}
