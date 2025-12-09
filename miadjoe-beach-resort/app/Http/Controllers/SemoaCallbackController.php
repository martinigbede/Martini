<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\SemoaPaymentNotification;

class SemoaCallbackController extends Controller
{
    /**
     * Lance un paiement SEMOA pour une réservation donnée.
     */
    public function payer(Request $request, $reservationId)
    {
        $reservation = Reservation::with(['client', 'rooms'])->findOrFail($reservationId);

        $numero = $reservation->client->numero;
        if (strpos($numero, '+228') === false) {
            $numero = '+228' . ltrim($numero, '0');
        }

        // Crée ou récupère la facture
        $invoice = Invoice::firstOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'montant_total' => $reservation->total,
                'montant_paye' => 0,
                'statut' => 'En attente'
            ]
        );

        $callbackUrl = route('semoa.callback');
        $successUrl  = route('semoa.success');
        $cancelUrl   = route('semoa.cancel');

        $payload = [
            'amount' => $reservation->total,
            'currency' => 'XOF',
            'customer_msisdn' => $numero,
            'callback_url' => $callbackUrl,
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'description' => 'Paiement réservation ' . $reservation->id,
        ];

        Log::info('🔹 Envoi paiement SEMOA', $payload);

        try {
            $response = Http::post('https://sandbox.semoa-payments.com/api/payments', $payload);
            $result = $response->json();
            Log::info('🔹 Réponse SEMOA', $result);

            if ($response->successful() && isset($result['bill_url'])) {

                // Crée un paiement unique pour cette transaction
                $payment = Payment::create([
                    'reservation_id' => $reservation->id,
                    'montant' => $reservation->total,
                    'statut' => 'En attente',
                    'mode_paiement' => 'MobileMoney',
                    'transaction_id' => $result['merchant_reference'], // correspond à SEMOA
                ]);

                return redirect()->away($result['bill_url']);
            }

            return back()->with('error', 'Erreur lors de la création du paiement SEMOA.');

        } catch (\Exception $e) {
            Log::error('Erreur SEMOA : ' . $e->getMessage());
            return back()->with('error', 'Impossible de contacter le service SEMOA.');
        }
    }

    /**
     * Callback SEMOA → mis à jour automatiquement par SEMOA.
     */
    public function handle(Request $request)
    {
        $data = $request->json()->all();
        Log::info('SEMOA Callback reçu', $data);

        // Récupération des références possibles depuis le callback
        $refs = array_filter([
            $data['merchant_reference'] ?? null,
            $data['order_reference'] ?? null,
            $data['external_order_reference'] ?? null,
            $data['payments'][0]['thirdparty_reference'] ?? null
        ]);

        // Recherche du paiement correspondant
        $payment = Payment::whereIn('transaction_id', $refs)->first();

        if (!$payment) {
            Log::warning("Aucun paiement trouvé pour la référence SEMOA : " . implode(',', $refs));
            return response()->json(['error' => 'Paiement introuvable'], 404);
        }

        $reservation = $payment->reservation;
        $invoice = $reservation->invoice;

        // Montant payé et statut renvoyé par SEMOA
        $amountPaid = (float)($data['amount'] ?? $data['payments'][0]['amount'] ?? 0);
        $state = strtoupper($data['state'] ?? 'PENDING');

        DB::transaction(function () use ($payment, $invoice, $reservation, $amountPaid, $state, $refs) {
            // Mise à jour du paiement
            $payment->update([
                'statut' => match($state) {
                    'PAID' => 'Payé',
                    'FAILED' => 'Échoué',
                    default => 'En attente',
                },
                'montant' => $amountPaid
            ]);

            if ($invoice) {
                $invoice->montant_paye += $amountPaid;

                if ($invoice->montant_paye >= $invoice->montant_total) {
                    $invoice->statut = 'Payé';
                } elseif ($invoice->montant_paye >= ($invoice->montant_total / 2)) {
                    $invoice->statut = 'Accompte';
                } else {
                    $invoice->statut = 'En attente';
                }
                $invoice->save();
            }

            // Mise à jour de la réservation
            $reservation->statut = match($invoice->statut ?? 'En attente') {
                'Payé', 'Accompte' => 'Confirmée',
                default => 'En attente',
            };
            $reservation->save();

            Log::info("Callback SEMOA traité pour transaction : " . implode(',', $refs), [
                'reservation_id' => $reservation->id,
                'payment_id' => $payment->id,
                'invoice_id' => $invoice->id ?? null
            ]);
        });

        if ($state === 'PAID') {
            try {
                Mail::to([
                        //'reservations@miadjoebeachresort.com',
                        //'reservationmiadjoebeachresort@gmail.com',
                        //'marouwaine81@gmail.com',
                        //'direction@miadjoebeachresort.com',
                        'martinigbede@gmail.com'
                    ])->send(new SemoaPaymentNotification($reservation, $payment, $data));
            } catch (\Throwable $e) {
                Log::error('Erreur envoi email SEMOA: ' . $e->getMessage());
            }
        }

        // -----------------------------------------
        // AJOUT AUTOMATIQUE EN CAISSE SI PAYÉ
        // -----------------------------------------
        if ($state === 'PAID') {
            app(\App\Services\CashAccountService::class)
                ->creditSemoaPayment($payment);
        }

        return response()->json(['message' => 'Callback traité avec succès']);
    }

    public function success()
    {
        return view('paiement.success');
    }

    public function cancel()
    {
        return view('paiement.cancel');
    }

}
