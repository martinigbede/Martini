<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Services\ReservationService;
use App\Services\SemoaService;
use App\Services\ReservationCalculator;
use App\Models\Room;
use App\Models\Payment;
use Exception;

class PublicBookingForm extends Component
{
    public array $room_ids = [];
    public ?string $check_in = null;
    public ?string $check_out = null;
    public int $nb_personnes = 1;
    public bool $lit_dappoint = false;

    // Client
    public ?string $client_nom = null;
    public ?string $client_prenom = null;
    public ?string $client_email = null;
    public ?string $client_telephone = null;

    // ✅ Un seul choix : pay_now
    public string $payment_choice = 'pay_now';
    public float $payment_now_amount = 0.00;

    // UI / data
    public $rooms;
    public ?int $selectedRoomToAdd = null;
    public array $reservationItems = [];
    public float $total = 0.00;
    public int $days = 0;
    public float $amount_due = 0.00;
    public string $statut = 'en attente';

    protected ReservationService $reservationService;

    public function boot(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function mount()
    {
        $this->rooms = Room::with('roomType')->orderBy('numero')->get();
        $this->reservationItems = [];
        $this->payment_now_amount = 0.0;
        $this->total = 0.0;
    }

    public function render()
    {
        $this->updateDays();
        $this->updateTotal();

        return view('livewire.reservation.public-booking-form');
    }

    protected function rules(): array
    {
        $rules = [
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'client_nom' => 'required|string|max:255',
            'client_prenom' => 'required|string|max:255',
            'client_telephone' => [
                'required',
                'regex:/^\+[1-9]\d{7,14}$/',
            ],
            // ✅ forcé à pay_now uniquement
            'payment_choice' => 'in:pay_now',
        ];

        // ✅ Toujours obligatoire
        $rules['payment_now_amount'] = 'required|numeric|min:0.01|lte:' . $this->total;

        return $rules;
    }

    public function addRoomToReservation()
    {
        if (empty($this->selectedRoomToAdd)) return;

        $roomId = (int) $this->selectedRoomToAdd;

        if (in_array($roomId, $this->room_ids)) {
            $this->selectedRoomToAdd = null;
            return;
        }

        $room = $this->rooms->firstWhere('id', $roomId);
        if (! $room) {
            $this->selectedRoomToAdd = null;
            return;
        }

        $this->room_ids[] = $roomId;
        $this->reservationItems[] = [
            'room_id' => $roomId,
            'nb_personnes' => 1,
            'lit_dappoint' => false,
            'quantite' => 1,
        ];

        $this->selectedRoomToAdd = null;
        $this->updateTotal();
    }

    public function removeRoom(int $roomId)
    {
        $this->room_ids = array_values(array_filter($this->room_ids, fn($id) => $id !== $roomId));
        $this->reservationItems = array_values(array_filter($this->reservationItems, fn($it) => $it['room_id'] !== $roomId));
        $this->updateTotal();
    }

    public function incrementPersons(int $roomId)
    {
        foreach ($this->reservationItems as $k => $item) {
            if ($item['room_id'] === $roomId) {
                $this->reservationItems[$k]['nb_personnes']++;
                break;
            }
        }
        $this->updateTotal();
    }

    public function decrementPersons(int $roomId)
    {
        foreach ($this->reservationItems as $k => $item) {
            if ($item['room_id'] === $roomId) {
                $this->reservationItems[$k]['nb_personnes'] = max(1, $this->reservationItems[$k]['nb_personnes'] - 1);
                break;
            }
        }
        $this->updateTotal();
    }

    protected function updateDays(): void
    {
        if ($this->check_in && $this->check_out) {
            try {
                $this->days = ReservationCalculator::getDaysBetween($this->check_in, $this->check_out);
            } catch (Exception) {
                $this->days = 0;
            }
        } else {
            $this->days = 0;
        }
    }

    public function updateTotal(): void
    {
        $this->updateDays();
        $total = 0.0;

        foreach ($this->reservationItems as $k => $item) {
            $room = $this->rooms->firstWhere('id', $item['room_id']);
            if (!$room || !$room->roomType) continue;

            // Auto lit d’appoint en fonction du nombre de personnes max
            $capacite = $room->roomType->nombre_personnes_max ?? 2;
            $nbPersonnes = $item['nb_personnes'] ?? 1;

            if ($nbPersonnes > $capacite) {
                $this->reservationItems[$k]['lit_dappoint'] = true;
                $this->reservationItems[$k]['nb_lits_dappoint'] = $nbPersonnes - $capacite;
            } else {
                $this->reservationItems[$k]['nb_lits_dappoint'] = 0;
            }

            // Calcul du total par ligne
            $lineTotal = ReservationCalculator::calculateTotal(
                $room->roomType->id,
                $this->reservationItems[$k]['lit_dappoint'],
                $this->reservationItems[$k]['nb_personnes'],
                $this->days,
                $this->reservationItems[$k]['nb_lits_dappoint'] ?? 0
            );

            $total += $lineTotal * ($item['quantite'] ?? 1);
        }

        $this->total = (float) $total;
        $this->amount_due = max(0, $this->total);
    }

    public function updated($propertyName)
    {
        if (str_contains($propertyName, 'check_in') ||
            str_contains($propertyName, 'check_out') ||
            str_contains($propertyName, 'reservationItems') ||
            str_contains($propertyName, 'room_ids') ||
            $propertyName === 'nb_personnes' ||
            $propertyName === 'lit_dappoint'
        ) {
            $this->updateTotal();
        }
    }

    public function submit()
    {
        $this->updateTotal();
        $this->validate();

        if ($this->total <= 0) {
            $this->addError('general', 'Veuillez sélectionner au moins une chambre et des dates valides.');
            return;
        }

        if (! $this->roomsAvailableForPeriod()) {
            $this->addError('general', 'Une des chambres sélectionnées est déjà réservée pour ces dates.');
            return;
        }

        DB::beginTransaction();
        try {
            $payload = [
                'room_ids' => $this->room_ids,
                'check_in' => $this->check_in,
                'check_out' => $this->check_out,
                'reservation_items' => array_map(fn($it) => [
                    'room_id' => $it['room_id'],
                    'nb_personnes' => $it['nb_personnes'],
                    'lit_dappoint' => $it['lit_dappoint'] ?? false,
                    'nb_lits_dappoint' => $it['nb_lits_dappoint'] ?? 0,
                    'quantite' => $it['quantite'] ?? 1,
                ], $this->reservationItems),
                'nb_personnes' => $this->nb_personnes,
                'lit_dappoint' => $this->lit_dappoint,
                'client_is_new' => true,
                'client' => [
                    'nom' => $this->client_nom,
                    'prenom' => $this->client_prenom,
                    'email' => $this->client_email,
                    'telephone' => $this->client_telephone,
                ],
                'mode_reservation' => 'En ligne',
                'statut' => 'En attente',
            ];

            $result = $this->reservationService->createOrUpdate($payload);
            if (! $result['success']) {
                DB::rollBack();
                $this->addError('general', $result['message'] ?? 'Erreur lors de la réservation.');
                return;
            }

            $reservation = $result['reservation'];
            $this->dispatch('reservationSaved');
            // ✅ Paiement obligatoire (pay_now)
            $payment = Payment::create([
                'reservation_id' => $reservation->id,
                'montant' => $this->payment_now_amount,
                'mode_paiement' => 'Semoa',
                'statut' => 'En attente',
            ]);

            $transactionId = 'SEMOA-' . uniqid();
            $payment->update(['transaction_id' => $transactionId]);

            DB::commit();

            $semoaService = new SemoaService();
            $paymentUrl = $semoaService->payNowSemoa($reservation, $this->payment_now_amount, $transactionId);

            if ($paymentUrl) {
                return redirect()->away($paymentUrl);
            }

            session()->flash('message', 'Réservation enregistrée, mais redirection vers le paiement impossible.');
            $this->resetFormAfterSuccess();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('PublicBookingForm::submit error: ' . $e->getMessage());
            $this->addError('general', 'Une erreur serveur est survenue.');
        }
        
    }

    protected function resetFormAfterSuccess()
    {
        $this->room_ids = [];
        $this->reservationItems = [];
        $this->check_in = null;
        $this->check_out = null;
        $this->nb_personnes = 1;
        $this->lit_dappoint = false;
        $this->client_nom = null;
        $this->client_prenom = null;
        $this->client_email = null;
        $this->client_telephone = null;
        $this->payment_choice = 'pay_now';
        $this->payment_now_amount = 0;
        $this->total = 0;
        $this->days = 0;
        $this->amount_due = 0;
        $this->statut = 'en attente';
    }

    protected function roomsAvailableForPeriod(): bool
    {
        if (empty($this->room_ids) || ! $this->check_in || ! $this->check_out) return true;

        $conflictQuery = \App\Models\Reservation::where(function ($q) {
            $q->whereBetween('check_in', [$this->check_in, $this->check_out])
              ->orWhereBetween('check_out', [$this->check_in, $this->check_out])
              ->orWhere(function ($qq) {
                  $qq->where('check_in', '<=', $this->check_in)
                     ->where('check_out', '>=', $this->check_out);
              });
        })->whereHas('rooms', function ($q) {
            $q->whereIn('rooms.id', $this->room_ids);
        });

        return ! $conflictQuery->exists();
    }
}
