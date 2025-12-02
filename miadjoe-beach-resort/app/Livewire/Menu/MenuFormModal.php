<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Menu;
use App\Models\MenuCategory;

class MenuFormModal extends Component
{
    use WithFileUploads;

    public $menuId;
    public $name;
    public $price;
    public $available = true;
    public $category_id;
    public $photo;
    public $newPhoto;
    public $isModalOpen = false;

    protected $listeners = ['openMenuModal' => 'openModal'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:menu_categories,id',
            'newPhoto' => 'nullable|image|max:2048',
        ];
    }

    public function openModal($menuId = null)
    {
        $this->resetValidation();
        $this->resetForm();

        if ($menuId) {
            $menu = Menu::findOrFail($menuId);
            $this->menuId = $menu->id;
            $this->name = $menu->name;
            $this->price = $menu->price;
            $this->available = $menu->available;
            $this->category_id = $menu->category_id;
            $this->photo = $menu->photo;
        }

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $menu = $this->menuId ? Menu::findOrFail($this->menuId) : new Menu();

        $menu->fill([
            'name' => $this->name,
            'price' => $this->price,
            'available' => $this->available,
            'category_id' => $this->category_id,
        ]);

        if ($this->newPhoto) {
            $menu->photo = $this->newPhoto->store('menus', 'public');
        }

        $menu->save();

        session()->flash('message', $this->menuId ? 'Menu mis à jour.' : 'Menu créé avec succès.');

        $this->dispatch('menuSaved');
        $this->resetForm();
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->reset(['menuId', 'name', 'price', 'available', 'category_id', 'photo', 'newPhoto']);
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function render()
    {
        return view('livewire.menu-form-modal', [
            'categories' => MenuCategory::all(),
        ]);
    }
}
