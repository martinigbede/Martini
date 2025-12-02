<?php

namespace App\Livewire\Menu;

use App\Models\Menu;
use App\Models\MenuCategory; // table des catégories
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class PublicMenuDisplay extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $perPage = 6;

    public function render()
    {
        $query = Menu::query()
            ->where('disponibilite', true); // Afficher seulement les plats disponibles

        if ($this->search) {
            $query->where('nom', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        // Utilisation du cache pour optimiser les lectures publiques
        $menus = Cache::remember('public_menu_' . md5($this->search . $this->categoryFilter . $this->perPage), now()->addHour(), function () use ($query) {
            return $query->latest()->paginate($this->perPage);
        });

        // 🔹 Correction : récupération des catégories depuis la table MenuCategory
        $categories = MenuCategory::pluck('name', 'id');

        return view('livewire.menu.public-menu-display', [
            'menus' => $menus,
            'categories' => $categories,
        ])->layout('layouts.guest'); // Layout public
    }
}
