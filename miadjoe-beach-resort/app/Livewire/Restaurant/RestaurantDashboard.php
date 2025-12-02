<?php

namespace App\Livewire\Restaurant;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Menu;

class RestaurantDashboard extends Component
{
    public $pollInterval = 30; // seconds

    // filters
    public $date; // yyyy-mm-dd (single day filter)

    // KPI
    public $salesTotal = 0.0; // montant ventes pour la date
    public $salesCount = 0; // nombre de ventes
    public $itemsSold = 0; // total items sold
    public $topMenu = null; // array with name, qty, total
    public $monthlyRevenue = 0.0;

    // Collections
    public $sales = [];
    public $topItems = [];

    // Chart data
    public $chartLabels = [];
    public $chartData = [];

    protected $listeners = [
        'refreshRestaurantDashboard' => 'loadAll',
        'refresh-data' => '$refresh',
    ];

    public function mount($date = null)
    {
        $this->date = $date ? Carbon::parse($date)->toDateString() : Carbon::today()->toDateString();
        $this->loadAll();
    }

    public function updatedDate()
    {
        $this->loadAll();
    }

    public function loadAll()
    {
        $this->loadMetrics();
        $this->loadCollections();
        $this->prepareChartData();
    }

    protected function loadMetrics()
    {
        $day = $this->date;

        // ventes du jour
        $salesQuery = Sale::whereDate('date', $day);
        $this->salesTotal = (float) $salesQuery->sum('total');
        $this->salesCount = (int) $salesQuery->count();

        // items vendus aujourd'hui (sum quantite)
        $this->itemsSold = (int) SaleItem::whereHas('sale', function ($q) use ($day) {
            $q->whereDate('date', $day);
        })->sum('quantite');

        // plat le plus vendu
        $top = SaleItem::selectRaw('menu_id, SUM(quantite) as qty, SUM(total) as revenue')
            ->whereHas('sale', function ($q) use ($day) {
                $q->whereDate('date', $day);
            })
            ->groupBy('menu_id')
            ->orderByDesc('qty')
            ->with('menu')
            ->first();

        if ($top) {
            $menu = Menu::find($top->menu_id);
            $this->topMenu = [
                'name' => $menu ? $menu->nom : ('Menu #'.$top->menu_id),
                'qty' => (int) $top->qty,
                'revenue' => (float) $top->revenue,
            ];
        } else {
            $this->topMenu = null;
        }

        // chiffre d'affaires du mois courant
        $startOfMonth = Carbon::parse($day)->startOfMonth()->toDateString();
        $endOfMonth = Carbon::parse($day)->endOfMonth()->toDateString();

        $this->monthlyRevenue = (float) Sale::whereBetween('date', [$startOfMonth, $endOfMonth])->sum('total');
    }

    protected function loadCollections()
    {
        $day = $this->date;

        $this->sales = Sale::with(['reservation.client'])
            ->whereDate('date', $day)
            ->orderByDesc('date')
            ->get()
            ->toArray();

        $this->topItems = SaleItem::selectRaw('menu_id, SUM(quantite) as qty, SUM(total) as revenue')
            ->whereHas('sale', function ($q) use ($day) {
                $q->whereDate('date', $day);
            })
            ->groupBy('menu_id')
            ->orderByDesc('qty')
            ->with('menu')
            ->get()
            ->map(function ($row) {
                return [
                    'menu' => $row->menu ? $row->menu->nom : ('Menu #'.$row->menu_id),
                    'qty' => (int) $row->qty,
                    'revenue' => (float) $row->revenue,
                ];
            })
            ->toArray();
    }

    protected function prepareChartData()
    {
        // Sales per day for the month of the selected date
        $day = Carbon::parse($this->date);
        $start = $day->copy()->startOfMonth();
        $end = $day->copy()->endOfMonth();

        $period = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $period[] = $d->toDateString();
        }

        $labels = array_map(function ($date) {
            return Carbon::parse($date)->format('d');
        }, $period);

        $totals = [];
        foreach ($period as $date) {
            $totals[] = (float) Sale::whereDate('date', $date)->sum('total');
        }

        $this->chartLabels = $labels;
        $this->chartData = $totals;
    }

    public function formatCurrency($value)
    {
        // Change currency formatting as needed, e.g., with spaces as thousand separators
        return number_format($value, 0, ',', ' ') . ' FCFA';
    }

    public function render()
    {
        return view('livewire.restaurant.restaurant-dashboard');
    }
}