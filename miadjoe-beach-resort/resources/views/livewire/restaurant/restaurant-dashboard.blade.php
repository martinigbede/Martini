<div class="p-6 bg-gradient-to-br from-amber-50 to-orange-50/30 min-h-screen">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
        <div class="mb-4 lg:mb-0">
            <h2 class="text-3xl font-bold text-amber-900 mb-2 flex items-center">
                <span class="inline-flex items-center justify-center w-10 h-10 bg-amber-100 rounded-xl mr-3">
                    🍽️
                </span>
                Dashboard Restaurant
            </h2>
            <p class="text-amber-600 text-lg">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="date" wire:model="date" 
                       class="px-4 py-2.5 border-2 border-amber-200 rounded-xl bg-white shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-300 hover:border-amber-300" />
                <svg class="w-4 h-4 absolute right-3 top-3 text-amber-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-sm text-amber-500 bg-white/80 px-3 py-1.5 rounded-full border border-amber-200">
                🔄 Mise à jour auto ({{ $pollInterval }}s)
            </span>
            <button wire:click="loadAll" 
                    class="px-4 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-semibold flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Rafraîchir
            </button>
        </div>
    </div>

    {{-- KPI Cards modernisées --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl p-6 shadow-lg border border-amber-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 text-sm font-semibold mb-2">Ventes du jour</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $this->formatCurrency($salesTotal) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl p-6 shadow-lg border border-amber-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 text-sm font-semibold mb-2">Nombre de ventes</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $salesCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl p-6 shadow-lg border border-amber-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 text-sm font-semibold mb-2">Articles vendus</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $itemsSold }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl p-6 shadow-lg border border-amber-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 text-sm font-semibold mb-2">Plat le plus vendu</p>
                    <p class="text-lg font-bold text-amber-900 truncate">{{ $topMenu['name'] ?? '—' }}</p>
                    <p class="text-sm text-amber-500 mt-1">
                        {{ $topMenu ? ($topMenu['qty'].' × '.$this->formatCurrency($topMenu['revenue'])) : '' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl p-6 shadow-lg border border-amber-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 text-sm font-semibold mb-2">CA (mois)</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $this->formatCurrency($monthlyRevenue) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" wire:poll.{{ $pollInterval }}s="loadAll">
        {{-- Ventes du jour --}}
        <div class="bg-white rounded-2xl shadow-lg border border-amber-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-blue-200">
                <h3 class="text-lg font-bold text-blue-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Ventes du jour
                    <span class="ml-2 text-sm font-normal text-blue-600 bg-white px-2 py-1 rounded-full">
                        {{ count($sales) }}
                    </span>
                </h3>
            </div>
            
            <div class="p-4">
                @if(count($sales) === 0)
                    <div class="text-center py-8 text-amber-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-lg font-medium">Aucune vente pour cette date</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-amber-600 text-xs font-semibold uppercase tracking-wide">
                                    <th class="px-4 py-3 border-b border-amber-100">Date</th>
                                    <th class="px-4 py-3 border-b border-amber-100">Total</th>
                                    <th class="px-4 py-3 border-b border-amber-100">Client</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-100">
                                @foreach($sales as $s)
                                    <tr class="hover:bg-amber-50/50 transition-colors duration-150">
                                        <td class="px-4 py-3 text-amber-900 font-medium">{{ data_get($s,'date') }}</td>
                                        <td class="px-4 py-3 font-semibold text-green-600">{{ $this->formatCurrency(data_get($s,'total',0)) }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                {{ data_get($s,'reservation.client.nom', data_get($s,'reservation.client.name','—')) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Articles les plus vendus --}}
        <div class="bg-white rounded-2xl shadow-lg border border-amber-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-purple-200">
                <h3 class="text-lg font-bold text-purple-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Top Articles
                    <span class="ml-2 text-sm font-normal text-purple-600 bg-white px-2 py-1 rounded-full">
                        {{ count($topItems) }}
                    </span>
                </h3>
            </div>
            
            <div class="p-4">
                @if(count($topItems) === 0)
                    <div class="text-center py-8 text-amber-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <p class="text-lg font-medium">Aucun article vendu</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-amber-600 text-xs font-semibold uppercase tracking-wide">
                                    <th class="px-4 py-3 border-b border-amber-100">Menu</th>
                                    <th class="px-4 py-3 border-b border-amber-100 text-center">Quantité</th>
                                    <th class="px-4 py-3 border-b border-amber-100 text-right">Chiffre d'affaires</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-100">
                                @foreach($topItems as $item)
                                    <tr class="hover:bg-amber-50/50 transition-colors duration-150">
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-amber-900">{{ data_get($item,'menu') }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                                                {{ data_get($item,'qty') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right font-semibold text-green-600">
                                            {{ $this->formatCurrency(data_get($item,'revenue',0)) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Chart amélioré --}}
                <div class="mt-6 p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Évolution des ventes
                    </h4>
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Flash messages --}}
    <div class="fixed bottom-6 right-6 space-y-2">
        @if (session()->has('success'))
            <div class="px-4 py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg flex items-center animate-bounce-in">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="px-4 py-3 rounded-xl bg-gradient-to-r from-red-600 to-orange-600 text-white shadow-lg flex items-center animate-bounce-in">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        const ctx = document.getElementById('salesChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const data = @json($chartData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ventes (FCFA)',
                    data: data,
                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                    borderColor: 'rgba(245, 158, 11, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        Livewire.hook('message.processed', (message, component) => {
            const parent = ctx.parentNode;
            const newCanvas = document.createElement('canvas');
            newCanvas.id = 'salesChart';
            newCanvas.width = 400; newCanvas.height = 200;
            parent.replaceChild(newCanvas, ctx);

            const labels2 = @json($chartLabels);
            const data2 = @json($chartData);
            new Chart(newCanvas, {
                type: 'bar',
                data: {
                    labels: labels2,
                    datasets: [{
                        label: 'Ventes (FCFA)',
                        data: data2,
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        borderColor: 'rgba(245, 158, 11, 1)',
                        borderWidth: 2,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.1)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    });
</script>