<?php

namespace App\Livewire\Sale;

use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Services\SaleCalculationService;
use Livewire\Attributes\On;

class SaleFormModal extends Component
{
    public ?int $saleId = null;
    public bool $isEditing = false;

    public ?int $reservation_id = null;
    public string $date;
    public float $total = 0;

    public array $items = [];
    public array $menus = [];
    public array $reservations = [];

    public array $unitesDisponibles = [];
    public bool $isModalOpen = false;

    protected SaleCalculationService $calculator;

    public function boot(SaleCalculationService $calculator)
    {
        $this->calculator = $calculator;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function mount()
    {
        $this->menus = Menu::with('units')->get()->toArray();
        $this->reservations = Reservation::with(['room', 'client', 'sales'])->get()->toArray();

        $this->date = now()->toDateString();
        $this->resetItems();
    }

    protected function resetItems()
    {
        $this->items = [[
            'menu_id' => '',
            'unite' => null,
            'quantite' => 1,
            'prix_unitaire' => 0,
            'total' => 0,
        ]];
    }

    #[On('openSaleModal')]
    public function openModal(?int $saleId = null)
    {
        $this->isModalOpen = true;

        if ($saleId) {
            $this->loadSale($saleId);
        } else {
            $this->resetForm();
        }
    }

    protected function loadSale(int $saleId)
    {
        $this->isEditing = true;

        $sale = Sale::with('items')->findOrFail($saleId);

        $this->saleId = $sale->id;
        $this->reservation_id = $sale->reservation_id;
        $this->date = $sale->date;

        // Charger les items
        $this->items = $sale->items->map(fn($item) => [
            'menu_id' => $item->menu_id,
            'unite' => $item->unite,
            'quantite' => $item->quantite,
            'prix_unitaire' => $item->prix_unitaire,
            'total' => $item->total,
        ])->toArray();

        // Charger les unités disponibles
        foreach ($this->items as $i => $item) {
            $this->loadUnitesForMenu($i);
        }

        $this->calculateTotal();
    }

    protected function rules()
    {
        return [
            'reservation_id' => 'nullable|exists:reservations,id',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.unite' => 'nullable|string',
            'items.*.quantite' => 'required|integer|min:1',
            'items.*.prix_unitaire' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0.01',
            'date' => 'required|date',
        ];
    }

    public function addItem()
    {
        $this->items[] = [
            'menu_id' => '',
            'unite' => null,
            'quantite' => 1,
            'prix_unitaire' => 0,
            'total' => 0,
        ];
    }

    public function removeItem(int $index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);

        if (count($parts) === 2 && $parts[1] === 'menu_id') {
            $this->loadUnitesForMenu((int) $parts[0]);
        }

        $this->calculateTotal();
    }

    protected function loadUnitesForMenu(int $index)
    {
        $menuId = $this->items[$index]['menu_id'] ?? null;

        if ($menuId) {
            $menu = Menu::with('units')->find($menuId);

            $this->unitesDisponibles[$menuId] = $menu && $menu->units->count() > 0
                ? $menu->units->pluck('unit')->toArray()
                : [];
        }
    }

    public function calculateTotal()
    {
        $this->total = 0;

        foreach ($this->items as &$item) {
            if (!$item['menu_id']) continue;

            $menu = Menu::with('units')->find($item['menu_id']);
            if (!$menu) continue;

            $prixUnitaire = $menu->prix;

            if (!empty($item['unite'])) {
                $unit = $menu->units->firstWhere('unit', $item['unite']);
                if ($unit) {
                    $prixUnitaire = $unit->price;
                }
            }

            $item['prix_unitaire'] = $prixUnitaire;
            $item['total'] = round($item['quantite'] * $prixUnitaire, 2);

            $this->total += $item['total'];
        }
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 🔷 Création / Mise à jour vente
            $sale = Sale::updateOrCreate(
                ['id' => $this->saleId],
                [
                    'reservation_id' => $this->reservation_id,
                    'date' => $this->date,
                    'total' => $this->total,
                ]
            );

            if ($this->isEditing) {
                $sale->items()->delete();
            }

            foreach ($this->items as $item) {
                $sale->items()->create([
                    'menu_id' => $item['menu_id'],
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix_unitaire'],
                    'total' => $item['total'],
                    'unite' => $item['unite'] ?? null,
                ]);
            }

            // 🔷 Calcul du montant total de TOUTES les ventes liées à la réservation
            $reservation = $this->reservation_id ? Reservation::find($this->reservation_id) : null;
            $totalVentesReservation = 0;

            if ($reservation) {

                // Cas vente liée à une réservation
                $totalVentesReservation = $reservation->sales()->sum('total');

                $this->calculator->handleInvoiceAndPayment(
                    $reservation,
                    $sale,
                    $totalVentesReservation,
                    null,
                    'Espèces'
                );

                $reservation->recalculerTotal();

            } else {

                // Cas vente libre → montant = total de la vente
                $this->calculator->handleInvoiceAndPayment(
                    null,
                    $sale,
                    $sale->total,   // ✔ montant correct pour vente libre
                    null,
                    'Espèces'
                );
            }
        });

        session()->flash('message', $this->isEditing ? 'Vente mise à jour.' : 'Vente enregistrée.');

        $this->resetForm();
        $this->dispatch('saleSaved');
        $this->isModalOpen = false;
    }

    protected function resetForm()
    {
        $this->saleId = null;
        $this->reservation_id = null;
        $this->isEditing = false;
        $this->resetItems();
        $this->total = 0;
        $this->date = now()->toDateString();
        $this->unitesDisponibles = [];
    }

    public function render()
    {
        return view('livewire.sale.sale-form-modal');
    }
}
