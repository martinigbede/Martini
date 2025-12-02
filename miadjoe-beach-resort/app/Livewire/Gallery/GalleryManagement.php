<?php

namespace App\Livewire\Gallery;

use Livewire\Component;

use App\Models\Gallery;
use App\Models\GalleryItem;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class GalleryManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $mode = 'gallery'; // 'gallery' ou 'item'
    public $isModalOpen = false;
    public $editingId = null;
    
    // Champs pour les Galeries (Albums)
    public $gal_title, $gal_description, $gal_type;
    
    // Champs pour les Items (Photos/Vidéos)
    public $item_gallery_id, $item_file, $item_caption, $item_order_index, $item_temp_path;

    protected $rules = [
        'gal_title' => 'required|string|max:255',
        'gal_description' => 'nullable|string',
        'gal_type' => 'required|in:photo,video',
        'item_gallery_id' => 'required|integer|exists:galleries,id',
        'item_file' => 'nullable|file|mimes:jpg,png,jpeg,mp4,mov|max:10240', // Max 10MB (images ou vidéos)
        'item_caption' => 'nullable|string|max:255',
        'item_order_index' => 'required|integer',
    ];

    public function render()
    {
        // $this->authorize('manage', Gallery::class); 

        if ($this->mode === 'gallery') {
            $items = Gallery::orderBy('id', 'asc')->paginate(10, ['*'], 'galPage');
        } else { // item
            $items = GalleryItem::with('gallery')->orderBy('gallery_id', 'asc')->paginate(10, ['*'], 'itemPage');
        }
        
        $galleryTypes = ['photo', 'video'];

        return view('livewire.gallery.gallery-management', compact('items', 'galleryTypes'))
            ->layout('layouts.app');
    }
    
    // --- Gestion du Mode ---
    public function switchMode($newMode)
    {
        $this->mode = $newMode;
        $this->resetPage(); 
        $this->closeModal();
    }

    // --- Gestion de la Modale ---
    public function openModal($id = null)
    {
        $this->resetFields();
        $this->isModalOpen = true;
        $this->editingId = $id;

        if ($id) {
            if ($this->mode === 'gallery') {
                // $this->authorize('update', Gallery::findOrFail($id));
                $gal = Gallery::findOrFail($id);
                $this->gal_title = $gal->title;
                $this->gal_description = $gal->description;
                $this->gal_type = $gal->type;
            } else { // item
                $item = GalleryItem::findOrFail($id);
                // $this->authorize('update', $item);
                $this->item_gallery_id = $item->gallery_id;
                $this->item_caption = $item->caption;
                $this->item_order_index = $item->order_index;
                $this->item_temp_path = $item->file_path; // Chemin existant
            }
        }
    }
    
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetFields();
    }
    
    public function resetFields()
    {
        $this->gal_title = $this->gal_description = $this->gal_type = null;
        $this->item_caption = $this->item_order_index = null;
        $this->item_gallery_id = null;
        $this->item_file = null; // Fichier temporaire à zéro
        $this->item_temp_path = null;
        $this->editingId = null;
    }

    // --- CRUD Catégorie (Gallery) ---
    public function storeGallery()
    {
        // $this->authorize('manage', Gallery::class); 
        
        $rules = [
            'gal_title' => 'required|string|max:255',
            'gal_description' => 'nullable|string',
            'gal_type' => 'required|in:photo,video',
        ];
        $this->validate($rules);

        Gallery::updateOrCreate(
            ['id' => $this->editingId],
            ['title' => $this->gal_title, 'description' => $this->gal_description, 'type' => $this->gal_type]
        );

        session()->flash('message', $this->editingId ? 'Galerie mise à jour.' : 'Galerie créée.');
        $this->closeModal();
    }

    public function deleteGallery($id)
    {
        $gal = Gallery::findOrFail($id);
        // $this->authorize('manage', $gal);
        
        // Supprimer les items associés et leurs fichiers
        foreach ($gal->items as $item) {
            $this->deleteFileFromPath($item->file_path);
            $item->delete();
        }
        
        $gal->delete();
        session()->flash('message', 'Galerie et ses éléments supprimés.');
    }
    
    // --- CRUD Item (GalleryItem) ---
    public function storeItem()
    {
        // $this->authorize('manage', GalleryItem::class); 
        
        $rules = [
            'item_gallery_id' => 'required|integer|exists:galleries,id',
            'item_file' => 'required|file|mimes:jpg,png,jpeg,mp4,mov|max:10240', // Fichier requis pour la création/modification
            'item_caption' => 'nullable|string|max:255',
            'item_order_index' => 'required|integer',
        ];
        
        // Validation spécifique pour la mise à jour si on ne change pas le fichier
        if ($this->editingId) {
             unset($rules['item_file']); // Rendre le fichier non obligatoire en édition
        }
        
        $this->validate($rules);

        // LOGIQUE DE CRÉATION/MISE À JOUR AVEC CORRECTION DE LA CLÉ ÉTRANGÈRE
        $data = [
            'gallery_id' => $this->item_gallery_id, // <<< CORRECTION : Utiliser gallery_id
            'caption' => $this->item_caption,
            'order_index' => $this->item_order_index,
        ];
        
        $item = GalleryItem::updateOrCreate(['id' => $this->editingId], $data);

        // GESTION DU FICHIER (Image ou Vidéo)
        if ($this->item_file) {
            // 1. Supprimer l'ancienne image si elle existe
            if ($this->item_temp_path) {
                 $this->deleteFileFromPath($this->item_temp_path);
            }
            
            // 2. Stocker le nouveau fichier
            $path = $this->item_file->store('gallery_media', 'public'); // Stocke dans storage/app/public/gallery_media
            $newPath = 'storage/' . $path;

            // 3. Mettre à jour le modèle
            $item->update(['file_path' => $newPath]);
        }
        
        session()->flash('message', $this->editingId ? 'Élément de galerie mis à jour.' : 'Élément de galerie créé.');
        $this->closeModal();
    }
    
    public function deleteItem($id)
    {
        $item = GalleryItem::findOrFail($id);
        // $this->authorize('manage', $item);
        
        // Suppression du fichier stocké
        $this->deleteFileFromPath($item->file_path);
        
        $item->delete();
        session()->flash('message', 'Élément de galerie supprimé.');
    }
    
    // --- Méthode de nettoyage de fichier ---
    protected function deleteFileFromPath($path)
    {
        if ($path && Storage::disk('public')->exists(str_replace('storage/', '', $path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $path));
        }
    }
}