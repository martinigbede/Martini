<?php
namespace App\Livewire\Public;

use App\Models\RoomType;
use Livewire\Component;
use Carbon\Carbon;

class RoomTypeList extends Component
{
    public $activeFilter = 'all';
    
    // Propriété calculée (déjà définie)
    public function getFilteredRoomTypesProperty()
    {
        $query = RoomType::where('is_active', true);
        
        if ($this->activeFilter !== 'all') {
            // NOTE: Ceci suppose une colonne 'metadata' JSON ou vous devrez ajuster
            $query->whereRaw("JSON_EXTRACT(metadata, '$.tag') = ?", [$this->activeFilter]);
        }
        
        return $query->get();
    }
    
    public function setFilter($filter)
    {
        $this->activeFilter = $filter;
    }

    // --- NOUVELLE MÉTHODE CORRIGÉE ---
    public function getRoomFeatures($roomType)
    {
        // SIMULATION : Retourne une liste d'équipements basés sur le nom du type de chambre
        $features = [];
        
        if (str_contains($roomType->name, 'Luxe') || str_contains($roomType->name, 'Suite')) {
            $features[] = 'Climatiseur';
            $features[] = 'Balcon Privé';
        }
        if (str_contains($roomType->name, 'Standard') || $roomType->capacity <= 2) {
            $features[] = 'WiFi Gratuit';
        }
        
        // Assurez-vous de retourner au moins quelque chose, même si vide
        return array_unique(array_merge($features, ['TV', 'Service de Chambre']));
    }
    // ----------------------------------

    public function render()
    {
        $roomTypes = $this->filteredRoomTypes;
        
        // SIMULATION CORRECTE : On crée des objets simples (stdClass) pour simuler la relation image
        $roomTypes = $roomTypes->map(function($type) {
            $type->rating = '4.8'; 
            
            $placeholderImage = new \stdClass();
            $placeholderImage->file_path = 'placeholder.jpg'; // Utilise 'placeholder.jpg'
            
            $type->images = collect([$placeholderImage]); 
            return $type;
        });
        
        return view('livewire.public.room-type-list', [
            'filteredRoomTypes' => $roomTypes
        ]);
    }
}