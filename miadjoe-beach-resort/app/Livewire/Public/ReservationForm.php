<?php

namespace App\Livewire\Public;

use App\Models\RoomType;
use App\Models\Reservation;
use Livewire\Component;
use Carbon\Carbon;

class ReservationForm extends Component
{
    public $check_in, $check_out;
    public $selectedRoomTypeId = null;
    public $availableRoomsCount = 0;
    public $isSearching = false;
    public $searchPerformed = false;

    protected $rules = [
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'selectedRoomTypeId' => 'nullable|integer|exists:room_types,id',
    ];

    public function searchAvailability()
    {
        $this->validate();
        $this->isSearching = true;
        $this->searchPerformed = true;
        
        $this->availableRoomsCount = $this->calculateAvailableRooms();
        
        $this->isSearching = false;
    }
    
    protected function calculateAvailableRooms(): int
    {
        if (!$this->check_in || !$this->check_out) return 0;

        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);
        
        // 1. Identifier les RoomTypes qui sont déjà pleins pour ces dates
        $occupiedRoomTypes = Reservation::where('status', '!=', 'Annulée')
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->select('room_id')
            ->with('room.type') // CORRIGÉ : Charger la relation ROOM et ensuite son TYPE
            ->get()
            ->pluck('room.type.id') // CORRIGÉ : Pluck l'ID du TYPE via la relation room
            ->unique()
            ->toArray();
        
        // 2. Compter les RoomTypes NON occupés
        $availableTypes = RoomType::whereNotIn('id', $occupiedRoomTypes)->count();
        
        // NOTE: Une logique plus fine devrait compter les chambres disponibles dans chaque type.
        // Pour l'instant, on compte les types où au moins une chambre est libre.
        return $availableTypes; 
    }

    public function render()
    {
        $roomTypes = RoomType::all(); // Afficher tous les types même sans recherche
        return view('livewire.public.reservation-form', compact('roomTypes'))->layout('layouts.public');
    }
}