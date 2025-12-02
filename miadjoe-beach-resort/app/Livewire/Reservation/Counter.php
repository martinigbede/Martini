<?php

namespace App\Livewire\Reservation;

use Livewire\Component;
use App\Models\Reservation;


class Counter extends Component
{
    public $type;
    public $count = 0;

    protected $listeners = ['refreshCounters' => 'updateCount'];

    public function mount($type)
    {
        $this->type = $type;
        $this->updateCount();
    }

    public function updateCount()
    {
        switch($this->type) {
            case 'total':
                $this->count = Reservation::count();
                break;
            case 'today':
                $this->count = Reservation::whereDate('created_at', today())->count();
                break;
            case 'confirmed':
                $this->count = Reservation::where('statut', 'confirmée')->count();
                break;
            case 'pending':
                $this->count = Reservation::where('statut', 'en_attente')->count();
                break;
            case 'revenue':
                $this->count = number_format(Reservation::where('statut', 'confirmée')->sum('total') ?? 0, 0);
                break;
        }
    }

    // Nouvelle méthode pour Laravel 12
    public function dispatchEvent($event, $data = null)
    {
        if (method_exists($this, 'dispatch')) {
            $this->dispatch($event, $data);
        }
    }

    public function render()
    {
        // Auto-refresh avec polling directement dans la vue
        return view('livewire.reservation.counter');
    }
}