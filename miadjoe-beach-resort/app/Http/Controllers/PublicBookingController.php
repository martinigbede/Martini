<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicBookingController extends Controller
{
    public function index(Request $request)
    {
        $roomId = $request->query('room_id'); // Récupère l'id de la chambre depuis l'URL
        return view('reservation.public-booking', compact('roomId'));
    }
}
