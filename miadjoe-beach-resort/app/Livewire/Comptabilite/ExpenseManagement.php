<?php

namespace App\Livewire\Comptabilite;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Expense;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseManagement extends Component
{
    use WithPagination;

    // --- Filtres et recherche ---
    public $search = '';
    public $filterCategorie = '';
    public $filterStatut = '';
    public $startDate = null;
    public $endDate = null;

    // --- Modal principal ---
    public $showModal = false;
    public $selectedExpenseId = null;

    // --- Modal suppression sécurisée ---
    public $showDeleteModal = false;
    public $deleteExpenseId = null;
    public $deletePassword = '';
    public $errorDeletePassword = null;

    protected $listeners = [
        'expenseSaved' => 'closeModal',
        'closeModal'   => 'closeModal'
    ];

    public function closeModal()
    {
        $this->showModal = false;
    }

    // --- Recherche et filtres ---
    public function updatingSearch()         { $this->resetPage(); }
    public function updatingFilterCategorie(){ $this->resetPage(); }
    public function updatingFilterStatut()   { $this->resetPage(); }

    public function refreshList()            { $this->resetPage(); }

    // --- Ouvrir formulaire d'ajout / édition ---
    public function openModal($id = null)
    {
        $this->selectedExpenseId = $id;
        $this->showModal = true;

        $this->dispatch('openExpenseFormModal', id: $id);
    }

    // --- Ouvrir le modal sécurisé de suppression ---
    public function confirmDeleteExpense($id)
    {
        $this->deleteExpenseId = $id;
        $this->deletePassword = '';
        $this->errorDeletePassword = null;
        $this->showDeleteModal = true;
    }

    // --- Suppression avec password ---
    public function deleteExpenseSecure()
    {
        $settingPassword = Setting::getValue('delete_password');

        if (!$settingPassword || $this->deletePassword !== $settingPassword) {
            $this->errorDeletePassword = "Mot de passe incorrect.";
            return;
        }

        Expense::findOrFail($this->deleteExpenseId)->delete();

        $this->showDeleteModal = false;
        session()->flash('message', 'Dépense supprimée avec succès.');
        $this->refreshList();
    }

    // --- Liste des dépenses ---
    public function getExpensesProperty()
    {
        return Expense::query()
            ->when($this->filterStatut, fn($q) => $q->where('statut', $this->filterStatut))
            ->when($this->startDate && $this->endDate, fn($q) =>
                $q->whereBetween('date_depense', [$this->startDate, $this->endDate])
            )
            ->latest()
            ->paginate(10);
    }

    // --- Export PDF corrigé ---
    public function exportPdf()
    {
        $query = Expense::query()
            ->when($this->filterStatut, fn($q) => $q->where('statut', $this->filterStatut))
            ->when($this->startDate && $this->endDate, fn($q) =>
                $q->whereBetween('date_depense', [$this->startDate, $this->endDate])
            )
            ->latest()
            ->get();

        // --- Calcul du total des dépenses ---
        $totalExpenses = $query->sum('montant');

        $pdf = Pdf::loadView('livewire.comptabilite.expense-report-pdf', [
            'expenses' => $query,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'statut' => $this->filterStatut,
            'totalExpenses' => $totalExpenses, // <-- ajouté
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'rapport_depenses_'.now()->format('Y-m-d_H-i').'.pdf'
        );
    }

    public function render()
    {
        return view('livewire.comptabilite.expense-management', [
            'expenses' => $this->expenses,
        ]);
    }
}
