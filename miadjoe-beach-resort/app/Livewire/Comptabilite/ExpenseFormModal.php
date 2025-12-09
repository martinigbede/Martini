<?php

namespace App\Livewire\Comptabilite;

use Livewire\Component;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseFormModal extends Component
{
    public $expenseId;
    public $categorie = '';
    public $categorie_autre = ''; 
    public $description = '';
    public $montant = '';
    public $date_depense;
    public $mode_paiement = 'Espèces';
    public $statut = 'en attente';
    public $showModal = true;

    // ✅ Liste des catégories proposées
    public $categories = [
        'Fournitures',
        'Maintenance',
        'Transport',
        'Restauration',
        'Électricité',
        'Eau',
        'Autre',
    ];

    protected $listeners = ['openExpenseFormModal' => 'loadExpense'];

    protected function rules()
    {
        return [
            'categorie' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',
            'date_depense' => 'required|date',
            'mode_paiement' => 'required|string',
            'statut' => 'required|in:en attente,validée',
        ];
    }

    public function mount($expenseId = null)
    {
        if ($expenseId) {
            $this->loadExpense($expenseId);
        }
    }

    /** ✅ Chargement pour édition **/
    public function loadExpense($id = null)
    {
        if ($id) {
            $expense = Expense::find($id);

            if ($expense) {
                $this->expenseId = $expense->id;
                $this->categorie = in_array($expense->categorie, $this->categories)
                    ? $expense->categorie
                    : 'Autre'; // Si la catégorie n’existe pas, on met "Autre"
                $this->categorie_autre = !in_array($expense->categorie, $this->categories)
                    ? $expense->categorie
                    : '';
                $this->description = $expense->description;
                $this->montant = $expense->montant;
                $this->date_depense = optional($expense->date_depense)->format('Y-m-d');
                $this->mode_paiement = $expense->mode_paiement;
                $this->statut = $expense->statut;
            }
        } else {
            $this->reset([
                'expenseId', 'categorie', 'categorie_autre', 'description',
                'montant', 'date_depense', 'mode_paiement', 'statut'
            ]);
            $this->mode_paiement = 'Espèces';
            $this->statut = 'en attente';
        }

        $this->showModal = true;
    }

    /** ✅ Sauvegarde et fermeture automatique **/
    public function save()
    {
        $validated = $this->validate();

        // Si la catégorie choisie est "Autre", on prend la valeur saisie
        $categorieFinale = $this->categorie === 'Autre'
            ? trim($this->categorie_autre)
            : $this->categorie;

        Expense::updateOrCreate(
            ['id' => $this->expenseId],
            [
                'categorie' => $categorieFinale,
                'description' => $this->description,
                'montant' => $this->montant,
                'date_depense' => $this->date_depense,
                'mode_paiement' => $this->mode_paiement,
                'statut' => Auth::user()->hasRole('Restauration') ? 'en attente' : $this->statut,
                'user_id' => Auth::id(),
            ]
        );

        // 🔹 Mise à jour automatique de la caisse si la dépense est validée
        if ($this->statut === 'validée') {
            $caisseType = 'Restaurant'; // ou dynamique selon contexte

            $cashAccount = \App\Models\CashAccount::firstOrCreate(
                [
                    'type_caisse' => $caisseType,
                    'nom_compte' => $this->mode_paiement
                ],
                ['solde' => 0]
            );

            // Enregistrer la transaction (addTransaction gère déjà le solde)
            if ($this->statut === 'validée') {
                $cashAccount->addTransaction(
                    amount: $this->montant,
                    type: 'sortie',
                    description: "Dépense : {$categorieFinale}",
                    userId: Auth::id()
                );
            }
        }

        $this->dispatch('expenseSaved');
        $this->dispatch('closeModal');
        $this->reset();

        session()->flash('message', 'Dépense enregistrée avec succès ✅');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.comptabilite.expense-form-modal');
    }
}
