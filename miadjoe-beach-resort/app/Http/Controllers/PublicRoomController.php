<?php

namespace App\Http\Controllers;

use App\Models\Room;

class PublicRoomController extends Controller
{
    public function show(Room $room)
    {
        $room->load(['roomType', 'images']);

        return view('rooms.show', compact('room'));
    }
}
