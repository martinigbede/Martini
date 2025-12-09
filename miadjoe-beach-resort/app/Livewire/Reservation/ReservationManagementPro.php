<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;
use App\Models\Client;
use Illuminate\Support\Facades\DB;


class ReservationManagementPro extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showFormModal = false;
    public $editingReservationId = null;
    public $stats;

    // Nouveau pour le modal de paiement/prolongation
    public $showPaymentModal = false;
    public $paymentReservationId = null;

    // Nouveau pour le modal détails/facture
    public $showDetailsModal = false;
    public $detailsReservationId = null;

    // Nouveau pour le modal de suppression
    public $showDeleteModal = false;
    public $deletePassword = '';
    public $deleteReservationId = null;
    public $errorDeletePassword = null;

    // Nouveau pour le modal de notification client
    public $showNotifyModal = false;
    public $notifyReservationId = null;
    protected $poll = 5000; // rafraîchit toutes les 5 secondes  

    protected $listeners = [
        'reservationSaved' => 'refreshList',
        'reservationUpdated' => 'refreshList', // pour écouter après règlement/prolongation
        'closeFormModal' => 'closeFormModal',
        'closeNotifyModal' => 'closeNotifyModal', 
        'refresh-data' => '$refresh',
        'refreshPaymentModal' => '$refresh',
        'refreshReservationDetails' => '$refresh',
        
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function refreshList()
    {
        $this->resetPage();
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total' => Reservation::count(),
            'today' => Reservation::whereDate('created_at', today())->count(),
            'confirmed' => Reservation::where('statut', 'confirmée')->count(),
            'pending' => Reservation::where('statut', 'en_attente')->count(),
            'revenue' => Reservation::where('statut', 'confirmée')->sum('total')
        ];
    }

    public function refreshData()
    {
        $this->loadStats();
        $this->dispatchBrowserEvent('data-refreshed');
    }

    public function openFormModal($reservationId = null)
    {
        $this->editingReservationId = $reservationId;
        $this->showFormModal = true;
    }


    // Ouvrir le modal détails
    public function openDetailsModal($reservationId)
    {
        $this->detailsReservationId = $reservationId;
        $this->showDetailsModal = true;
    }

    public function closeFormModal()
    {
        $this->showFormModal = false; 
    }

    public function closeNotifyModal()
    {
        $this->showNotifyModal = false;
        $this->notifyReservationId = null;
    }

    public function openNotifyModal($reservationId)
    {
        $this->notifyReservationId = $reservationId;
        $this->showNotifyModal = true;
    }

    // --- NOUVEAU ---
    public function openPaymentModal($reservationId)
    {
        $this->paymentReservationId = $reservationId;
        $this->reservation = Reservation::with('invoice', 'payments', 'rooms', 'client')
            ->findOrFail($reservationId);

        $this->totalInvoice = $this->reservation->invoice->montant_final ?? 0;
        $this->alreadyPaid = $this->reservation->invoice->montant_paye ?? 0;
        $this->remaining = max(0, $this->totalInvoice - $this->alreadyPaid);
        $this->showPaymentModal = true;
    }

    public function confirmDelete($id)
    {
        $this->deleteReservationId = $id;
        $this->showDeleteModal = true;
        $this->deletePassword = '';
        $this->errorDeletePassword = null;
    }

    public function deleteReservationSecure()
    {
        $settingPassword = \App\Models\Setting::getValue('delete_password');

        if (!$settingPassword || $this->deletePassword !== $settingPassword) {
            $this->errorDeletePassword = "Mot de passe incorrect.";
            return;
        }

        Reservation::findOrFail($this->deleteReservationId)->delete();

        $this->showDeleteModal = false;
        $this->dispatch('reservationUpdated');
        session()->flash('message', 'Réservation supprimée avec succès.');
    }

    public function deleteReservation($id)
    {
        Reservation::findOrFail($id)->delete();
        session()->flash('success', 'Réservation supprimée avec succès.');
    }

    public function getReservationsProperty()
    {
        return Reservation::query()
            ->with('client', 'sales', 'rooms', 'invoice')
            ->when($this->search, function ($query) {
                $query->whereHas('client', function ($q) {
                    $q->where('nom', 'like', "%{$this->search}%")
                    ->orWhere('prenom', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('statut', $this->statusFilter))
            ->latest()
            ->paginate(4)
            ->through(function ($reservation) {
                $invoice = $reservation->invoice;
                $paidAmount = $invoice->montant_paye ?? 0;
                $finalAmount = $invoice->montant_final ?? $reservation->total;

                return [
                    'id' => $reservation->id,
                    'client_nom' => $reservation->client->nom ?? '-',
                    'client_prenom' => $reservation->client->prenom ?? '-',
                    'rooms' => $reservation->rooms->pluck('numero')->toArray(),
                    'check_in' => $reservation->check_in,
                    'check_out' => $reservation->check_out,

                    // Montant à afficher
                    'total' => $finalAmount,          // montant final réel
                    'paye' => $paidAmount,            // payé réel
                    'a_payer' => max(0, $finalAmount - $paidAmount),

                    'statut' => $reservation->statut,
                ];
            });
        
    }

    public function render()
    {
        // Rafraîchissement automatique toutes les 10 secondes
       // $this->dispatchBrowserEvent('refresh-stats');

        return view('livewire.reservation.reservation-management-pro', [
            'reservations' => $this->reservations,
            'paymentReservationId' => $this->paymentReservationId, // passer l'ID au modal
            'detailsReservationId' => $this->detailsReservationId, // 
        ]);
    }
}
