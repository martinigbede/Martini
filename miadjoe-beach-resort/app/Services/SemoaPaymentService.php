<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class SemoaPaymentService
{
    protected $baseUrl = 'https://api.semoa-payments.ovh/';
    protected $username = 'api_cashpay.miadjoebeach';
    protected $password = '7OGMOmlA53';
    protected $clientId = 'api_cashpay.miadjoebeach';
    protected $clientReference = 'TaB0Rq5WF6Iz5RUJN16i7z3D8343a5vS';
    
    protected $accessToken = null;

    public function __construct()
    {
        $this->getAccessToken();
    }

    protected function getAccessToken()
    {
        // Étape 1: Obtenir le Token (Simulation Oauth 2.0)
        // En production, ceci est souvent mis en cache pour éviter de redemander à chaque fois.
        try {
            $response = Http::post($this->baseUrl . 'oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->password, // Souvent le password est utilisé comme secret
            ]);

            if ($response->successful() && $response->json('access_token')) {
                $this->accessToken = $response->json('access_token');
            } else {
                \Log::error('Semoa Auth Failed: ' . $response->body());
                $this->accessToken = null;
            }
        } catch (\Exception $e) {
            \Log::error('Semoa Connection Error during Auth: ' . $e->getMessage());
            $this->accessToken = null;
        }
    }

    /**
     * Lance le processus de paiement externe et retourne l'URL de redirection.
     */
    public function processOnlinePayment($reservationId, $amount)
    {
        if (!$this->accessToken) {
            session()->flash('error', 'Erreur de connexion à la passerelle de paiement.');
            return null;
        }
        
        // Vous devriez idéalement générer une référence unique et stocker l'état de la transaction en attente ici.
        $transactionRef = 'RES-' . $reservationId . '-' . time(); 

        try {
            $response = Http::withToken($this->accessToken)
                ->post($this->baseUrl . 'api/v1/pay', [
                    'client_reference' => $this->clientReference,
                    'transaction_reference' => $transactionRef,
                    'amount' => number_format($amount, 2, '.', ''),
                    'description' => 'Reservation Hotel Miadjo - ID:' . $reservationId,
                    // IMPORTANT: L'API doit renvoyer l'utilisateur vers une URL de confirmation/webhook de VOTRE site.
                    'return_url' => route('paiement.confirmation'), // URL à créer dans routes/web.php
                    'cancel_url' => route('paiement.annulation'), // URL à créer dans routes/web.php
                ]);

            if ($response->successful() && $response->json('redirect_url')) {
                // Retourne l'URL où l'utilisateur doit être redirigé
                return $response->json('redirect_url');
            } else {
                \Log::error('Semoa Payment Initiation Failed: ' . $response->body());
                session()->flash('error', 'Erreur lors de l\'initiation du paiement en ligne.');
                return null;
            }

        } catch (\Exception $e) {
            \Log::error('Semoa Payment Connection Error: ' . $e->getMessage());
            session()->flash('error', 'Erreur de connexion lors du paiement.');
            return null;
        }
    }
}