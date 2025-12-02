<?php

namespace App\Livewire\Comptabilite;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\DiversServiceVente;
use Carbon\Carbon;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriqueComptable extends Component
{
    use WithPagination;

    public $dateDebut;
    public $dateFin;
    public $search = '';
    public $typeFiltre = 'tout'; // tout, facture, paiement, reservation, vente, service, depense

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->dateDebut = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateFin = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        // Initialisation
        $invoices = $payments = $reservations = $sales = $diversServices = $expenses = collect();

        // --- FACTURES ---
        if ($this->typeFiltre === 'tout' || $this->typeFiltre === 'facture') {
            $invoices = Invoice::with(['reservation.client', 'sale.items', 'sale.reservation.client'])
                ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                ->when($this->search, fn($q) => $q->where('id', $this->search))
                ->latest()
                ->paginate(8);
        }

        // --- PAIEMENTS ---
        if ($this->typeFiltre === 'tout' || $this->typeFiltre === 'paiement') {
            $payments = Payment::with(['reservation.client', 'sale.items', 'diversServiceVente', 'user'])
                ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                ->when($this->search, function ($q) {
                    $q->where('id', $this->search)
                      ->orWhere('mode_paiement', 'like', "%{$this->search}%")
                      ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"))
                      ->orWhereHas('reservation.client', fn($c) => $c->where('nom', 'like', "%{$this->search}%"));
                })
                ->latest()
                ->paginate(8);
        }

        // --- RÉSERVATIONS ---
        if ($this->typeFiltre === 'tout' || $this->typeFiltre === 'reservation') {
            $reservations = Reservation::with(['client', 'items.room.roomType', 'invoice'])
                ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                ->when($this->search, fn($q) =>
                    $q->whereHas('client', fn($c) => $c->where('nom', 'like', "%{$this->search}%"))
                )
                ->latest()
                ->get();
        }

        // --- VENTES RESTAURANT ---
        if ($this->typeFiltre === 'tout' || $this->typeFiltre === 'vente') {
            $sales = Sale::with(['reservation.client', 'items.menu', 'invoice'])
                ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                ->when($this->search, fn($q) =>
                    $q->where('id', $this->search)
                      ->orWhereHas('reservation.client', fn($c) => $c->where('nom', 'like', "%{$this->search}%"))
                )
                ->latest()
                ->get();
        }

        // --- VENTES DE SERVICES DIVERS ---
        if ($this->typeFiltre === 'tout' || $this->typeFiltre === 'service') {
            $diversServices = DiversServiceVente::with(['user'])
                ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                ->when($this->search, fn($q) =>
                    $q->where('nom_service', 'like', "%{$this->search}%")
                      ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"))
                )
                ->latest()
                ->get();
        }

        // --- DÉPENSES ---
        if ($this->typeFiltre === 'tout' || $this->typeFiltre === 'depense') {
            $expenses = Expense::with('user')
                ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
                ->when($this->search, fn($q) =>
                    $q->where('libelle', 'like', "%{$this->search}%")
                      ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"))
                )
                ->latest()
                ->paginate(8);
        }

        return view('livewire.comptabilite.historique-comptable', compact(
            'invoices', 'payments', 'reservations', 'sales', 'diversServices', 'expenses'
        ));
    }

    /**
     * Exporter l'historique complet en PDF
     */
    public function exportPdf()
    {
        $invoices = Invoice::with(['reservation.client', 'sale.items', 'sale.reservation.client'])
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->when($this->search, fn($q) => $q->where('id', $this->search))
            ->latest()
            ->get();

        $payments = Payment::with(['reservation.client', 'sale.items', 'diversServiceVente', 'user'])
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->when($this->search, fn($q) => $q->where('id', $this->search))
            ->latest()
            ->get();

        $reservations = Reservation::with(['client', 'items.room.roomType', 'invoice'])
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->when($this->search, fn($q) =>
                $q->whereHas('client', fn($c) => $c->where('nom', 'like', "%{$this->search}%"))
            )
            ->latest()
            ->get();

        $sales = Sale::with(['reservation.client', 'items.menu', 'invoice'])
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->when($this->search, fn($q) =>
                $q->where('id', $this->search)
                ->orWhereHas('reservation.client', fn($c) => $c->where('nom', 'like', "%{$this->search}%"))
            )
            ->latest()
            ->get();

        $diversServices = DiversServiceVente::with(['user'])
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->when($this->search, fn($q) =>
                $q->where('nom_service', 'like', "%{$this->search}%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"))
            )
            ->latest()
            ->get();

        $expenses = Expense::with('user')
            ->whereBetween('created_at', [$this->dateDebut, $this->dateFin])
            ->when($this->search, fn($q) =>
                $q->where('libelle', 'like', "%{$this->search}%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"))
            )
            ->latest()
            ->get();

        // 🔥 Correction → on ajoute dateDebut et dateFin à la vue PDF
        $pdf = Pdf::loadView('livewire.comptabilite.historique-comptable-pdf', [
            'invoices'       => $invoices,
            'payments'       => $payments,
            'reservations'   => $reservations,
            'sales'          => $sales,
            'diversServices' => $diversServices,
            'expenses'       => $expenses,
            'dateDebut'      => $this->dateDebut,
            'dateFin'        => $this->dateFin,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'historique_comptable_' . now()->format('Y-m-d_H-i') . '.pdf'
        );
    }

}
