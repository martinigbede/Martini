<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role; 
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Mail; // Décommenter si vous implémentez l'email

class UserManagement extends Component
{
    use WithPagination;

    // Propriétés de la liste
    public $search = '';
    public $statusFilter = 'actif';
    public $roleFilter = '';
    public $perPage = 7;

    // Propriétés du formulaire
    public $isModalOpen = false;
    public $isEditing = false;
    public $userId;

    // *** CORRECTIONS ICI : UTILISATION DE $name AU LIEU DE $nom ***
    public $name, $prenom, $email, $telephone, $role_id, $statut, $password, $password_confirmation;

    // Rôles disponibles
    public $allRoles;

    protected function rules()
    {
        $rules = [
            // *** CORRECTION : Utilisation de 'name' au lieu de 'nom' ***
            'name' => 'required|string|max:255', 
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'statut' => 'required|in:actif,inactif',
        ];

        // Validation spécifique pour l'email
        $rules['email'] = [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($this->userId ?? null),
        ];

        // Validation du mot de passe conditionnelle
        if ($this->isEditing) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        } else {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    public function mount()
    {
        $this->allRoles = Role::all();
        $this->statut = 'actif';

        if ($this->allRoles->isEmpty()) {
            session()->flash('warning', 'Attention : Aucun rôle n\'est configuré dans Spatie. La sélection de rôle sera désactivée.');
        }
    }

    public function render()
    {
        $query = User::query()
            ->where('id', '!=', auth()->id()); 

        if ($this->search) {
            $query->where(function ($q) {
                // *** CORRECTION : Recherche sur 'name' et 'prenom' ***
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('prenom', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('statut', $this->statusFilter);
        }

        if ($this->roleFilter) {
            $query->role($this->roleFilter); 
        }

        $users = $query->latest()->paginate($this->perPage);

        // Suppression de ->layout('layouts.app') pour utiliser le layout de la vue parente
        return view('livewire.user.user-management', [
            'users' => $users,
        ]);


    }

    // --- MODAL & FORM ACTIONS ---

    public function openModal()
    {
        $this->resetInput();
        $this->isModalOpen = true;
        $this->isEditing = false;
        if ($this->allRoles->isNotEmpty() && is_null($this->role_id)) {
            $this->role_id = $this->allRoles->first()->id;
        }
    }

    public function edit($userId)
    {
        $this->resetInput();
        $this->userId = $userId;
        $user = User::findOrFail($userId);

        // *** CORRECTION : Chargement de $this->name ***
        $this->name = $user->name; 
        $this->prenom = $user->prenom;
        $this->email = $user->email;
        $this->telephone = $user->telephone;
        $this->statut = $user->statut;
        $this->isEditing = true;
        $this->isModalOpen = true;

        $role = $user->roles->first();
        if ($role) {
            $this->role_id = $role->id;
        }


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
        $this->userId = null;
        $this->name = ''; // Réinitialisation de $name
        $this->prenom = '';
        $this->email = '';
        $this->telephone = '';
        $this->password = '';
        $this->password_confirmation = ''; 
        $this->statut = 'actif';
        if (!$this->isEditing) {
            $this->role_id = null;
        }
    }

    public function save()
    {
        $this->validate();

        $userData = [
            // *** CORRECTION : Mapping $this->name vers 'name' de la DB ***
            'name' => $this->name, 
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'statut' => $this->statut,
        ];

        if ($this->isEditing) {
            $user = User::find($this->userId);
            
            $updateData = $userData;
            if (empty($this->password)) {
                unset($updateData['password']);
            }
            $user->update($updateData);

            // Mise à jour du rôle
            $role = Role::find($this->role_id);
            $user->syncRoles([$role->name]);

            if ($this->password) {
                $user->password = Hash::make($this->password);
                $user->save();
            }
            session()->flash('message', 'Utilisateur mis à jour avec succès.');
        } else {
            $userData['password'] = Hash::make($this->password);
            $user = User::create($userData);

            // Assignation du rôle
            $role = Role::find($this->role_id);
            $user->assignRole($role->name);

            session()->flash('message', 'Utilisateur créé avec succès.');
        }

        $this->closeModal();
    }

    // --- ACTIONS SPÉCIFIQUES ---

    public function delete($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Vous ne pouvez pas vous supprimer vous-même.');
            return; 
        }

        $user->delete();
        session()->flash('message', 'Utilisateur supprimé avec succès.');
        $this->resetPage(); 
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        $newPassword = Str::random(12); 

        $user->password = Hash::make($newPassword);
        $user->save();

        $message = 'Mot de passe réinitialisé. Mot de passe temporaire: ' . $newPassword;
        
        session()->flash('message', $message);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }


    public function updatingStatusFilter() // <-- NOUVEAU HOOK
    {
        $this->resetPage();
    }

    public function updatingRoleFilter() // <-- NOUVEAU HOOK
    {
        $this->resetPage();
    }

 
}