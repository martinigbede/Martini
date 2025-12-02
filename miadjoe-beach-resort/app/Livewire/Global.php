<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class GlobalUpdater extends Component
{
    public $lastUpdated;

    public function mount()
    {
        $this->lastUpdated = Carbon::now();
    }

    public function refreshAll()
    {
        // Déclenche le refresh global
        $this->dispatch('refresh-data');

        // Met à jour l'heure
        $this->lastUpdated = Carbon::now();
    }

    public function getTimeAgoProperty()
    {
        return Carbon::parse($this->lastUpdated)->diffForHumans();
    }

    public function render()
    {
        return view('livewire.global');
    }
}
