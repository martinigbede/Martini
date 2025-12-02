<?php

namespace App\Livewire\RoomType;

use App\Models\RoomType;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // *** Nouveau Trait pour l'upload ***

class RoomTypeManagement extends Component
{
    use WithPagination;
    use WithFileUploads; // *** Utilisation du Trait ***

    // Propriétés de la liste
    public $search = '';
    public $perPage = 4;

    // Propriétés du formulaire
    public $isModalOpen = false;
    public $isEditing = false;
    public $roomTypeId;

    public $nom, $description, $prix_base, $nombre_personnes_max, $photo;
    public $photo_path; // Pour garder l'image existante lors de l'édition

    protected function rules()
    {
        return [
            'nom' => ['required', 'string', 'max:255', Rule::unique('room_types', 'nom')->ignore($this->roomTypeId ?? null)],
            'description' => 'nullable|string',
            'prix_base' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/', // Validation pour les décimales (prix)
            'nombre_personnes_max' => 'required|integer|min:1', // Validation pour l'entier (personnes)
            'photo' => 'nullable|image|max:2048', // 2MB max pour la nouvelle image
        ];
    }

    public function render()
    {
        $query = RoomType::query();

        if ($this->search) {
            $query->where('nom', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $roomTypes = $query->latest()->paginate($this->perPage);

        // Nous utiliserons ici un layout simple (par exemple, layouts.app), car la vue parente doit gérer la structure.
        return view('livewire.room-type.room-type-management', [
            'roomTypes' => $roomTypes,
        ]);
    }

    // --- CRUD : CREATE (Ouverture du formulaire) ---
    public function create()
    {
        $this->resetInput();
        $this->isEditing = false;
        $this->isModalOpen = true;
    }

    // --- CRUD : UPDATE (Ouverture du formulaire d'édition) ---
    public function edit($roomTypeId)
    {
        $roomType = RoomType::findOrFail($roomTypeId);
        
        $this->roomTypeId = $roomTypeId;
        $this->nom = $roomType->nom;
        $this->description = $roomType->description;
        $this->prix_base = $roomType->prix_base;
        $this->nombre_personnes_max = $roomType->nombre_personnes_max;
        $this->photo_path = $roomType->photo; // Garder le chemin de l'image existante
        $this->photo = null; // S'assurer que le champ d'upload est vide au départ

        $this->isEditing = true;
        $this->isModalOpen = true;
    }

    // --- CRUD : STORE / UPDATE (Sauvegarde) ---
    public function save()
    {
        $this->validate();

        $data = [
            'nom' => $this->nom,
            'description' => $this->description,
            'prix_base' => $this->prix_base,
            'nombre_personnes_max' => $this->nombre_personnes_max,
        ];

        if ($this->photo) {
            // Supprimer l'ancienne image si elle existe et si une nouvelle a été uploadée
            if ($this->isEditing && $this->photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->photo_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->photo_path);
            }
            // Stocker la nouvelle image
            $data['photo'] = $this->photo->store('room_types', 'public');
        }

        if ($this->isEditing) {
            RoomType::findOrFail($this->roomTypeId)->update($data);
            session()->flash('message', 'Type de chambre mis à jour avec succès.');
        } else {
            RoomType::create($data);
            session()->flash('message', 'Type de chambre créé avec succès.');
        }

        $this->closeModal();
    }

    // --- CRUD : DELETE ---
    public function confirmDelete($roomTypeId)
    {
        $this->dispatch('confirmDelete', roomTypeId: $roomTypeId);
    }

    public function delete($roomTypeId) // Assurez-vous qu'elle est publique
    {
        $roomType = RoomType::findOrFail($roomTypeId);
        
        // Supprimer le fichier image
        if ($roomType->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($roomType->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($roomType->photo);
        }
        
        $roomType->delete();
        session()->flash('message', 'Type de chambre supprimé avec succès.');
        $this->resetPage(); // Ceci assure le rafraîchissement instantané
    }

    // --- Utilitaires ---
    public function closeModal() // <-- CHANGÉ À PUBLIC
    {
        $this->isModalOpen = false;
        $this->resetInput();
        $this->resetPage(); // Rafraîchir la liste
    }

    private function resetInput()
    {
        $this->resetValidation();
        $this->roomTypeId = null;
        $this->nom = '';
        $this->description = '';
        $this->prix_base = null;
        $this->nombre_personnes_max = null;
        $this->photo = null; // Réinitialiser le fichier uploadé
        $this->photo_path = null;
    }

    // --- HOOKS POUR FILTRES ET PAGINATION INSTANTANÉS ---
    public function updatingSearch()
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