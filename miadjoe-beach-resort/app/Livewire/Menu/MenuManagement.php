<?php

namespace App\Livewire\Menu;

use App\Models\Menu;
use App\Models\MenuCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MenuManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $mode = 'category'; // 'category' ou 'item'
    public $isModalOpen = false;
    public $editingId = null;

    // Catégorie
    public $cat_name;
    public $cat_description;

    // Menu
    public $item_nom;
    public $item_description;
    public $item_prix;
    public $item_disponibilite = 1;
    public $item_category_id;
    public $item_photo;
    public $item_temp_photo_path;

    // Unités de vente
    public $menu_units = [];

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $categories = MenuCategory::all();

        if ($this->mode === 'category') {
            $items = MenuCategory::orderBy('id', 'asc')->paginate(10, ['*'], 'catPage');
        } else {
            $items = Menu::with('category', 'units')->orderBy('category_id', 'asc')->paginate(10, ['*'], 'itemPage');
        }

        return view('livewire.menu.menu-management', compact('items', 'categories'))->layout('layouts.app');
    }

    // --- Mode ---
    public function switchMode($newMode)
    {
        $this->mode = $newMode;
        $this->resetPage();
        $this->closeModal();
    }

    // --- Modal ---
    public function openModal($id = null)
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->editingId = $id;

        if ($id) {
            if ($this->mode === 'category') {
                $cat = MenuCategory::findOrFail($id);
                $this->cat_name = $cat->name;
                $this->cat_description = $cat->description;
            } else {
                $item = Menu::with('units')->findOrFail($id);
                $this->item_nom = $item->nom;
                $this->item_description = $item->description;
                $this->item_prix = $item->prix;
                $this->item_disponibilite = $item->disponibilite;
                $this->item_category_id = $item->category_id;
                $this->item_temp_photo_path = $item->photo;
                $this->menu_units = $item->units->map(fn($u) => ['unit' => $u->unit, 'price' => $u->price])->toArray();
            }
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->cat_name = $this->cat_description = '';
        $this->item_nom = $this->item_description = $this->item_prix = '';
        $this->item_disponibilite = 1;
        $this->item_category_id = null;
        $this->item_photo = null;
        $this->item_temp_photo_path = null;
        $this->menu_units = [];
        $this->editingId = null;
    }

    // --- CRUD Catégorie ---
    public function storeCategory()
    {
        $this->validate([
            'cat_name' => 'required|string|max:100|unique:menu_categories,name,' . ($this->editingId ?: 'NULL,id'),
            'cat_description' => 'nullable|string',
        ]);

        MenuCategory::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->cat_name, 'description' => $this->cat_description]
        );

        session()->flash('message', $this->editingId ? 'Catégorie mise à jour.' : 'Catégorie créée.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $cat = MenuCategory::findOrFail($id);

        foreach ($cat->menus as $menu) {
            if ($menu->photo && Storage::disk('public')->exists($menu->photo)) {
                Storage::disk('public')->delete($menu->photo);
            }
            $menu->units()->delete();
            $menu->delete();
        }

        $cat->delete();
        session()->flash('message', 'Catégorie et ses menus supprimés.');
    }

    // --- CRUD Menu ---
    public function storeItem()
    {
        $validated = $this->validate([
            'item_nom' => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'item_prix' => 'nullable|numeric|min:0',
            'item_disponibilite' => 'required|boolean',
            'item_category_id' => 'required|integer|exists:menu_categories,id',
            'item_photo' => 'nullable|image|max:2048',
        ]);

        if ($this->item_photo) {
            $path = $this->item_photo->store('menus', 'public');
            $validated['photo'] = $path;
        }

        $menu = Menu::updateOrCreate(
            ['id' => $this->editingId],
            [
                'nom' => $validated['item_nom'],
                'description' => $validated['item_description'] ?? null,
                'prix' => $validated['item_prix'] ?? 0,
                'disponibilite' => $validated['item_disponibilite'],
                'category_id' => $validated['item_category_id'],
                'photo' => $validated['photo'] ?? $this->item_temp_photo_path,
            ]
        );

        // Unités
        $menu->units()->delete();
        foreach ($this->menu_units as $unit) {
            if (!empty($unit['unit']) && isset($unit['price'])) {
                $menu->units()->create([
                    'unit' => $unit['unit'],
                    'price' => $unit['price'],
                ]);
            }
        }

        session()->flash('message', $this->editingId ? 'Menu mis à jour.' : 'Menu créé.');
        $this->closeModal();
    }

    public function deleteItem($id)
    {
        $item = Menu::findOrFail($id);

        if ($item->photo && Storage::disk('public')->exists($item->photo)) {
            Storage::disk('public')->delete($item->photo);
        }

        $item->units()->delete();
        $item->delete();
        session()->flash('message', 'Menu supprimé.');
    }

    // --- Unités dynamiques ---
    public function addUnit()
    {
        $this->menu_units[] = ['unit' => '', 'price' => 0];
    }

    public function removeUnit($index)
    {
        unset($this->menu_units[$index]);
        $this->menu_units = array_values($this->menu_units);
    }
}
