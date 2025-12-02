<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientsList extends Component
{
    public $clients;

    public function mount()
    {
        $this->loadClients();
    }

    public function loadClients()
    {
        $this->clients = Client::withCount('reservations')->get();
    }

    public function exportPdf()
    {
        $clients = Client::withCount('reservations')->get();

        $pdf = Pdf::loadView('pdf.clients', compact('clients'));

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'clients.pdf');
    }

    public function render()
    {
        return view('livewire.clients-list');
    }
}
