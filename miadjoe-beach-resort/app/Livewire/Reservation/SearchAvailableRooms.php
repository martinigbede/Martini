<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Room;
use App\Models\Reservation;

class AvailableRooms extends Component
{
    public ?string $check_in = null;
    public ?string $check_out = null;
    public int $nb_personnes = 1;

    public $rooms = [];

    protected $rules = [
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'nb_personnes' => 'required|integer|min:1',
    ];

    public function render()
    {
        return view('livewire.reservation.available-rooms', [
            'rooms' => $this->rooms,
        ]);
    }

    public function search()
    {
        $this->validate();

        // On récupère toutes les chambres
        $rooms = Room::with('roomType')->get();

        // On filtre celles déjà réservées entre les dates
        $available = $rooms->filter(function($room) {
            $conflicts = Reservation::whereHas('rooms', function($q) use ($room) {
                $q->where('room_id', $room->id);
            })
            ->where(function($query) {
                $query->whereBetween('check_in', [$this->check_in, $this->check_out])
                      ->orWhereBetween('check_out', [$this->check_in, $this->check_out])
                      ->orWhere(function($q2) {
                          $q2->where('check_in', '<=', $this->check_in)
                             ->where('check_out', '>=', $this->check_out);
                      });
            })
            ->exists();

            return !$conflicts;
        });

        $this->rooms = $available;
    }
}
