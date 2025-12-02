<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SidebarNavigation extends Component
{
    public $collapsed = false;
    public $activeMenus = [];

    public function mount()
    {
        // Récupérer l'état depuis localStorage via Alpine.js
        $this->collapsed = false; // Valeur par défaut
    }

    public function toggleSidebar()
    {
        $this->collapsed = !$this->collapsed;
        
        // Émettre un événement pour synchroniser l'état avec Alpine.js
        $this->dispatch('sidebar-toggled', collapsed: $this->collapsed);
    }

    public function toggleMenu($menuId)
    {
        if (isset($this->activeMenus[$menuId])) {
            unset($this->activeMenus[$menuId]);
        } else {
            $this->activeMenus[$menuId] = true;
        }
    }

    public function isMenuOpen($menuId)
    {
        return isset($this->activeMenus[$menuId]);
    }

    public function render()
    {
        return view('livewire.sidebar-navigation', [
            'user' => Auth::user(),
            'isDirection' => Auth::user()->hasRole('Direction'),
            'isComptable' => Auth::user()->hasRole('Comptable'),
            'isReception' => Auth::user()->hasRole('Réception'),
            'isRestauration' => Auth::user()->hasRole('Restauration'),
            'isCaisse' => Auth::user()->hasRole('Caisse'),
        ]);
    }
}