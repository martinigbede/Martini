<?php

namespace App\Livewire\Sale;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class SaleManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 4;

    public $saleIdToEdit = null;
    public $saleIdToDetail = null;

    public bool $showDeleteModal = false;
    public ?int $saleIdToDelete = null;
    public string $deletePassword = '';
    public ?string $errorDeletePassword = null;

    protected $listeners = [
        'saleSaved' => 'refreshList',
        'closeModal' => 'resetModal',
        'saleSaved' => 'refreshSales',
        'paymentSaved' => 'refreshData'
    ];


    public function refreshData()
    {
        $this->sales = Sale::with('invoice', 'reservation')->get();
    }

    public function openPaymentModal($saleId)
    {
        $this->dispatch('openPaymentModal', $saleId);
    }

    public function render()
    {
        $query = Sale::with([
            'items.menu',
            'reservation.room',
            'reservation.client',
            'invoice' // on charge la facture
        ])->latest();

        if ($this->search) {
            $query->whereHas('items.menu', fn($q) =>
                $q->where('nom', 'like', '%' . $this->search . '%')
            );
        }

        $sales = $query->paginate($this->perPage);

        // Préparer les montants calculés
        $sales->getCollection()->transform(function ($sale) {
            $invoice = $sale->invoice;

            $sale->montant_final = $invoice->montant_final ?? $sale->total;
            $sale->montant_paye = $invoice->montant_paye ?? 0;
            $sale->reste_a_payer = max(0, $sale->montant_final - $sale->montant_paye);
            $sale->statut_facture = $invoice->statut ?? 'En attente';

            return $sale;
        });

        return view('livewire.sale.sale-management', [
            'sales' => $sales,
        ]);
    }

    public function openModal($saleId = null)
    {
        $this->saleIdToEdit = $saleId;
        $this->dispatch('openSaleModal', saleId: $saleId);
    }

    public function openDetailModal($saleId)
    {
        $this->saleIdToDetail = $saleId;
        $this->dispatch('openSaleDetailModal', saleId: $saleId);
    }

    public function resetModal()
    {
        $this->saleIdToEdit = null;
        $this->saleIdToDetail = null;
    }

    public function refreshList()
    {
        $this->resetPage();
    }

    public function edit($saleId)
    {
        $this->openModal($saleId);
    }

    public function confirmDelete($saleId)
    {
        $this->saleIdToDelete = $saleId;
        $this->deletePassword = '';
        $this->errorDeletePassword = null;
        $this->showDeleteModal = true;
    }

    public function deleteSecure()
    {
        $settingPassword = \App\Models\Setting::getValue('delete_password');

        if (!$settingPassword || $this->deletePassword !== $settingPassword) {
            $this->errorDeletePassword = "Mot de passe incorrect.";
            return;
        }

        $sale = Sale::findOrFail($this->saleIdToDelete);
        $sale->items()->delete();
        $sale->delete();

        $this->showDeleteModal = false;
        session()->flash('message', 'Vente supprimée avec succès.');

        $this->resetPage();
        $this->dispatch('saleSaved');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
