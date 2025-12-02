<?php

namespace App\Livewire\Public;

use App\Models\Gallery;
use Livewire\Component;
use Carbon\Carbon; // On ne l'utilise pas ici mais gardons-le si nécessaire

class GalleryDisplay extends Component
{
    public $activeFilter = 'all'; // 'all', 'photo', ou 'video'

    public function render()
    {
        $galleriesQuery = Gallery::query()
            ->where('type', '!=', 'video') // Par défaut, on se concentre sur les photos si pas de filtre vidéo
            ->whereHas('items', function($query) {
                $query->where('order_index', '>=', 0)->whereNotNull('file_path');
            });
        
        // Filtrage de base (simplifié pour l'exemple)
        if ($this->activeFilter === 'video') {
             $galleriesQuery->where('type', 'video');
        } elseif ($this->activeFilter !== 'all') {
             // Si on veut filtrer par catégorie de galerie plus tard, on le ferait ici.
             // Pour l'instant, on se fie au type 'photo'/'video' de la galerie.
             $galleriesQuery->where('type', $this->activeFilter);
        }

        $galleries = $galleriesQuery
            ->with(['items' => function($query) {
                $query->where('order_index', '>=', 0)->whereNotNull('file_path')->orderBy('order_index', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.public.gallery-display', compact('galleries'));
    }
    
    // Méthode pour changer le filtre (appelée par les boutons)
    public function setFilter($filter)
    {
        $this->activeFilter = $filter;
    }
}