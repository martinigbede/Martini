<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Gère la redirection/webhook après un paiement réussi via Semoa.
     */
    public function handleSuccess(Request $request)
    {
        // ATTENTION : Dans un vrai système, on vérifie la signature du webhook.
        // Ici, on suppose que Semoa renvoie les données via des paramètres GET (query).
        
        $reservationId = $request->query('reservation_id');
        $status = $request->query('status'); // Ex: 'SUCCESS', 'PAID'
        
        if (!$reservationId) {
            session()->flash('error', "Paiement reçu, mais aucune référence de réservation trouvée.");
            return redirect()->route('public.reservation');
        }

        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            session()->flash('error', "La réservation ID {$reservationId} n'existe plus.");
            return redirect()->route('public.reservation');
        }

        // Logique de mise à jour basée sur la réponse de Semoa
        if ($status === 'SUCCESS' || $status === 'PAID') { // AJUSTER CES VALEURS SELON LA DOC SEMOA
            $reservation->statut = 'Confirmée';
            $reservation->save();
            
            // NOTE: Il faudrait aussi mettre à jour le paiement/facture ici si ce n'est pas fait par un webhook POST
            
            session()->flash('message', "Paiement réussi ! Votre réservation #{$reservationId} est CONFIRMÉE.");
        } else {
             session()->flash('warning', "Paiement reçu mais avec un statut inconnu ({$status}). Veuillez contacter l'hôtel.");
        }
        
        return redirect()->route('public.reservation'); // Redirige vers la page d'accueil/confirmation
    }

    /**
     * Gère la redirection après une annulation sur la page de paiement
     */
    public function handleCancel()
    {
        session()->flash('warning', "Paiement annulé. Votre réservation est toujours en statut 'En attente'.");
        
        return redirect()->route('public.reservation'); 
    }
}