<?php

namespace App\Livewire\Accounting;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AccountingDashboard extends Component
{
    use WithPagination;

    // Filtres de Période
    public $dateRange = 'month'; // Jour, week, month, year
    public $startDate;
    public $endDate;

    // Données Agrégées
    public $totalEntries = 0.00;
    public $totalExits = 0.00;
    public $netProfit = 0.00;
    
    // Listeners pour rafraîchir après une transaction (Vente ou Ajout Manuel)
    protected $listeners = ['refresh' => '$refresh']; 

    public function mount()
    {
        $this->setPeriodFilter($this->dateRange);
    }

    // Met à jour les dates en fonction du filtre sélectionné
    public function setPeriodFilter($range)
    {
        $this->dateRange = $range;
        $now = Carbon::now();
        
        switch ($range) {
            case 'day':
                $this->startDate = $now->toDateString();
                $this->endDate = $now->toDateString();
                break;
            case 'week':
                $this->startDate = $now->startOfWeek()->toDateString();
                $this->endDate = $now->endOfWeek()->toDateString();
                break;
            case 'month':
                $this->startDate = $now->startOfMonth()->toDateString();
                $this->endDate = $now->endOfMonth()->toDateString();
                break;
            case 'year':
                $this->startDate = $now->startOfYear()->toDateString();
                $this->endDate = $now->endOfYear()->toDateString();
                break;
            default:
                $this->startDate = $now->startOfMonth()->toDateString();
                $this->endDate = $now->endOfMonth()->toDateString();
                break;
        }
        $this->calculateAggregates();
    }

    // Calcul des totaux
    public function calculateAggregates()
    {
        // 1. Transactions Manuelles
        $transactions = Transaction::whereBetween('date', [$this->startDate, $this->endDate]);
        
        $this->totalEntries = $transactions->where('type', 'Entrée')->sum('montant');
        $this->totalExits = $transactions->where('type', 'Sortie')->sum('montant');
        
        // 2. Paiements de Réservations (qui sont des Entrées)
        $payments = Payment::where('statut', 'Payé')
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate)
            ->sum('montant');
            
        // Total Entrées = Transactions manuelles + Paiements de Réservations validés
        $this->totalEntries += $payments;

        $this->netProfit = $this->totalEntries - $this->totalExits;
        
        // Important: ceci déclenche le rendu pour mettre à jour l'affichage
        $this->dispatch('refresh'); 
    }
    
    // Méthode pour l'export PDF (Placeholder)
    public function exportPdf()
    {
        // Logique pour générer un PDF (nécessite une librairie comme barryvdh/laravel-dompdf)
        session()->flash('message', 'Tentative d\'export PDF. (Logique à implémenter)');
    }

    // Méthode pour l'export Excel (Placeholder)
    public function exportExcel()
    {
        // Logique pour générer un fichier Excel (nécessite laravel-excel)
        session()->flash('message', 'Tentative d\'export Excel. (Logique à implémenter)');
    }

    public function render()
    {
        // Le refreshList écoutera ici pour recharger les données après une transaction
        
        return view('livewire.accounting.accounting-dashboard');
    }
}