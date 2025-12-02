<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicPaymentController extends Controller
{
    public function callback(Request $request)
    {
        // Semoa peut renvoyer des params GET (status, reference, transaction_id, etc.)
        // Log pour debug
        Log::info('Semoa callback', $request->all());

        // Exemple : on récupère la reference (RES#123)
        $reference = $request->input('reference') ?? $request->input('order_ref');

        // Trouver reservation via reference ou metadata
        if ($reference && preg_match('/RES#(\d+)/', $reference, $m)) {
            $reservationId = (int)$m[1];
            $reservation = Reservation::find($reservationId);
            if ($reservation) {
                // ici on doit vérifier la validité via API Semoa (recommander)
                // Pour l'instant, si Semoa renvoie status=success on marque payée
                $status = $request->input('status', 'unknown');

                if (in_array($status, ['success','paid','completed'])) {
                    // marquer payment/invoice/reservation
                    Payment::create([
                        'reservation_id' => $reservation->id,
                        'montant' => $reservation->total,
                        'mode_paiement' => 'Semoa',
                        'statut' => 'Confirmé',
                    ]);
                    $reservation->update(['statut' => 'Confirmée']);
                    // mettre invoice payée, etc.
                    // rediriger avec succès
                    return redirect('/')->with('message', 'Paiement réussi. Merci !');
                } else {
                    return redirect('/')->with('error', 'Paiement non confirmé par Semoa.');
                }
            }
        }

        return redirect('/')->with('error', 'Référence réservation introuvable.');
    }
}
