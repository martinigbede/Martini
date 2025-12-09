<?php

namespace App\Services;

use App\Enums\ReservationStatus;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\ReservationLog;
use App\Services\SemoaService;
use App\Services\ReservationCalculator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ReservationService
{
    protected ReservationCalculator $calculator;

    public function __construct(ReservationCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Crée une réservation (ou met à jour si $reservation existe).
     *
     * @param  array  $payload  Données validées nécessaires (voir README usage ci-dessous).
     * @param  Reservation|null  $reservation
     * @return array  ['success' => bool, 'reservation' => Reservation, 'requires_payment' => bool, 'amount_due' => float]
     *
     * Expects keys in $payload:
     *  - room_ids (array)
     *  - check_in (string Y-m-d)
     *  - check_out (string Y-m-d)
     *  - nb_personnes (int)
     *  - lit_dappoint (bool)
     *  - client_is_new (bool)
     *  - client (array) OR client_id (int)
     *  - statut (string)
     */
    public function createOrUpdate(array $payload, ?Reservation $reservation = null): array
    {
        Log::debug('=== ReservationService::createOrUpdate() START ===', [
            'mode' => $reservation ? 'update' : 'create',
            'payload' => $payload,
        ]);

        if (empty($payload['room_ids'] ?? [])) {
            throw ValidationException::withMessages(['room_ids' => 'Aucune chambre sélectionnée.']);
        }

        $checkIn = Carbon::parse($payload['check_in']);
        $checkOut = Carbon::parse($payload['check_out']);

        if ($checkOut->lte($checkIn)) {
            throw ValidationException::withMessages(['check_out' => 'La date de départ doit être après la date d\'arrivée.']);
        }

        $days = $this->calculator::getDaysBetween($payload['check_in'], $payload['check_out']);
        $rooms = Room::with('roomType')->whereIn('id', $payload['room_ids'])->get();

        if ($rooms->count() !== count($payload['room_ids'])) {
            throw ValidationException::withMessages(['room_ids' => 'Certaines chambres sont invalides.']);
        }

        // Vérifie la disponibilité
        if (!$this->checkAvailability($payload['room_ids'], $payload['check_in'], $payload['check_out'], $reservation?->id)) {
            return [
                'success' => false,
                'message' => 'Une ou plusieurs chambres ne sont pas disponibles pour la période demandée.',
            ];
        }

        DB::beginTransaction();
        try {
            // 🔒 Verrou des chambres pour éviter les réservations concurrentes
            Room::whereIn('id', $payload['room_ids'])->lockForUpdate()->get();

            // === Gestion du client ===
            if (!empty($payload['client_is_new'])) {
                $clientData = $payload['client'] ?? [];
                $client = Client::updateOrCreate(
                    ['email' => $clientData['email']],
                    [
                        'nom' => $clientData['nom'],
                        'prenom' => $clientData['prenom'],
                        'telephone' => $clientData['telephone'],
                    ]
                );
            } else {
                $client = Client::findOrFail($payload['client_id']);
            }

            // === Création ou mise à jour de la réservation ===
            $isNew = !$reservation;
            $reservation = $reservation ?? new Reservation();

            $reservation->fill([
                'client_id' => $client->id,
                'check_in' => $payload['check_in'],
                'check_out' => $payload['check_out'],
                'nb_personnes' => 0,
                'lit_dappoint' => false,
                'statut' => $payload['statut'] ?? ReservationStatus::EN_ATTENTE->value,
                'total' => 0,
                'mode_reservation' => $payload['mode_reservation'] ?? 'Interne',
            ]);

            if ($isNew) {
                $reservation->created_by = auth()->id();
            } else {
                $reservation->updated_by = auth()->id();
            }

            $reservation->save();

            Log::debug('Reservation enregistrée', ['id' => $reservation->id]);

            // === Synchronisation des chambres ===
            $reservation->rooms()->sync($payload['room_ids']);

            // === Gestion granulaire des ReservationItems ===
            $existingItemIds = [];

            if (!empty($payload['reservation_items'])) {
                foreach ($payload['reservation_items'] as $itemData) {
                    $room = $rooms->firstWhere('id', $itemData['room_id']);
                    if (!$room) continue;

                    $item = \App\Models\ReservationItem::updateOrCreate(
                        [
                            'reservation_id' => $reservation->id,
                            'room_id' => $room->id,
                        ],
                        [
                            'quantite' => 1,
                            'nb_personnes' => $itemData['nb_personnes'] ?? 1,
                            'lit_dappoint' => $itemData['lit_dappoint'] ?? false,
                            'nb_lits_dappoint' => $itemData['nb_lits_dappoint'] ?? 0, 
                            'prix_unitaire' => $this->calculator::calculateTotal(
                                $room->roomType->id,
                                $itemData['lit_dappoint'] ?? false,
                                $itemData['nb_personnes'] ?? 1,
                                $days,
                                $itemData['nb_lits_dappoint'] ?? 0
                            ),
                        ]
                    );

                    $item->calculateTotal();
                    $item->save();
                    $existingItemIds[] = $item->id;
                }
            } else {
                // Fallback si pas de granularité
                foreach ($rooms as $room) {
                    $item = \App\Models\ReservationItem::updateOrCreate(
                        [
                            'reservation_id' => $reservation->id,
                            'room_id' => $room->id,
                        ],
                        [
                            'quantite' => 1,
                            'nb_personnes' => $payload['nb_personnes'] ?? 1,
                            'lit_dappoint' => $payload['lit_dappoint'] ?? false,
                            'nb_lits_dappoint' => $payload['nb_lits_dappoint'] ?? 0, 
                            'prix_unitaire' => $this->calculator::calculateTotal(
                                $room->roomType->id,
                                $payload['lit_dappoint'] ?? false,
                                $payload['nb_personnes'] ?? 1,
                                $days,
                                $payload['nb_lits_dappoint'] ?? 0
                            ),
                        ]
                    );
                    $item->calculateTotal();
                    $item->save();
                    $existingItemIds[] = $item->id;
                }
            }

            // 🔥 Supprime les ReservationItems supprimés dans le formulaire
            \App\Models\ReservationItem::where('reservation_id', $reservation->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();

            // === Recalcul du total global ===
            $reservation->total = \App\Models\ReservationItem::where('reservation_id', $reservation->id)->sum('total');
            $reservation->save();

            // === Mise à jour du statut des chambres ===
            $newStatus = $reservation->statut === ReservationStatus::CONFIRMEE->value ? 'Occupée' : 'Libre';
            Room::whereIn('id', $payload['room_ids'])->update(['statut' => $newStatus]);

            // === Facture ===
            $invoice = $this->createOrUpdateInvoice($reservation);

            // ✅ Mise à jour du statut de la facture selon les paiements existants
            $paidAmount = $reservation->payments()->sum('montant');

            if ($invoice->statut !== 'Offerte') {

                $paidAmount = $reservation->payments()->sum('montant');

                if ($paidAmount >= $reservation->total) {
                    $invoice->statut = 'payé';
                } elseif ($paidAmount > 0) {
                    $invoice->statut = 'partielle';
                } else {
                    $invoice->statut = 'en_attente';
                }

                $invoice->save();
            }

            // === Log de l’action ===
            $this->logAction(
                $reservation,
                auth()->id() ?? null,
                $isNew ? 'created' : 'updated'
            );

            DB::commit();

            $paidAmount = $reservation->payments()->sum('montant');
            $amountDue = max(0, $reservation->total - $paidAmount);
            $requiresPayment = $amountDue > 0;

            Log::debug('=== ReservationService::createOrUpdate() SUCCESS ===', [
                'reservation_id' => $reservation->id,
                'total' => $reservation->total,
                'requires_payment' => $requiresPayment,
                'amount_due' => $amountDue,
            ]);

            return [
                'success' => true,
                'reservation' => $reservation->fresh(['rooms', 'client', 'payments', 'items']),
                'invoice' => $invoice,
                'requires_payment' => $requiresPayment,
                'amount_due' => $amountDue,
            ];

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ReservationService::createOrUpdate ERROR', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde : ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Vérifie la disponibilité des chambres pour une période donnée.
     *
     * @param array $roomIds
     * @param string $checkIn
     * @param string $checkOut
     * @param int|null $excludeReservationId
     * @return bool  true = disponible (aucun conflit)
     */
    public function checkAvailability(array $roomIds, string $checkIn, string $checkOut, ?int $excludeReservationId = null): bool
    {
        $query = Reservation::where(function ($q) use ($checkIn, $checkOut) {
            $q->whereBetween('check_in', [$checkIn, $checkOut])
              ->orWhereBetween('check_out', [$checkIn, $checkOut])
              ->orWhere(function ($q2) use ($checkIn, $checkOut) {
                  $q2->where('check_in', '<=', $checkIn)
                     ->where('check_out', '>=', $checkOut);
              });
        })
        ->whereHas('rooms', fn($q) => $q->whereIn('rooms.id', $roomIds));

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        // Si existe une réservation qui croise -> indisponible
        return !$query->exists();
    }

    /**
     * Annule une réservation (soft cancel), crée un log et met à jour le statut des chambres.
     *
     * @param int $reservationId
     * @param string|null $reason
     * @return array
     */
    public function cancelReservation(int $reservationId, ?string $reason = null): array
    {
        DB::beginTransaction();
        try {
            $reservation = Reservation::with('rooms', 'payments')->findOrFail($reservationId);

            // Optionnel : vérifier règles d'annulation (pénalités)
            $reservation->statut = ReservationStatus::ANNULEE->value;
            $reservation->save();

            // Remettre le statut des chambres si nécessaire (ex : Libre)
            $roomIds = $reservation->rooms->pluck('id')->toArray();
            Room::whereIn('id', $roomIds)->update(['statut' => 'Libre']);

            $this->logAction($reservation, auth()->id() ?? null, 'cancelled', $reason);

            DB::commit();

            return ['success' => true, 'reservation' => $reservation];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ReservationService::cancelReservation error: '.$e->getMessage(), ['exception' => $e]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Prolonge une réservation (change check_out) et recalcul le total.
     *
     * @param int $reservationId
     * @param string $newCheckOut (Y-m-d)
     * @return array
     */
    public function extendReservation(int $reservationId, string $newCheckOut): array
    {
        DB::beginTransaction();
        try {
            $reservation = Reservation::with('rooms.roomType')->findOrFail($reservationId);

            $newCheckOutDate = Carbon::parse($newCheckOut);
            $currentCheckOut = Carbon::parse($reservation->check_out);

            if ($newCheckOutDate->lte($currentCheckOut)) {
                throw ValidationException::withMessages(['check_out' => 'La nouvelle date de départ doit être après la date actuelle.']);
            }

            // Vérifier disponibilité pour la période supplémentaire uniquement
            $additionalPeriodStart = $currentCheckOut;
            $additionalPeriodEnd = $newCheckOutDate;

            $roomIds = $reservation->rooms->pluck('id')->toArray();
            if (!$this->checkAvailability($roomIds, $additionalPeriodStart->toDateString(), $additionalPeriodEnd->toDateString(), $reservation->id)) {
                return ['success' => false, 'message' => 'Impossible de prolonger : les chambres ne sont pas disponibles pour la période demandée.'];
            }

            // Recalculer days & total
            $days = $this->calculator::getDaysBetween($reservation->check_in, $newCheckOutDate->toDateString());

            $total = collect($reservation->rooms)->sum(function ($room) use ($reservation, $days) {
                return $this->calculator::calculateTotal(
                    $room->roomType->id,
                    $reservation->lit_dappoint,
                    $reservation->nb_personnes,
                    $days
                );
            });

            $reservation->update([
                'check_out' => $newCheckOutDate->toDateString(),
                'days' => $days,
                'total' => $total,
            ]);

            // Mettre à jour la facture
            $invoice = $this->createOrUpdateInvoice($reservation);

            $this->logAction($reservation, auth()->id() ?? null, 'extended', "Nouvelle sortie: {$newCheckOutDate->toDateString()}");

            DB::commit();

            $paidAmount = $reservation->payments()->sum('amount');
            $amountDue = max(0, $reservation->total - $paidAmount);

            return [
                'success' => true,
                'reservation' => $reservation->fresh(['rooms', 'payments']),
                'requires_payment' => $amountDue > 0,
                'amount_due' => $amountDue,
                'invoice' => $invoice,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ReservationService::extendReservation error: '.$e->getMessage(), ['exception' => $e]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Crée ou met à jour une invoice liée à la reservation.
     *
     * @param Reservation $reservation
     * @return Invoice
     */
    protected function createOrUpdateInvoice(Reservation $reservation): Invoice
    {
        // Vérifier si la facture existe
        $invoice = Invoice::where('reservation_id', $reservation->id)->first();

        if (!$invoice) {

            // 🔥 Nouvelle facture : ok pour initialiser
            return Invoice::create([
                'reservation_id' => $reservation->id,
                'client_id' => $reservation->client_id,
                'montant_total' => $reservation->total,
                'remise_percent' => 0,
                'remise_amount' => 0,
                'montant_final' => $reservation->total,
                'montant_paye' => 0,
                'statut' => 'en_attente',
                'issued_at' => now(),
            ]);
        }

        // Si la facture est offerte → on garde tout intact
        if ($invoice->statut === 'Offerte') {
            // on met juste à jour le total et ajuste la remise
            $invoice->update([
                'montant_total' => $reservation->total,
                'remise_amount' => $reservation->total,
                'remise_percent' => 100,
                'montant_final' => 0,
                'montant_paye' => 0,
            ]);
            return $invoice;
        }

        // 🔥 Facture EXISTANTE → ne pas toucher aux paiements / remises / statut
        $invoice->update([
            'client_id' => $reservation->client_id,
            'montant_total' => $reservation->total,
            // NE RIEN TOUCHER D’AUTRE
        ]);

        return $invoice;
    }

    /**
     * Enregistre un log d'action sur la réservation.
     *
     * @param Reservation $reservation
     * @param int|null $userId
     * @param string $action
     * @param string|null $meta
     * @return void
     */
    protected function logAction(Reservation $reservation, ?int $userId, string $action, ?string $meta = null): void
    {
        try {
            // Assumes you have a ReservationLog model / table. If not, create it.
            if (class_exists(ReservationLog::class)) {
                ReservationLog::create([
                    'reservation_id' => $reservation->id,
                    'user_id' => $userId,
                    'action' => $action,
                    'meta' => $meta,
                ]);
            } else {
                // fallback to laravel log if no table
                Log::info("ReservationAction: {$action} for reservation {$reservation->id}", ['user' => $userId, 'meta' => $meta]);
            }
        } catch (\Throwable $e) {
            Log::warning("Failed to write reservation log: ".$e->getMessage());
        }
    }
}
