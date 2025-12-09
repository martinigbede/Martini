<?php

namespace App\Services;

use App\Models\CashAccount;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashAccountService
{
    public function creditSemoaPayment(Payment $payment): void
    {
        if ($payment->statut !== 'Payé') {
            return;
        }

        $lockKey = 'cash_credit_payment_' . $payment->id;

        if (Cache::has($lockKey)) {
            Log::warning("SEMOA : Crédit déjà appliqué, tentative ignorée", [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
            ]);
            return;
        }

        Cache::put($lockKey, true, now()->addMinutes(10));

        $cashAccount = CashAccount::firstOrCreate(
            [
                'type_caisse' => 'Hébergement',
                'nom_compte'  => 'Mobile Money',
            ],
            [
                'solde' => 0,
            ]
        );

        DB::transaction(function () use ($cashAccount, $payment) {

            // Enregistrement du mouvement de caisse (transaction)
            $cashAccount->addTransaction(
                amount: $payment->montant,
                type: 'entree',
                description: "Crédit SEMOA - Réservation #{$payment->reservation_id}",
                userId: $payment->user_id
            );

            Log::info("SEMOA : Caisse créditée + mouvement créé", [
                'payment_id' => $payment->id,
                'montant' => $payment->montant,
            ]);
        });
    }
}
