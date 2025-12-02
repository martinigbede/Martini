<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AvailableRoomsController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        $occupiedRoomIds = Reservation::where(function ($q) use ($checkIn, $checkOut) {
            $q->whereBetween('check_in', [$checkIn, $checkOut])
              ->orWhereBetween('check_out', [$checkIn, $checkOut])
              ->orWhere(function ($qq) use ($checkIn, $checkOut) {
                  $qq->where('check_in', '<=', $checkIn)
                     ->where('check_out', '>=', $checkOut);
              });
        })->pluck('id')->toArray();

        $availableRooms = Room::whereNotIn('id', $occupiedRoomIds)->get();

        return view('rooms.available', [
            'rooms' => $availableRooms,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nb_personnes' => $request->nb_personnes,
        ]);
    }
}
