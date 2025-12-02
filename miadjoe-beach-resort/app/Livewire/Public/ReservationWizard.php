<?php

namespace App\Livewire\Public;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class ReservationWizard extends Component
{
    public $search_check_in, $search_check_out, $search_room_type_id = null, $search_nb_personnes = 1;
    public $availableRooms = [];
    public $availableRoomsCount = 0;
    public $searchPerformed = false;

    protected $rules = [
        'search_check_in' => 'required|date|after_or_equal:today',
        'search_check_out' => 'required|date|after:search_check_in',
        'search_room_type_id' => 'nullable|integer|exists:room_types,id',
        'search_nb_personnes' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->search_check_in = Carbon::now()->addDays(7)->toDateString();
        $this->search_check_out = Carbon::now()->addDays(8)->toDateString();
    }

    public function searchAvailability()
    {
        $this->validate();
        $this->searchPerformed = true;

        $this->availableRooms = $this->checkRoomAvailability();
        $this->availableRoomsCount = count($this->availableRooms);
    }

    protected function checkRoomAvailability(): array
    {
        $checkIn = Carbon::parse($this->search_check_in);
        $checkOut = Carbon::parse($this->search_check_out);

        $occupiedRoomIds = Reservation::where('statut', '!=', 'Annulée')
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->where('check_in', '<', $checkOut)
                      ->where('check_out', '>', $checkIn);
            })
            ->pluck('room_id')
            ->toArray();

        $availableRoomsQuery = Room::whereNotIn('id', $occupiedRoomIds);

        if ($this->search_room_type_id) {
            $availableRoomsQuery->where('room_type_id', $this->search_room_type_id);
        }

        return $availableRoomsQuery->with('roomType')->get()->toArray();
    }

    public function render()
    {
        $roomTypes = RoomType::all();
        return view('livewire.public.reservation-wizard', compact('roomTypes'))->layout('layouts.public');
    }
}
