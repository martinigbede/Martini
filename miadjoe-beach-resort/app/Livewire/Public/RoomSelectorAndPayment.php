<?php

namespace App\Livewire\Public;

use App\Models\Client;
use App\Models\Reservation;
use App\Models\Room;
use App\Services\ReservationCalculator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RoomSelectorAndPayment extends Component
{
    // --- PROPRIÉTÉS REÇUES DE L'ÉTAPE 1 (URL) ---
    public $check_in, $check_out, $roomIdsString, $typeId;
    
    // --- ÉTATS INTERNES ET SÉLECTION ---
    public $availableRooms = [];
    public $selectedRoomId = null;
    public $nights = 0;
    
    // --- DÉTAILS DE LA RÉSERVATION & CALCUL ---
    public $nb_personnes = 1;
    public $lit_dappoint = false;
    public $total = 0.00;
    public $search_nb_personnes = 1; // Pour cohérence avec l'étape 1
    
    // --- DONNÉES CLIENT (Pour création rapide) ---
    public $client_email, $client_nom, $client_telephone, $client_prenom;

    public function rules()
    {
        return [
            'selectedRoomId' => 'required|integer|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'nb_personnes' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0.01',
            // Règles client (tous requis pour une réservation publique)
            'client_email' => ['required', 'email', Rule::unique('clients', 'email')], 
            'client_nom' => 'required|string|max:255',
            'client_telephone' => 'required|string|max:20',
        ];
    }

    public function mount()
    {
        // Récupérer les paramètres de l'URL
        $this->check_in = request()->query('check_in');
        $this->check_out = request()->query('check_out');
        $this->typeId = request()->query('type_id');
        $this->lit_dappoint = (bool)request()->query('extra_bed', 0); // Initialiser lit d'appoint
        $this->roomIdsString = request()->query('room_ids');

        // Validation des dates (doit réussir pour continuer)
        //$this->validateOnly(['check_in', 'check_out']);

        $this->nights = Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out));
        
        $this->loadAvailableRooms();
        $this->calculateTotal(); // Calcul initial
    }

    protected function loadAvailableRooms()
    {
        $roomIds = explode(',', $this->roomIdsString);
        $this->availableRooms = Room::with('roomType')
            ->whereIn('id', $roomIds) // Filtre uniquement les IDs de chambres disponibles
            ->when($this->typeId, function($query) {
                $query->where('room_type_id', $this->typeId);
            })
            ->get();
        
        // Si des chambres sont disponibles, sélectionner la première par défaut
        if ($this->availableRooms->isNotEmpty()) {
            $this->selectedRoomId = $this->availableRooms->first()->id;
            $this->calculateTotal();
        }

         $this->calculatePrice(); // Si vous avez une méthode calculatePrice(), utilisez-la
        
        // SI VOUS VOULEZ UTILISER calculateTotal() (comme dans le CRUD 5) :
        $this->calculateTotal(); // Appeler la nouvelle méthode pour la cohérence
    }

    // --- LOGIQUE DE CALCUL ---
    public function updatedLitDappoint($value) { $this->calculateTotal(); }
    public function updatedNbPersonnes($value) { $this->calculateTotal(); }
    public function updatedSelectedRoomId($value) { $this->calculatePrice(); } // Recalcule le prix si la chambre change

    public function calculatePrice()
    {
        if (!$this->selectedRoomId || !$this->check_in || !$this->check_out || $this->nb_personnes < 1) {
            $this->total = 0.00;
            return;
        }
        
        $room = Room::with('roomType')->find($this->selectedRoomId);
        if (!$room) return;

        $days = ReservationCalculator::getDaysBetween($this->check_in, $this->check_out);
        
        // IMPORTANT: Ici, on doit utiliser la logique de calcul du service,
        // mais en supposant un coût fixe de lit d'appoint, car on n'a pas le composant pour le cocher.
        // Pour la simplicité, on utilise une logique codée en dur ici si vous n'avez pas le champ sur ce composant
        $extraBedCost = $this->lit_dappoint ? 59000.00: 0.00; // Coût fixe à remplacer par le setting si le setting est disponible ici
        
        $this->total = ($room->roomType->base_price ?? 0) * $days + ($extraBedCost * $days);
        $this->total = number_format($this->total, 2, '.', '');
    }

    public function calculateTotal()
    {
        if (!$this->selectedRoomId || !$this->check_in || !$this->check_out || $this->nb_personnes < 1) {
            $this->total = 0.00;
            return;
        }
        
        $room = Room::with('roomType')->find($this->selectedRoomId);
        if (!$room) {
            $this->total = 0.00;
            return;
        }
        
        $days = ReservationCalculator::getDaysBetween($this->check_in, $this->check_out);
        
        // Coût du lit d'appoint (à remplacer par la logique Settings si vous voulez être dynamique)
        $extraBedCost = $this->lit_dappoint ? 59000.00 : 0.00; 
        
        $this->total = ($room->type->base_price ?? 0) * $days + ($extraBedCost * $days);
        $this->total = number_format($this->total, 2, '.', '');
    }
    
    // --- SAUVEGARDE & PAIEMENT SEMOA ---
    public function processOnlinePayment()
    {
        $this->validate();

        try {
            // 1. Création du Client (utilise firstOrCreate)
            $client = Client::firstOrCreate(
                ['email' => $this->client_email],
                [
                    'nom' => $this->client_nom,
                    'prenom' => $this->client_prenom ?? 'N/A', // Le prénom peut être optionnel
                    'telephone' => $this->client_telephone,
                ]
            );

            // 2. Création de la Réservation (Statut: En attente)
            $reservation = Reservation::create([
                'room_id' => $this->selectedRoomId,
                'client_id' => $client->id,
                'check_in' => $this->check_in,
                'check_out' => $this->check_out,
                'nb_personnes' => $this->search_nb_personnes,
                'lit_dappoint' => $this->lit_dappoint,
                'statut' => 'En attente',
                'total' => $this->total,
                'mode_reservation' => 'En ligne',
            ]);

            // 3. Initialisation du Paiement Externe (Semoa)
            $service = app(\App\Services\SemoaPaymentService::class);
            $redirectUrl = $service->processOnlinePayment($reservation->id, $this->total);

            if ($redirectUrl) {
                // Redirige l'utilisateur vers Semoa
                return $this->redirect($redirectUrl, navigate: false); 
            } else {
                $reservation->delete();
                session()->flash('error', 'Erreur critique: Le paiement n\'a pas pu être initié.');
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la réservation: ' . $e->getMessage());
            // En cas d'échec, l'utilisateur reste sur la page de recherche
        }
    }
}