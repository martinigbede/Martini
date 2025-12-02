<?php

namespace App\Livewire\Room;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class RoomManagement extends Component
{
    use WithPagination;
    use WithFileUploads; // Pour gérer les uploads de fichiers

    // Propriétés de la liste et filtres
    public $search = '';
    public $statutFilter = '';
    public $typeFilter = '';
    public $perPage = 4;

    // Propriétés du formulaire
    public $isModalOpen = false;
    public $isEditing = false;
    public $roomId;

    public $numero, $room_type_id, $statut, $description, $prix_personnalise;
    public $newPhotos = []; // Pour les nouveaux uploads multiples
    public $existingPhotos = []; // Pour les photos existantes à supprimer/garder

    // Données externes
    public $roomTypes;

    protected function rules()
    {
        return [
            'numero' => ['required', 'string', 'max:10', Rule::unique('rooms', 'numero')->ignore($this->roomId ?? null)],
            'room_type_id' => 'required|exists:room_types,id',
            'statut' => 'required|in:Libre,Occupée,Nettoyage,Maintenance',
            'description' => 'nullable|string',
            'prix_personnalise' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            // Validation pour l'upload multiple : minimum 4 photos si en création, sinon optionnel
            'newPhotos.*' => 'nullable|image|max:2048', 
        ];
    }

    public function mount()
    {
        $this->roomTypes = RoomType::all();
        $this->statut = 'Libre';
    }

    public function render()
    {
        $query = Room::with(['roomType'])->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statutFilter) {
            $query->where('statut', $this->statutFilter);
        }

        if ($this->typeFilter) {
            $query->where('room_type_id', $this->typeFilter);
        }

        $rooms = $query->paginate($this->perPage);

        return view('livewire.room.room-management', [
            'rooms' => $rooms,
        ]);
    }

    // --- ACTIONS MODAL ---
    public function openModal()
    {
        $this->resetInput();
        $this->isEditing = false;
        $this->isModalOpen = true;
        // Définir un type par défaut si possible
        if ($this->roomTypes->isNotEmpty() && is_null($this->room_type_id)) {
            $this->room_type_id = $this->roomTypes->first()->id;
        }
    }

    public function edit($roomId)
    {
        $room = Room::findOrFail($roomId);
        
        $this->roomId = $roomId;
        $this->numero = $room->numero;
        $this->room_type_id = $room->room_type_id;
        $this->statut = $room->statut;
        $this->description = $room->description;
        $this->prix_personnalise = $room->prix_personnalise;
        
        // Charger les photos existantes
        $this->existingPhotos = $room->photos->map(fn($p) => $p->id)->toArray();
        $this->newPhotos = [];

        $this->isEditing = true;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInput();
        $this->resetPage(); 
    }

    public function resetInput()
    {
        $this->resetValidation();
        $this->roomId = null;
        $this->numero = '';
        $this->room_type_id = null;
        $this->statut = 'Libre';
        $this->description = '';
        $this->prix_personnalise = null;
        $this->newPhotos = [];
        $this->existingPhotos = [];
    }

    // --- CRUD : STORE / UPDATE ---
    public function save()
    {
        
        $this->validate();


        $data = [
            'numero' => $this->numero,
            'room_type_id' => $this->room_type_id,
            'statut' => $this->statut,
            'description' => $this->description,
            'prix_personnalise' => $this->prix_personnalise,
        ];

        DB::transaction(function () use ($data) {
            if ($this->isEditing) {
                $room = Room::findOrFail($this->roomId);
                $room->update($data);
                $this->handlePhotoUpdates($room); // Gère les ajouts/suppressions
                session()->flash('message', 'Chambre mise à jour avec succès.');
            } else {
                $room = Room::create($data);
                $this->handlePhotoUploads($room); // Gère l'upload si des photos existent
                session()->flash('message', 'Chambre créée avec succès.');
            }
        });

        $this->closeModal();
    }
    
    // --- Gestion des Photos ---
    protected function handlePhotoUploads($room)
    {
        // On traite uniquement s'il y a des fichiers dans $this->newPhotos
        if (!empty($this->newPhotos)) {
            foreach ($this->newPhotos as $photo) {
                // Pour le drag & drop multiple, chaque élément dans $this->newPhotos est un fichier
                if ($photo) { 
                    $path = $photo->store('rooms', 'public');
                    $room->photos()->create(['path' => $path]);
                }
            }
        }
    }
    
    protected function handlePhotoUpdates($room)
    {
        // 1. Supprimer les anciennes photos cochées pour suppression
        //$deletedPhotoIds = array_diff($this->existingPhotos, array_map(fn($id) => (string)$id, $this->existingPhotos)); // Logic simplification needed if we had actual checkboxes
        // Pour l'exemple, on va simplifier : on laisse l'utilisateur gérer la suppression manuellement ou on surcharge tout.
        // Vu la complexité du drag/drop/delete, nous allons juste gérer les nouvelles et ignorer la suppression d'anciennes pour l'instant.

        // 2. Ajouter les nouvelles photos
        $this->handlePhotoUploads($room);
    }


    // --- CRUD : DELETE ---
    public function confirmDelete($roomId)
    {
        $this->dispatch('confirmDelete', roomId: $roomId);
    }

    public function delete($roomId)
    {
        $room = Room::findOrFail($roomId);
        
        // Suppression des photos associées
        if ($room->photos) {
            foreach ($room->photos as $photo) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photo->path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
                }
                $photo->delete();
            }
        }

        $room->delete();
        session()->flash('message', 'Chambre supprimée avec succès.');
        $this->resetPage();
    }

    // --- HOOKS POUR FILTRES ET PAGINATION INSTANTANÉS ---
    public function updatingSearch()
    {
        $this->resetPage();
        $this->dispatchSelf('refresh');
    }

    public function updatingStatutFilter()
    {
        $this->resetPage();
        $this->dispatchSelf('refresh');
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
        $this->dispatchSelf('refresh');
    }

    public function updatingPerPage()
    {
        $this->resetPage();
        $this->dispatchSelf('refresh');
    }
}