<?php
namespace App\Livewire\Public;
use App\Models\MenuCategory;
use Livewire\Component;

class MenuDisplay extends Component
{
    public function render()
    {
        // Charger les catégories avec leurs menus actifs
        $categories = MenuCategory::whereHas('menus', function($query) {
            $query->where('status', 'active');
        })->with(['menus' => function($query) {
            $query->where('status', 'active')->orderBy('price', 'asc');
        }])->orderBy('id', 'asc')->get();

        return view('livewire.public.menu-display', compact('categories'));
    }
}