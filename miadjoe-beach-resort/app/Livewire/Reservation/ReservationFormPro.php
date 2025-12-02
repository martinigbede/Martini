<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Client;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Reservation;
use App\Services\ReservationService;
use App\Services\ReservationCalculator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ReservationFormPro extends Component
{
    public ?int $reservationId = null;
    public $showModal = true;
    public $selectedRoomToAdd = null;

    // --- CLIENTS ---
    public $clients = [];
    public $selectedClientId = null;
    public $isNewClient = false;

    public $client_nom;
    public $client_prenom;
    public $client_email;
    public $client_telephone;

    // --- RÉSERVATION ---
    public $room_ids = [];
    public $rooms = [];
    public $roomTypes = [];
    public $check_in;
    public $check_out;
    public $nb_personnes = 1;
    public $lit_dappoint = false;
    public $statut = 'En attente';
    public $mode_reservation = 'Interne';

    // --- CALCUL ---
    public $total = 0;
    public $days = 0;
    public $amount_due = 0;

    // --- Items granulaire ---
    public $reservationItems = [];

    protected $listeners = ['refreshReservationFormPro' => '$refresh'];

    // === INITIALISATION ===
    public function mount(?int $reservationId = null)
    {
        $this->reservationId = $reservationId;
        $this->clients = Client::orderBy('nom')->get();
        $this->rooms = Room::with('roomType')->orderBy('numero')->get();
        $this->roomTypes = RoomType::all();

        // ✅ S'assurer que nb_personnes >= 1
        if (!$this->nb_personnes || $this->nb_personnes < 1) {
            $this->nb_personnes = 1;
        }

        if ($reservationId) {
            $this->loadReservation($reservationId);
        }
    }

    // === OUTILS ===
    private function calculateItemTotal($roomTypeId, $nb_personnes, $lit_dappoint, $days)
    {
        return ReservationCalculator::calculateTotal($roomTypeId, $lit_dappoint, $nb_personnes, $days);
    }

    // === GESTION CLIENT ===
    private function onClientChange()
    {
        if ($this->selectedClientId === 'new') {
            $this->isNewClient = true;
            $this->resetClientFields();
        } elseif ($this->selectedClientId) {
            $this->isNewClient = false;
            $client = Client::find($this->selectedClientId);
            if ($client) {
                $this->client_nom = $client->nom;
                $this->client_prenom = $client->prenom;
                $this->client_email = $client->email;
                $this->client_telephone = $client->telephone;
            }
        }
    }

    private function resetClientFields()
    {
        $this->client_nom = '';
        $this->client_prenom = '';
        $this->client_email = '';
        $this->client_telephone = '';
    }

    // === CHARGEMENT / ÉDITION ===
    private function loadReservation($id)
    {
        $res = Reservation::with(['client', 'rooms', 'payments', 'items'])->findOrFail($id);

        $this->selectedClientId = $res->client_id;
        $this->isNewClient = false;

        $this->client_nom = $res->client->nom;
        $this->client_prenom = $res->client->prenom;
        $this->client_email = $res->client->email;
        $this->client_telephone = $res->client->telephone;

        $this->check_in = $res->check_in;
        $this->check_out = $res->check_out;
        $this->nb_personnes = max(1, $res->nb_personnes);
        $this->lit_dappoint = $res->lit_dappoint;
        $this->room_ids = $res->rooms->pluck('id')->toArray();
        $this->statut = $res->statut;
        $this->mode_reservation = $res->mode_reservation;
        $this->total = $res->total;

        // Items granulaire
        $this->reservationItems = $res->items?->map(function ($item) {
            return [
                'room_id' => $item->room_id,
                'nb_personnes' => max(1, $item->nb_personnes),
                'lit_dappoint' => $item->lit_dappoint,
                'prix_unitaire' => $item->prix_unitaire,
                'total' => $item->total,
                'quantite' => $item->quantite,
            ];
        })->toArray() ?? [];

        $paid = $res->payments->sum('montant');
        $this->amount_due = max(0, $res->total - $paid);
    }

    // === ACTIONS SUR LES CHAMBRES ===
    public function addRoomToReservation()
    {
        if ($this->selectedRoomToAdd && !in_array($this->selectedRoomToAdd, $this->room_ids)) {
            $room = $this->rooms->firstWhere('id', $this->selectedRoomToAdd);

            $prix = $this->calculateItemTotal(
                $room->roomType->id,
                $this->nb_personnes,
                $this->lit_dappoint,
                $this->days
            );

            $this->reservationItems[] = [
                'room_id' => $room->id,
                'nb_personnes' => $this->nb_personnes,
                'lit_dappoint' => $this->lit_dappoint,
                'quantite' => 1,
                'prix_unitaire' => $prix,
                'total' => $prix,
            ];

            $this->room_ids[] = $room->id;
            $this->selectedRoomToAdd = null;
            $this->calculateTotal();
        }
    }

    public function removeRoom($roomId)
    {
        $this->reservationItems = array_values(array_filter(
            $this->reservationItems,
            fn($item) => $item['room_id'] != $roomId
        ));
        $this->room_ids = array_values(array_filter($this->room_ids, fn($id) => $id != $roomId));
        $this->calculateTotal();
    }

    // === CALCULS ===
    public function calculateTotal()
    {
        if (!$this->check_in || !$this->check_out || empty($this->room_ids)) {
            $this->total = $this->amount_due = $this->days = 0;
            return;
        }

        try {
            $this->days = ReservationCalculator::getDaysBetween($this->check_in, $this->check_out);
            $total = 0;
            $items = [];

            foreach ($this->rooms->whereIn('id', $this->room_ids) as $room) {
                $item = collect($this->reservationItems)->firstWhere('room_id', $room->id);

                $nb = max(1, $item['nb_personnes'] ?? $this->nb_personnes);
                $lit = $item['lit_dappoint'] ?? $this->lit_dappoint;

                $prix = $this->calculateItemTotal($room->roomType->id, $nb, $lit, $this->days);

                $items[] = [
                    'room_id' => $room->id,
                    'quantite' => 1,
                    'nb_personnes' => $nb,
                    'lit_dappoint' => $lit,
                    'prix_unitaire' => $prix,
                    'total' => $prix,
                ];

                $total += $prix;
            }

            $this->reservationItems = $items;
            $this->total = $total;

            // montant dû
            if (!$this->isNewClient && $this->selectedClientId) {
                $paid = Client::find($this->selectedClientId)
                    ?->reservations()->with('payments')->get()
                    ->sum(fn($r) => $r->payments->sum('montant')) ?? 0;
                $this->amount_due = max(0, $this->total - $paid);
            } else {
                $this->amount_due = $this->total;
            }

        } catch (\Throwable $e) {
            Log::error('Erreur calcul total : ' . $e->getMessage());
            $this->total = $this->amount_due = $this->days = 0;
            $this->reservationItems = [];
        }
    }

    // === ACTIONS FORM ===
    public function save()
    {
        Log::debug('=== ReservationFormPro::save() ===');
        Log::debug('Avant validation');

        // Force nb_personnes minimum avant validation
        $this->nb_personnes = max(1, $this->nb_personnes);

        $this->validate($this->rules());

        $payload = [
            'client_is_new' => $this->isNewClient,
            'client_id' => $this->selectedClientId,
            'client' => [
                'nom' => $this->client_nom,
                'prenom' => $this->client_prenom,
                'email' => $this->client_email,
                'telephone' => $this->client_telephone,
            ],
            'room_ids' => $this->room_ids,
            'reservation_items' => $this->reservationItems,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'nb_personnes' => $this->nb_personnes,
            'lit_dappoint' => $this->lit_dappoint,
            'statut' => $this->statut,
            'mode_reservation' => $this->mode_reservation,
        ];

        try {
            Log::debug('Avant ReservationService');
            $service = app(ReservationService::class);
            $reservationModel = $this->reservationId ? Reservation::find($this->reservationId) : null;

            Log::debug('ReservationModel', ['reservationId' => $this->reservationId, 'model' => $reservationModel]);

            $result = $service->createOrUpdate($payload, $reservationModel);
            Log::debug('Résultat service', ['result' => $result]);

            if ($result['success']) {
                // 🔄 Recalcule le total complet (hébergement + ventes liées)
                $result['reservation']->recalculerTotal();

                session()->flash('success', 'Réservation enregistrée avec succès !');
                $this->dispatch('reservationSaved', $result['reservation']->id);
                $this->dispatch('closeFormModal');
            } else {
                session()->flash('error', $result['message'] ?? 'Erreur lors de la sauvegarde.');
            }
        } catch (ValidationException $ve) {
            $this->addError('validation', $ve->getMessage());
            Log::error('❌ ValidationException dans save(): '.$ve->getMessage(), ['errors' => $ve->errors()]);
        } catch (\Throwable $e) {
            Log::error('Erreur ReservationFormPro::save(): '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Une erreur est survenue : '.$e->getMessage());
        }

        Log::debug('=== Fin ReservationFormPro::save() ===');
    }


    // === INCRÉMENT / DÉCRÉMENT ===
    public function incrementPersons($roomId = null)
    {
        foreach ($this->reservationItems as &$item) {
            if (!$roomId || $item['room_id'] == $roomId) $item['nb_personnes']++;
        }
        $this->calculateTotal();
    }

    public function decrementPersons($roomId = null)
    {
        foreach ($this->reservationItems as &$item) {
            if ((!$roomId || $item['room_id'] == $roomId) && $item['nb_personnes'] > 1) $item['nb_personnes']--;
        }
        $this->calculateTotal();
    }

    public function toggleLitDappoint($roomId)
    {
        foreach ($this->reservationItems as &$item) {
            if ($item['room_id'] == $roomId) $item['lit_dappoint'] = !$item['lit_dappoint'];
        }
        $this->calculateTotal();
    }

    // === LIVEWIRE ===
    public function updated($property)
    {
        // Force nb_personnes >= 1 en temps réel
        if ($property === 'nb_personnes' && $this->nb_personnes < 1) {
            $this->nb_personnes = 1;
        }

        if (str_starts_with($property, 'reservationItems.') ||
            in_array($property, ['check_in', 'check_out', 'room_ids', 'nb_personnes', 'lit_dappoint'])) {
            $this->calculateTotal();
        }

        if ($property === 'selectedClientId') {
            $this->onClientChange();
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('closeFormModal');
    }

    protected function rules()
    {
        return [
            'selectedClientId' => 'nullable',
            'client_nom' => 'required_if:isNewClient,true|string',
            'client_prenom' => 'required_if:isNewClient,true|string',
            'client_email' => 'required_if:isNewClient,true|email',
            'client_telephone' => 'required_if:isNewClient,true|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'nb_personnes' => 'required|integer|min:1',
            'room_ids' => 'required|array|min:1',
        ];
    }

    public function render()
    {
        return view('livewire.reservation.reservation-form-pro', [
            'clients' => $this->clients,
            'rooms' => $this->rooms,
        ]);
    }
}
