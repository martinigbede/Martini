<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;

class SemoaCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Récupération des données du callback
        $reservationId = $request->input('reservation_id');
        $status        = $request->input('status'); // SUCCESS / FAILED
        $amount        = $request->input('amount');

        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        // Enregistrement du paiement
        Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $amount,
            'status' => $status,
            'method' => 'SEMOA',
        ]);

        // Mise à jour du statut de la réservation
        if ($status === 'SUCCESS') {
            $reservation->update(['statut' => 'Confirmée']);
        }

        return response()->json(['message' => 'Callback traité avec succès'], 200);
    }
}
