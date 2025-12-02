<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SemoaCheckoutService
{
    protected $baseUrl = 'https://api.semoa-payments.ovh/';
    protected $username = 'api_cashpay.miadjoebeach';
    protected $password = '7OGMOmlA53';
    protected $clientId = 'api_cashpay.miadjoebeach';
    protected $clientReference = 'TaB0Rq5WF6Iz5RUJN16i7z3D8343a5vS';

    /**
     * Crée un Checkout Semoa et retourne l'URL de redirection
     *
     * @param int $reservationId
     * @param float $amount
     * @param string $returnUrl
     * @return string|null
     */
    public function createCheckout(int $reservationId, float $amount, string $returnUrl)
    {
        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->post($this->baseUrl . 'checkout/create', [
                    'client_id' => $this->clientId,
                    'client_reference' => $this->clientReference,
                    'amount' => round($amount, 2),
                    'currency' => 'XOF',
                    'reservation_id' => $reservationId,
                    'return_url' => $returnUrl,
                    'description' => "Paiement réservation #{$reservationId} - Montant: " . number_format($amount, 0, ',', ' ') . " FCFA",
                ]);

            if ($response->successful() && isset($response['checkout_url'])) {
                return $response['checkout_url'];
            }

        } catch (\Throwable $e) {
            // log($e->getMessage());
            return null;
        }

        return null;
    }
}
