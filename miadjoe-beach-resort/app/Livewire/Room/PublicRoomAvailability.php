<?php

namespace App\Livewire\Room;

use App\Models\Room;
use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;

class PublicRoomAvailability extends Component
{
    use WithPagination;

    public string $search = '';
    public string $typeFilter = '';
    public int $perPage = 10;

    public ?string $check_in_public = null;
    public ?string $check_out_public = null;

    protected function rules(): array
    {
        return [
            'check_in_public'  => ['required', 'date', 'after_or_equal:today'],
            'check_out_public' => ['required', 'date', 'after:check_in_public'],
        ];
    }

    public function updated($field)
    {
        if (in_array($field, ['search', 'typeFilter', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Room::query()
            ->where('statut', 'Libre')
            ->with(['roomType', 'images']); // Récupération des images

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                  ->orWhereHas('roomType', fn($t) => $t->where('nom', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->typeFilter !== '') {
            $query->where('room_type_id', $this->typeFilter);
        }

        return view('livewire.room.public-room-availability', [
            'availableRooms' => $query->latest()->paginate($this->perPage),
            'roomTypes' => RoomType::all(),
        ])->layout('layouts.guest');
    }

    public function submitSearchDates()
    {
        $this->validate();

        $this->dispatch(
            'datesSelected', 
            checkIn: $this->check_in_public,
            checkOut: $this->check_out_public
        )->to('reservation.public-booking-form');
    }
}
