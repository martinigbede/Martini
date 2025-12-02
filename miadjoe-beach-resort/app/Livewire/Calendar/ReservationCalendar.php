<?php

namespace App\Livewire\Calendar;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;
use Livewire\Attributes\On; 

class ReservationCalendar extends Component
{
    // Contrôles de navigation (Adapté à l'affichage mensuel/hebdomadaire hybride)
    public $currentDate; // Utilisé pour la navigation, démarrera sur le Lundi de la semaine en cours
    public $currentYear;
    public $currentMonth;
    public $monthName;
    public $daysInMonth; 
    public $daysInWeek = 7;

    // Contrôles de filtre
    public $selectedRoomTypeId = null;
    public $roomsData = []; 

    // --- PROPRIÉTÉS AJOUTÉES POUR LA MODALE DE DÉTAILS ---
    public $showDetailsModal = false;
    public $detailModalId = null;
    
    // Données chargées
    protected $reservations;

    // Écoute les mises à jour du CRUD de réservation
    protected $listeners = [
        
        'refreshList' => 'loadData',
        'refresh' => '$refresh',
        'openDetailsFromCalendar' => 'openDetailsModal' // NOUVEAU LISTENER
    
    ]; 

    // Initialisation
    public function mount()
    {
        $now = Carbon::now();
        $this->currentYear = $now->year;
        $this->currentMonth = $now->month;
        $this->currentDate = Carbon::now()->startOfWeek(); // Commence sur la semaine en cours (Lundi)
        $this->loadData(); 
    }

    // Charge les données de base (Types de Chambres, Réservations, Structure)
    public function loadData()
    {
        // 1. Configuration du mois/semaine pour l'affichage
        $this->calculateCalendarLayout();

        // 2. Chargement des réservations pour la PÉRIODE D'AFFICHAGE (Semaine courante basée sur $currentDate)
        $startOfWeek = $this->currentDate->copy()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->addDays($this->daysInWeek - 1)->endOfDay();
        
        $this->reservations = Reservation::where(function($query) use ($startOfWeek, $endOfWeek) {
            $query->where('check_in', '<', $endOfWeek)
                  ->where('check_out', '>', $startOfWeek)
                  ->where('statut', '!=', 'Annulée'); 
        })
        ->with(['client', 'room.roomType'])
        ->get();
            
        // 3. Structure des données pour l'affichage Grille
        $this->structureGridData();
    }

    // --- Contrôles de Navigation (Adaptés à la structure de la vue fournie) ---

    public function goToPreviousMonth()
    {
        $prev = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentYear = $prev->year;
        $this->currentMonth = $prev->month;
        $this->loadData();
    }

    public function goToNextMonth()
    {
        $next = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentYear = $next->year;
        $this->currentMonth = $next->month;
        $this->loadData();
    }

    public function goToWeekStart()
    {
        $this->currentDate = Carbon::now()->startOfWeek();
        $this->loadData();
    }
    
