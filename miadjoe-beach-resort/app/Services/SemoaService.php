<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Reservation;

class SemoaService
{
    protected string $endpoint;
    protected string $username;
    protected string $password;
    protected string $clientId;
    protected string $clientSecret;
    protected string $callbackUrl;

    // Clé de cache pour le token
    protected const CACHE_KEY = 'semoa_access_token';

    public function __construct()
    {
        $this->endpoint     = rtrim(config('services.semoa.endpoint'), '/');
        $this->username     = config('services.semoa.username');
        $this->password     = config('services.semoa.password');
        $this->clientId     = config('services.semoa.client_id');
        $this->clientSecret = config('services.semoa.client_secret'); // ⚠️ pas client_reference ici
        $this->callbackUrl  = env('SEMOA_CALLBACK_URL');
    }

    /**
     * 🔑 Récupère et met en cache le token d'accès
     */
    public function getAccessToken(): ?string
    {
        // Vérifie d'abord le cache
        if (Cache::has(self::CACHE_KEY)) {
            return Cache::get(self::CACHE_KEY);
        }

        $tokenUrl = $this->endpoint . '/auth';

        try {
            $response = Http::asJson()->post($tokenUrl, [
                'username'      => $this->username,
                'password'      => $this->password,
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->failed()) {
                \Log::error('SemoaService: Failed to retrieve OAuth token.', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();
            if (!isset($data['access_token'])) {
                \Log::error('SemoaService: No access_token in response', ['response' => $data]);
                return null;
            }

            $token = $data['access_token'];
            $expiresIn = $data['expires_in'] ?? 600;

            Cache::put(self::CACHE_KEY, $token, $expiresIn - 60);
            \Log::info('SemoaService: OAuth Token retrieved and cached.');
            return $token;

        } catch (\Throwable $e) {
            \Log::error('SemoaService: Token retrieval exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function testAccessToken()
    {
        return $this->getAccessToken();
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

   

    public function getCallbackUrl()
    {
        return config('app.url') . '/api/semoa/callback';
    }

    /**
     * 💳 Génère le lien de paiement CashPay Semoa
     */
    public function payNowSemoa(Reservation $reservation, float $amount = null, string $transactionId = null): ?string
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            \Log::error('SemoaService: Cannot proceed without an Access Token.');
            return null;
        }

        $amount = intval($amount ?? $reservation->total);

        $payload = [
            'amount' => $amount,
            //'currency' => 'XOF',
            'description' => 'Réservation #' . $reservation->id,
            'merchant_reference' => $transactionId,
            'client' => [
                'lastname'  => $reservation->client->nom ?? 'Test',
                'firstname' => $reservation->client->prenom ?? 'Client',
                'phone' => $reservation->client->telephone ?? '+22890000000',
                'email'     => $reservation->client->email ?? 'no-email@example.com',
            ],
            'callback_url' => $this->callbackUrl,
            'redirect_url' => route('semoa.success'), // ✅ Redirige ici après paiement réussi
            'cancel_url'   => route('semoa.cancel'),  // ✅ Si l’utilisateur annule le paiement
    
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
        ];

        try {
            $response = Http::withHeaders($headers)
                ->asJson()
                ->timeout(20)
                ->post($this->endpoint . '/orders', $payload);

            \Log::debug('SemoaService::payNowSemoa response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['bill_url'] ?? null;
            }

            \Log::error('SemoaService::payNowSemoa failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        } catch (\Throwable $e) {
            \Log::error('SemoaService::payNowSemoa exception: ' . $e->getMessage());
        }

        return null;
    }
}
