<?php

namespace App\Livewire\Direction;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\ReservationItem;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DirectionDashboard extends Component
{
    public $day;

    public $totalRevenueHotel = 0;
    public $totalRevenueRestaurant = 0;
    public $totalRevenueDivers = 0;
    public $totalRevenueGlobal = 0;
    public $totalInvoicedAmount = 0;


    public $totalPayments = 0;
    public $totalDue = 0;

    public $occupiedRooms = 0;

    public $reservationsToday = [];
    public $salesToday = [];

    // KPI
    public $occupationRate = 0;
    public $totalRooms = 0;
    public $averageRevenuePerRoom = 0;

    // Filtres
    public $filterMode = 'day';
    public $selectedYear;
    public $selectedMonth;
    public $startDate;
    public $endDate;

    protected $listeners = ['refresh-data' => '$refresh'];

    public function mount()
    {
        $now = Carbon::now();
        $this->day = $now->toDateString();

        $this->selectedYear = $now->year;
        $this->selectedMonth = $now->month;

        $this->startDate = $now->copy()->startOfMonth()->toDateString();
        $this->endDate = $now->copy()->endOfMonth()->toDateString();

        $this->refreshData();
    }

    public function updated($property)
    {
        if (in_array($property, ['selectedYear', 'selectedMonth', 'startDate', 'endDate'])) {
            $this->refreshData();
        }
    }

    public function refreshData()
    {
        $this->applyFilterDates();

        $this->calculateRevenue();
        $this->calculatePayments();
        $this->calculateOccupiedRooms();
        $this->fetchTodayReservations();
        $this->fetchTodaySales();

        $data = [
            'hotel' => $this->totalRevenueHotel,
            'restaurant' => $this->totalRevenueRestaurant,
            'divers' => $this->totalRevenueDivers,
            'global' => $this->totalRevenueGlobal,
            'payments' => $this->totalPayments,
            'due' => $this->totalDue,
            'occupiedRooms' => $this->occupiedRooms,
            'occupationRate' => $this->occupationRate,
            'avgRoomRevenue' => $this->averageRevenuePerRoom,
        ];

        $this->totalRevenueHotel = $data['hotel'];
        $this->totalRevenueRestaurant = $data['restaurant'];
        $this->totalRevenueDivers = $data['divers'];
        $this->totalRevenueGlobal = $data['global'];

        $this->totalPayments = $data['payments'];
        $this->totalDue = $data['due'];

        $this->occupiedRooms = $data['occupiedRooms'];
        $this->occupationRate = $data['occupationRate'];
        $this->averageRevenuePerRoom = $data['avgRoomRevenue'];
    }

    // ============================================
    // Revenus
    // ============================================
    public function calculateRevenue()
    {
        $invoices = Invoice::whereBetween('created_at', [$this->startDate, $this->endDate])->get();

        // Revenu basé sur ce qui est réellement payé
        $this->totalRevenueHotel = $invoices
            ->whereNotNull('reservation_id')
            ->sum('montant_paye');

        $this->totalRevenueRestaurant = $invoices
            ->whereNotNull('sale_id')
            ->sum('montant_paye');

        $this->totalRevenueDivers = $invoices
            ->whereNotNull('divers_service_vente_id')
            ->sum('montant_paye');

        // Revenu Global
        $this->totalRevenueGlobal =
            $this->totalRevenueHotel +
            $this->totalRevenueRestaurant +
            $this->totalRevenueDivers;

        // Montant total facturé (nouveau KPI)
        $this->totalInvoicedAmount = $invoices->sum('montant_final');
    }

    // ============================================
    // Paiements (corrigé : filtrage ajouté)
    // ============================================
    public function calculatePayments()
    {
        // Paiements réellement effectués
        $this->totalPayments = (float) Payment::where('statut', 'Payé')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('montant');

        // Montant dû = somme(montant_final - montant_paye)
        $invoices = Invoice::whereBetween('created_at', [$this->startDate, $this->endDate])->get();

        $this->totalDue = $invoices->sum(function ($inv) {
            return $inv->montant_final - $inv->montant_paye;
        });
    }

    // ============================================
    // Taux d'occupation
    // ============================================
    public function calculateOccupiedRooms()
    {
        $day = $this->day;

        $occupiedRoomIds = ReservationItem::whereHas('reservation', function ($q) use ($day) {
                $q->whereIn('statut', ['Confirmée', 'En séjour'])
                ->whereDate('check_in', '<=', $day)
                ->whereDate('check_out', '>=', $day);
            })
            ->pluck('room_id')
            ->unique();

        $this->occupiedRooms = $occupiedRoomIds->count();
        $this->totalRooms = Room::count();

        $this->occupationRate = $this->totalRooms > 0
            ? round(($this->occupiedRooms / $this->totalRooms) * 100, 2)
            : 0;

        $this->averageRevenuePerRoom = $this->totalRooms > 0
            ? round($this->totalRevenueGlobal / $this->totalRooms, 2)
            : 0;
    }

    // ============================================
    // Réservations du jour (uniquement Confirmées)
    // ============================================
    public function fetchTodayReservations()
    {
        $this->reservationsToday = Reservation::with(['client:id,nom,prenom', 'items'])
            ->whereDate('check_in', '<=', $this->day)
            ->whereDate('check_out', '>=', $this->day)
            ->whereIn('statut', ['Confirmée', 'En séjour'])
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'client' => $r->client ? $r->client->nom.' '.$r->client->prenom : '—',
                'check_in' => $r->check_in,
                'check_out' => $r->check_out,
                'total' => $r->total ?? 0,
                'statut' => $r->statut,
            ]);
    }

    // ============================================
    // Ventes du jour
    // ============================================
    public function fetchTodaySales()
    {
        $this->salesToday = Sale::with([
                'items:id,sale_id,menu_id,quantite,prix_unitaire',
                'reservation:id,client_id'
            ])
            ->whereDate('date', $this->day)
            ->orderBy('date')
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'reservation_id' => $s->reservation_id,
                'total' => $s->total ?? 0,
                'items_count' => $s->items->count(),
            ]);
    }

    // ============================================
    // Filtres
    // ============================================
    public function applyFilterDates()
    {
        $now = Carbon::now();
        if ($this->filterMode === 'day') {
            $this->startDate = Carbon::parse($this->day)->startOfDay();
            $this->endDate = Carbon::parse($this->day)->endOfDay();
        }

        if ($this->filterMode === 'week') {
            $this->startDate = $now->copy()->startOfWeek()->toDateString();
            $this->endDate = $now->copy()->endOfWeek()->toDateString();
        }

        elseif ($this->filterMode === 'month') {
            $this->startDate = $now->copy()->startOfMonth()->toDateString();
            $this->endDate = $now->copy()->endOfMonth()->toDateString();
        }

        elseif ($this->filterMode === 'custom') {
            return;
        }
    }

    // ============================================
    // Export PDF
    // ============================================
    public function exportPDF()
    {
        $data = [
            'hotel' => $this->totalRevenueHotel,
            'restaurant' => $this->totalRevenueRestaurant,
            'divers' => $this->totalRevenueDivers,
            'global' => $this->totalRevenueGlobal,
            'payments' => $this->totalPayments,
            'due' => $this->totalDue,
            'occupiedRooms' => $this->occupiedRooms,
            'totalRooms' => $this->totalRooms,
            'occupationRate' => $this->occupationRate,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        $pdf = \PDF::loadView('pdf.direction-dashboard', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'dashboard.pdf');
    }

    public function render()
    {
        return view('livewire.direction.direction-dashboard');
    }
}