    public function calculateCalendarLayout()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $this->monthName = $date->format('F Y'); 
        $this->daysInMonth = $date->daysInMonth;
    }
    
    // --- STRUCTURE ET AFFICHAGE ---

    protected function structureGridData()
    {
        $this->roomsData = [];

        $allRoomTypes = RoomType::with('rooms')->get()->keyBy('id');
        $allRooms = Room::with(['roomType'])->get(); 

        // Filtrage par type d'onglet
        $roomsToDisplay = $allRooms->filter(function($room) {
            if (!$this->selectedRoomTypeId) {
                return true;
            }
            return $room->room_type_id == $this->selectedRoomTypeId;
        });

        // Grouper les chambres par type pour l'affichage des en-têtes
        $groupedRooms = $roomsToDisplay->groupBy('room_type_id');

        foreach ($allRoomTypes as $typeId => $type) {
            // Ligne header pour le type
            $this->roomsData[$typeId . '_header'] = [
                'is_type_header' => true,
                'type_name' => $type->nom,
            ];

            if ($groupedRooms->has($typeId)) {
                foreach ($groupedRooms->get($typeId) as $room) {
                    $this->roomsData[$room->id] = [
                        'is_type_header' => false,
                        'room_id' => $room->id,
                        'room_number' => $room->numero,
                        'status' => $room->status,
                        'type_name' => $room->roomType->nom ?? 'N/A', // <-- AJOUTER CECI pour les chambres
                        'days' => $this->generateDayStatusForRoom($room),
                    ];
                }
            }
        }
    }

    // Calcule le statut de la cellule pour chaque jour de la grille
    protected function generateDayStatusForRoom(\App\Models\Room $room): array
    {
        $dailyStatus = [];
        $baseStatus = $room->status; // Statut de la chambre (Maintenance, Libre...)
        $roomReservations = $this->reservations->where('room_id', $room->id);

        // *** MODIFICATION ICI : Utiliser la boucle du MOIS complet ***
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth);

        foreach ($period as $date) {
            $dateString = $date->toDateString();
            
            $dayData = [
                'status' => $baseStatus, 
                'is_reservation' => false,
                'reservation_details' => null,
                'is_checkin' => false,
                'is_checkout' => false,
                'color' => 'bg-white', // Couleur de fond par défaut (si la chambre n'est pas en Maintenance)
            ];

            $resForDay = $roomReservations->first(function($res) use ($date, $dateString) {
                $checkIn = Carbon::parse($res->check_in);
                $checkOut = Carbon::parse($res->check_out);
                
                // Occupé si le jour est >= CheckIn ET < CheckOut (Départ est le jour suivant l'occupation)
                if ($date->isSameDay($checkOut)) {
                    // Jour de départ - Traité séparément dans la vue pour la couleur
                    return true;
                }
                return $date->gte($checkIn) && $date->lt($checkOut);
            });

            if ($resForDay) {
                $dayData['status'] = $resForDay->statut; // Statut de la Réservation
                $dayData['is_reservation'] = true;
                $dayData['reservation_details'] = $resForDay;

                $dayData['is_checkin'] = $date->isSameDay(Carbon::parse($resForDay->check_in));
                $dayData['is_checkout'] = $date->isSameDay(Carbon::parse($resForDay->check_out));
                $dayData['color'] = $this->getReservationColor($resForDay, $dateString);
            } elseif ($baseStatus !== 'Libre') {
                 // Si la chambre est en Maintenance ou Nettoyage (statut de la chambre)
                 $dayData['color'] = 'bg-red-100'; 
            }

            $dailyStatus[$dateString] = $dayData;
        }

        return $dailyStatus;
    }
    
    // Logique de couleur basée sur le statut de la RÉSERVATION
    protected function getReservationColor($reservation, $dateString)
    {
        switch ($reservation->statut) {
            case 'Confirmée':
                if ($reservation->check_in == $dateString) return 'bg-green-400'; // Arrivée
                if ($reservation->check_out == $dateString) return 'bg-orange-400'; // Départ
                return 'bg-green-200'; // Séjour (vert clair)
            case 'En attente':
                return 'bg-blue-300'; // Brum (en attente, bleu clair)
            default:
                return 'bg-gray-500';
        }
    }

    // --- ACTIONS DE FILTRE ---
    
    public function updatedSelectedRoomTypeId()
    {
        $this->loadData();
    }
    
    // --- NOUVELLES FONCTIONNALITÉS (Interactions avec le CRUD 5) ---
    public function openDetailsModal($id)
    {
        $this->detailModalId = $id;
        $this->showDetailsModal = true;
    }

    // Déclenchée par un clic sur une case LIBRE
    /**
     * Ouvre le formulaire de réservation rapide (CRUD 5) en pré-remplissant la date.
     * @param string $dateString - La date sélectionnée (ex: '2025-10-20')
     */

    public function openQuickBookingModal($dateString)
    {
        // Émet vers le nouveau composant, et non plus vers ReservationManagement
        $this->dispatch('openQuickCreate', date: $dateString)
            ->to('reservation.reservation-quick-create-form'); // Assurez-vous que c'est le bon chemin du composant
    }


    // Déclenchée par un clic sur une réservation existante (pour voir les détails)
    /**
     * Ouvre la modale de détails de la réservation.
     * @param int $reservationId - L'ID de la réservation.
     */
    
    public function viewReservationDetails($reservationId)
    {
        $this->dispatch('showDetails', id: $reservationId);
    }

}