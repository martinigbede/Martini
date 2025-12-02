<?php

namespace App\Livewire\Setting;

use App\Models\Setting;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class SettingManagement extends Component
{
    use WithPagination;

    // Propriétés de la liste
    public $search = '';
    public $perPage = 10;

    // Propriétés du formulaire
    public $isModalOpen = false;
    public $isEditing = false;
    public $settingId;

    public $key, $value, $label;

    protected function rules()
    {
        return [
            'key' => ['required', 'string', 'max:100', Rule::unique('settings', 'key')->ignore($this->settingId ?? null)],
            'value' => 'nullable|string|max:255',
            'label' => 'required|string|max:255',
        ];
    }

    public function render()
    {
        $query = Setting::query();

        if ($this->search) {
            $query->where('key', 'like', '%' . $this->search . '%')
                  ->orWhere('label', 'like', '%' . $this->search . '%')
                  ->orWhere('value', 'like', '%' . $this->search . '%');
        }

        $settings = $query->latest()->paginate($this->perPage);

        return view('livewire.setting.setting-management', [
            'settings' => $settings,
        ]);
    }

    // --- ACTIONS MODAL ---
    public function openModal()
    {
        $this->resetInput();
        $this->isEditing = false;
        $this->isModalOpen = true;
    }

    public function edit($settingId)
    {
        $setting = Setting::findOrFail($settingId);
        
        $this->settingId = $settingId;
        $this->key = $setting->key;
        $this->value = $setting->value;
        $this->label = $setting->label;

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
        $this->settingId = null;
        $this->key = '';
        $this->value = '';
        $this->label = '';
    }

    // --- CRUD : STORE / UPDATE ---
    public function save()
    {
        $this->validate();

        // --- Logique d'encodage automatique du mot de passe de suppression ---
        $value = $this->value;

        //if ($this->key === 'delete_password') {
            // Si la valeur n'est pas déjà hashée, on la hash automatiquement
        //    if (!\Illuminate\Support\Str::startsWith($value, '$2y$')) {
         //       $value = bcrypt($value);
        //    }
      //  }

        $data = [
            'key' => $this->key,
            'value' => $value,
            'label' => $this->label,
        ];

        if ($this->isEditing) {
            Setting::findOrFail($this->settingId)->update($data);
            session()->flash('message', 'Paramètre mis à jour avec succès.');
        } else {
            Setting::create($data);
            session()->flash('message', 'Paramètre créé avec succès.');
        }

        $this->closeModal();
    }

    // --- CRUD : DELETE ---
    public function confirmDelete($settingId)
    {
        $this->dispatch('confirmDelete', settingId: $settingId);
    }

    public function delete($settingId)
    {
        Setting::findOrFail($settingId)->delete();
        session()->flash('message', 'Paramètre supprimé avec succès.');
        $this->resetPage();
    }

    // --- HOOKS ---
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