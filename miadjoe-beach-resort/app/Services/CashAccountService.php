<?php

namespace App\Services;

use App\Models\CashAccount;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashAccountService
{
    /**
     * Crédit la caisse Mobile Money (Hébergement)
     * avec protection anti-doublon.
     */
    public function creditSemoaPayment(Payment $payment): void
    {
        if ($payment->statut !== 'Payé') {
            return;
        }

        // Clé de verrouillage anti-doublon
        $lockKey = 'cash_credit_payment_' . $payment->id;

        // Si un crédit a déjà été appliqué récemment, on stoppe
        if (Cache::has($lockKey)) {
            Log::warning("SEMOA : Crédit déjà appliqué, tentative ignorée", [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
            ]);
            return;
        }

        // Verrou de 10 minutes
        Cache::put($lockKey, true, now()->addMinutes(10));

        // On force la caisse Hébergement / Mobile Money
        $cashAccount = CashAccount::firstOrCreate(
            [
                'type_caisse' => 'Hébergement',
                'nom_compte' => 'Mobile Money',
            ],
            [
                'solde' => 0,
            ]
        );

        DB::transaction(function () use ($cashAccount, $payment) {
            $cashAccount->update([
                'solde' => DB::raw("solde + {$payment->montant}")
            ]);

            Log::info("SEMOA : Caisse créditée (anti-doublon actif)", [
                'payment_id' => $payment->id,
                'montant' => $payment->montant,
            ]);
        });
    }
}
