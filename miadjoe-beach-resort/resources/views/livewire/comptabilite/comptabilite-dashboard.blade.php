<div class="p-6 bg-gradient-to-br from-brown-50 to-brown-100 min-h-screen">

    <!-- En-tête fixe -->
    <div class="sticky top-0 z-40 bg-gradient-to-br from-brown-50 to-brown-100 pt-6 pb-4 -mx-6 px-6 border-b border-brown-200/50 backdrop-blur-sm">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-brown-900 tracking-tight mb-2 flex items-center gap-3">
                <div class="p-3 bg-brown-600 rounded-xl text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                Tableau de bord comptable
            </h1>
            <p class="text-brown-600">Aperçu complet de votre activité financière</p>
        </div>

        {{-- 🔹 FILTRES --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border border-brown-200">
            <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center">
                
                <!-- Filtres période -->
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                    <label class="text-brown-700 font-semibold text-sm uppercase tracking-wide">Période :</label>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select wire:model.live="periode"
                            class="border border-brown-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-brown-400 focus:border-brown-400 transition-all duration-200 min-w-48">
                            <option value="jour">Aujourd'hui</option>
                            <option value="mois">Ce mois</option>
                            <option value="annee">Cette année</option>
                            <option value="personnalisee">Personnalisée</option>
                        </select>

                        @if ($periode === 'personnalisee')
                            <div class="flex gap-3 items-center">
                                <div class="flex flex-col">
                                    <label class="text-brown-600 text-xs font-medium mb-1">Du :</label>
                                    <input type="date" wire:model.live="dateDebut"
                                        class="border border-brown-300 rounded-lg px-3 py-2 shadow-sm text-sm focus:ring-2 focus:ring-brown-400">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-brown-600 text-xs font-medium mb-1">Au :</label>
                                    <input type="date" wire:model.live="dateFin"
                                        class="border border-brown-300 rounded-lg px-3 py-2 shadow-sm text-sm focus:ring-2 focus:ring-brown-400">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex gap-3 ml-auto flex-wrap">
                    {{-- PDF --}}
                    <button wire:click="exportPDF"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-lg shadow-md transition-all duration-200 active:scale-95 flex items-center gap-2 font-medium group">
                        <span wire:loading.remove wire:target="exportPDF" class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            PDF
                        </span>
                        <span wire:loading wire:target="exportPDF"
                            class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                    </button>

                    {{-- Excel --}}
                    <button wire:click="exportExcel"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow-md transition-all duration-200 active:scale-95 flex items-center gap-2 font-medium group">
                        <span wire:loading.remove wire:target="exportExcel" class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Excel
                        </span>
                        <span wire:loading wire:target="exportExcel"
                            class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                    </button>

                    {{-- Historique --}}
                    <a href="{{ route('dashboard.comptable.historique') }}"
                        class="bg-brown-600 hover:bg-brown-700 text-white px-5 py-3 rounded-lg shadow-md transition-all duration-200 active:scale-95 flex items-center gap-2 font-medium group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Historique
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed top-4 right-4 z-50 space-y-2">
        @if(session()->has('success'))
            <div class="bg-green-600 text-white px-4 py-2 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('info'))
            <div class="bg-blue-600 text-white px-4 py-2 rounded shadow">
                {{ session('info') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-red-600 text-white px-4 py-2 rounded shadow">
                {{ session('error') }}
            </div>
        @endif
    </div>
    {{-- Caisses regroupées --}}
    @if(count($caissesRegroupees) > 0)
    <div class="mt-10 mb-8">
        <h2 class="text-2xl font-bold text-brown-800 mb-8">Situation des caisses</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($caissesRegroupees as $caisse)
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-brown-200 hover:shadow-2xl transition-all duration-300">
                
                {{-- En-tête avec titre et actions --}}
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-brown-100">
                    <h3 class="text-xl font-bold text-brown-900 bg-gradient-to-r from-brown-600 to-brown-800 bg-clip-text text-transparent">
                        {{ $caisse['type'] }}
                    </h3>
                    
                    {{-- Actions principales --}}
                    <div class="flex gap-3">
                        @if($caisse['type'] === 'Hébergement')
                        <button 
                            wire:click="$dispatch('ouvrir-decaissement', { type: 'Hébergement' })" 
                            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-md hover:shadow-lg"
                            title="Décaisser"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            <span class="text-sm font-semibold">Décaisser</span>
                        </button>
                        @endif
                        
                        @if($caisse['type'] === 'Restaurant')
                        <button 
                            wire:click="$dispatch('ouvrir-encaissement')" 
                            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-md hover:shadow-lg"
                            title="Encaisser"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            <span class="text-sm font-semibold">Encaisser</span>
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Détails des montants --}}
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center p-4 bg-brown-50 rounded-lg hover:bg-brown-100 transition-colors duration-200">
                        <span class="font-semibold text-brown-700">Espèces Réel (Espéces + Mobile Money)</span>
                        <span class="font-bold text-brown-900 text-lg bg-white px-3 py-1 rounded-lg border border-brown-200">
                            {{ number_format($caisse['especes_reel'], 0, ',', ' ') }} FCFA
                        </span>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-brown-50 rounded-lg hover:bg-brown-100 transition-colors duration-200">
                        <span class="font-semibold text-brown-700">Carte / TPE</span>
                        <span class="font-bold text-brown-900 text-lg bg-white px-3 py-1 rounded-lg border border-brown-200">
                            {{ number_format($caisse['carte'], 0, ',', ' ') }} FCFA
                        </span>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-brown-50 rounded-lg hover:bg-brown-100 transition-colors duration-200">
                        <span class="font-semibold text-brown-700">Virement</span>
                        <span class="font-bold text-brown-900 text-lg bg-white px-3 py-1 rounded-lg border border-brown-200">
                            {{ number_format($caisse['virement'], 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>

                {{-- Actions de vidage --}}
                <div class="flex gap-3 flex-wrap pt-4 border-t border-brown-100">
                    @if($caisse['type'] === 'Hébergement')
                    <button 
                        wire:click="viderCaisse('Hébergement', 'Carte/TPE')" 
                        class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 shadow-sm hover:shadow-md"
                        title="Vider Carte/TPE Hébergement"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span class="text-xs font-medium">Carte/TPE</span>
                    </button>
                    
                    <button 
                        wire:click="viderCaisse('Hébergement', 'Virement')" 
                        class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 shadow-sm hover:shadow-md"
                        title="Vider Virement Hébergement"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span class="text-xs font-medium">Virement</span>
                    </button>
                    @endif
                    
                    @if($caisse['type'] === 'Restaurant')
                    <button 
                        wire:click="viderCaisse('Restaurant', 'Carte/TPE')" 
                        class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 shadow-sm hover:shadow-md"
                        title="Vider Carte/TPE Restaurant"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span class="text-xs font-medium">Carte/TPE</span>
                    </button>
                    
                    <button 
                        wire:click="viderCaisse('Restaurant', 'Virement')" 
                        class="flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 shadow-sm hover:shadow-md"
                        title="Vider Virement Restaurant"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span class="text-xs font-medium">Virement</span>
                    </button>
                    <button 
                        wire:click="$dispatch('open-hors-vente-modal')" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Ajouter un apport hors vente
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- CARTES STATS --}}
    <div class="space-y-8 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-7 gap-6">
            @foreach([
                ['Total Paiements', $totalPaiements, 'text-green-600', 'bg-gradient-to-br from-green-50 to-emerald-50 border-green-200/60', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['Montant Factures', $totalFactures, 'text-blue-600', 'bg-gradient-to-br from-blue-50 to-sky-50 border-blue-200/60', 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01m12.01-5H15m-3 0H9m12 3h-2.5m-9.5 0h9.5M4 12h2.5'],
                ['En Attente', $totalEnAttente, 'text-amber-600', 'bg-gradient-to-br from-amber-50 to-orange-50 border-amber-200/60', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['Réservations', $totalReservations, 'text-gray-700', 'bg-gradient-to-br from-gray-50 to-slate-50 border-gray-200/60', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['Ventes', $totalVentes, 'text-indigo-600', 'bg-gradient-to-br from-indigo-50 to-violet-50 border-indigo-200/60', 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                ['Divers Services', $totalDivers, 'text-purple-600', 'bg-gradient-to-br from-purple-50 to-fuchsia-50 border-purple-200/60', 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['Dépenses validées', $totalDepenses, 'text-red-600', 'bg-gradient-to-br from-red-50 to-rose-50 border-red-200/60', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z'],
            ] as [$label, $value, $color, $bgColor, $iconPath])
                <div class="relative bg-white p-6 rounded-2xl shadow-lg border hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group cursor-pointer {{ $bgColor }} overflow-hidden">
                    {{-- Effet de brillance au survol --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    
                    {{-- Icone décorative --}}
                    <div class="absolute -right-4 -top-4 w-20 h-20 opacity-5 {{ str_replace('text-', 'text-', $color) }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="{{ $iconPath }}"/>
                        </svg>
                    </div>

                    <div class="relative z-10">
                        {{-- En-tête avec icône --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-2 rounded-lg bg-white/80 shadow-sm border border-white/50">
                                <svg class="w-5 h-5 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                                </svg>
                            </div>
                            <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                        </div>

                        {{-- Valeur principale --}}
                        <p class="text-2xl font-bold {{ $color }} mb-2 tracking-tight">
                            {{ number_format($value, 0, ',', ' ') }}
                        </p>

                        {{-- Label et unité --}}
                        <div class="space-y-1">
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">{{ $label }}</h3>
                            <p class="text-xs font-medium text-gray-500/80">
                                @if (str_contains($label, 'Montant') 
                                    || str_contains($label, 'Total') 
                                    || str_contains($label, 'Attente') 
                                    || str_contains($label, 'Solde') 
                                    || str_contains($label, 'Dépenses'))
                                    F CFA
                                @else
                                    transactions
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Barre de progression décorative --}}
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gray-100/50 overflow-hidden">
                        <div class="h-full {{ str_replace('text-', 'bg-', $color) }} transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-700 ease-out"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- 🔹 Graphiques --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

        <!-- 📊 Revenus mensuels -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-brown-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-brown-800 flex items-center gap-2">
                    <div class="p-2 bg-green-100 rounded-lg text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    Revenus mensuels
                </h2>
            </div>

            <div class="h-72">
                <canvas id="revenusChart"></canvas>
            </div>
        </div>

        <!-- 🧾 Répartition paiements -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-brown-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-brown-800 flex items-center gap-2">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 
                                    0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 
                                    002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 
                                    01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    Répartition par mode de paiement
                </h2>
            </div>

            <div class="h-72">
                <canvas id="modesPaiementChart"></canvas>
            </div>
        </div>
    </div>

    {{-- 🔹 Dernières Transactions --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        
        <!-- Derniers paiements -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-brown-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-brown-800 flex items-center gap-2">
                    <div class="p-2 bg-green-100 rounded-lg text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Derniers paiements
                </h2>
                <span class="text-sm text-brown-500">{{ $derniersPaiements->count() }} transactions</span>
            </div>
            <div class="space-y-3">
                @foreach($derniersPaiements as $p)
                    <div class="flex items-center justify-between p-3 rounded-lg border border-brown-100 hover:bg-brown-50 transition-colors duration-200 group">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-brown-900 text-sm">{{ $p->mode_paiement ?? '—' }}</p>
                                <p class="text-brown-500 text-xs">{{ $p->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <span class="font-semibold text-green-600 text-sm">
                            {{ number_format($p->montant, 0, ',', ' ') }} F
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Dernières factures -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-brown-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-brown-800 flex items-center gap-2">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    Dernières factures
                </h2>
                <span class="text-sm text-brown-500">{{ $dernieresFactures->count() }} factures</span>
            </div>
            <div class="space-y-3">
                @foreach ($dernieresFactures as $f)
                    <div class="flex items-center justify-between p-3 rounded-lg border border-brown-100 hover:bg-brown-50 transition-colors duration-200 group">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-brown-900 text-sm">Facture #{{ $f->id }}</p>
                                <p class="text-brown-500 text-xs">{{ $f->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('invoice.download', $f->id) }}"
                           class="text-brown-600 hover:text-brown-800 p-2 rounded-lg hover:bg-brown-100 transition-colors duration-200 flex items-center gap-1 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Télécharger
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <livewire:caisse.decaissement-modal />
    <livewire:caisse.encaissement-modal />
    <livewire:comptabilite.hors-vente-modale />
</div>
{{-- ======== SCRIPT GRAPHIQUES ======== --}}
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {

            // Extraction directe depuis $revenusMensuels
            const revenusDataPHP = @json($revenusMensuels);

            const revenusLabels = revenusDataPHP.map(item => item.mois);
            const revenusData = revenusDataPHP.map(item => item.total);

            // ====== CHART REVENUS MENSUELS ======
            const ctx1 = document.getElementById('revenusChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: revenusLabels,
                    datasets: [{
                        label: 'Revenus',
                        data: revenusData,
                        borderWidth: 2,
                        tension: 0.3
                    }]
                }
            });

            // ====== MODES DE PAIEMENT ======
            const resumePaiement = @json($resumeModesPaiement);

            const paiementLabels = Object.keys(resumePaiement);
            const paiementData = Object.values(resumePaiement);

            const ctx2 = document.getElementById('modesPaiementChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: paiementLabels,
                    datasets: [{
                        data: paiementData
                    }]
                }
            });

        });
    </script>
@endpush