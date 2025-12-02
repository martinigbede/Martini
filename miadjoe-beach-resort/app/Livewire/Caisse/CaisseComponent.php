<?php

namespace App\Livewire\Caisse;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use App\Models\DiversServiceVente;
use App\Models\Reservation;
use App\Models\Invoice;
use App\Models\Expense;

class CaisseComponent extends Component
{
    use WithPagination;

    public $showModal = false;

    public $selectedVenteId;
    public $selectedVenteType;
    public $paymentAmount = 0;
    public $paymentMode = '💵 Espèces';

    // 🔹 Recherche en temps réel
    public $searchService = '';
    public $searchResto = '';
    public $searchReservation = '';

    // 🔹 KPI
    public $totalService = 0;
    public $totalResto = 0;
    public $totalReservation = 0;
    public $totalDepenses = 0;
    public $totalNet = 0;

    protected $listeners = [
        'paymentCompleted' => 'refreshVentes',
        'refresh-data' => '$refresh'
    ];

    // Reset pagination on search
    public function updatingSearchService()
    {
        $this->resetPage('servicesPage');
    }

    public function updatingSearchResto()
    {
        $this->resetPage('restoPage');
    }

    public function updatingSearchReservation()
    {
        $this->resetPage('reservationPage');
    }

    public function mount()
    {
        $this->calculerTotaux();
    }

    /**
     * Calcul des totaux KPI
     */
    public function calculerTotaux()
    {
        // Total encaissé sur les services (montant_final payé)
        $this->totalService = Invoice::whereNotNull('divers_service_vente_id')->sum('montant_final');

        // Total encaissé sur les ventes resto sans réservation
        $this->totalResto = Invoice::whereHas('sale', function ($q) {
            $q->whereNull('reservation_id');
        })->sum('montant_final');

        // Total encaissé sur les réservations
        $this->totalReservation = Invoice::whereNotNull('reservation_id')->sum('montant_final');

        // 🔹 Total des dépenses validées
        $this->totalDepenses = Expense::where('statut', 'validée')->sum('montant');
    }

    /**
     * Ouvrir modal paiement
     */
    public function ouvrirModal($type, $id)
    {
        switch ($type) {

            case 'service':   // Divers services
                $this->dispatch('openDiversPaymentModal', $id);
                break;

            case 'resto':     // Ventes Restaurant
            case 'sale':      // (au cas où tu utilises les deux)
                $this->dispatch('openPaymentModal', $id);
                break;

            case 'reservation':  // Paiement des réservations
                $this->dispatch('openReservationPaymentModal', $id);
                break;

            default:
                session()->flash('error', 'Type de modal inconnu : '.$type);
                break;
        }
    }

    /**
     * Rafraichir ventes et totaux après paiement
     */
    public function refreshVentes()
    {
        $this->calculerTotaux();
    }

    public function render()
    {
        $services = DiversServiceVente::with('invoice')
            ->where('id', 'like', '%'.$this->searchService.'%')
            ->latest()
            ->paginate(8, ['*'], 'servicesPage');

        $resto = Sale::with('items', 'reservation.client', 'invoice')
            ->where('id', 'like', '%'.$this->searchResto.'%')
            ->latest()
            ->paginate(8, ['*'], 'restoPage');

        $reservations = Reservation::with('invoice', 'client', 'rooms')
            ->where('id', 'like', '%'.$this->searchReservation.'%')
            ->latest()
            ->paginate(8, ['*'], 'reservationPage');

        return view('livewire.caisse.caisse-component', [
            'ventes' => [
                'services' => $services,
                'resto' => $resto,
                'reservations' => $reservations,
            ],
        ]);
    }

}
