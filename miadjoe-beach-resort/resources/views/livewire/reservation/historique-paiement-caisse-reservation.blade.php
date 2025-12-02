<div class="p-4 md:p-6 bg-gray-50 min-h-screen">

    <!-- =======================
         HEADER & BOUTONS
    ======================== -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                📊 Caisse & Historique des Paiements
            </h1>
            <p class="text-gray-600 mt-1">Gestion et suivi des transactions financières</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('dashboard.gestion.decaissement') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                <i class="fas fa-exchange-alt"></i>
                Gestion Décaissements
            </a>
            
            <button wire:click="exportPdf"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2">
                <i class="fas fa-file-pdf"></i>
                Exporter PDF
            </button>
            
            <button wire:click="loadData"
                    class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition duration-200 flex items-center gap-2">
                <i class="fas fa-sync-alt"></i>
                Actualiser
            </button>
        </div>
    </div>

    <!-- =======================
         FILTRES MODERNES
    ======================== -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 md:mb-0">
                <i class="fas fa-filter mr-2"></i>Filtres
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Type de période -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                <select wire:model="filterDateType"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="jour">Aujourd'hui</option>
                    <option value="mois">Mensuel</option>
                    <option value="annee">Annuel</option>
                    <option value="semaine">Hebdomadaire</option>
                    <option value="perso">Personnalisé</option>
                </select>
            </div>

            <!-- Filtres dynamiques -->
            @if($filterDateType === 'mois')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
                    <select wire:model="filterMonth" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}">{{ date("F", mktime(0,0,0,$m,1)) }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if($filterDateType === 'semaine')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semaine</label>
                    <select wire:model="filterWeek" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach(range(1,52) as $w)
                            <option value="{{ $w }}">Semaine {{ $w }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Année pour tous sauf perso -->
            @if($filterDateType != 'perso')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                    <select wire:model="filterYear" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach(range(date('Y')-5, date('Y')+1) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if($filterDateType === 'perso')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                    <input type="date" wire:model="filterStartDate"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                    <input type="date" wire:model="filterEndDate"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            @endif

            <!-- Mode de paiement -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
                <select wire:model="filterMode"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les modes</option>
                    <option value="Espèces">Espèces</option>
                    <option value="Mobile Money">Mobile Money</option>
                    <option value="Carte/TPE">Carte/TPE</option>
                    <option value="Virement">Virement</option>
                </select>
            </div>

            <!-- Utilisateur -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Utilisateur</label>
                <select wire:model="filterUser"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- =======================
         KPI MODERNES
    ======================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Caisse Brute -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-5 text-white hover-lift">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-orange-100 text-sm">Caisse Brute (Filtré)</p>
                    <h3 class="text-2xl font-bold mt-1">
                        {{ number_format($caisseBrute, 0, ',', ' ') }} FCFA
                    </h3>
                    <p class="text-orange-200 text-xs mt-2">
                        {{ $payments->count() }} transaction(s)
                    </p>
                </div>
                <div class="bg-orange-400 p-3 rounded-full">
                    <i class="fas fa-cash-register text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Espèces/Mobile Money -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white hover-lift">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-green-100 text-sm">Espèces + Mobile Money</p>
                    <h3 class="text-2xl font-bold mt-1">
                        {{ number_format($kpiEspMomo, 0, ',', ' ') }} FCFA
                    </h3>
                    @if($caisseHier)
                        <p class="text-green-200 text-xs mt-2">
                            Hier: {{ number_format($caisseHier['esp_momo'] ?? 0, 0, ',', ' ') }} FCFA
                        </p>
                    @endif
                </div>
                <div class="bg-green-400 p-3 rounded-full">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-green-400">
                <p class="text-sm">
                    Réel: {{ number_format($soldeEspMomo, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>

        <!-- Carte/TPE -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white hover-lift">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-sm">Carte/TPE</p>
                    <h3 class="text-2xl font-bold mt-1">
                        {{ number_format($kpiTPE, 0, ',', ' ') }} FCFA
                    </h3>
                    @if($caisseHier)
                        <p class="text-blue-200 text-xs mt-2">
                            Hier: {{ number_format($caisseHier['tpe'] ?? 0, 0, ',', ' ') }} FCFA
                        </p>
                    @endif
                </div>
                <div class="bg-blue-400 p-3 rounded-full">
                    <i class="fas fa-credit-card text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-blue-400">
                <p class="text-sm">
                    Réel: {{ number_format($soldeTPE, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>

        <!-- Virement -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white hover-lift">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-purple-100 text-sm">Virement</p>
                    <h3 class="text-2xl font-bold mt-1">
                        {{ number_format($kpiVirement, 0, ',', ' ') }} FCFA
                    </h3>
                    @if($caisseHier)
                        <p class="text-purple-200 text-xs mt-2">
                            Hier: {{ number_format($caisseHier['virement'] ?? 0, 0, ',', ' ') }}  FCFA
                        </p>
                    @endif
                </div>
                <div class="bg-purple-400 p-3 rounded-full">
                    <i class="fas fa-university text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-purple-400">
                <p class="text-sm">
                    Réel: {{ number_format($soldeVirement, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>
    </div>

    <!-- =======================
         TABLEAU DES PAIEMENTS
    ======================== -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-history"></i>
                Historique complet des paiements
            </h2>
            <p class="text-gray-500 text-sm mt-1">{{ $payments->count() }} paiement(s) trouvé(s)</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservation/Service</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remise</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <!-- ID -->
                            <td class="px-4 py-3 font-mono text-sm text-gray-600">
                                #{{ $payment->id }}
                            </td>
                            
                            <!-- DATE -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $payment->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->created_at->format('H:i') }}</div>
                            </td>
                            
                            <!-- CLIENT -->
                            <td class="px-4 py-3">
                                @if($payment->reservation?->client)
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $payment->reservation->client->nom }}
                                    </div>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            
                            <!-- TYPE -->
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-amber-600">
                                    @if($payment->reservation_id)
                                        Réservation #{{ $payment->reservation_id }}
                                    @elseif($payment->divers_service_vente_id)
                                        Service Divers #{{ $payment->divers_service_vente_id }}
                                    @else
                                        —
                                    @endif
                                </span>
                            </td>
                            
                            <!-- MODE DE PAIEMENT -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php
                                    $modeColors = [
                                        'Espèces' => 'bg-green-100 text-green-800',
                                        'Mobile Money' => 'bg-blue-100 text-blue-800',
                                        'Carte/TPE' => 'bg-purple-100 text-purple-800',
                                        'Virement' => 'bg-indigo-100 text-indigo-800',
                                        'Offert' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $color = $modeColors[$payment->mode_paiement] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $color }}">
                                    {{ $payment->mode_paiement }}
                                </span>
                            </td>
                            
                            <!-- MONTANT -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">
                                    {{ number_format($payment->montant, 0, ',', ' ') }} FCFA
                                </div>
                            </td>
                            
                            <!-- REMISE -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-red-500">
                                {{ number_format($payment->remise_amount, 0, ',', ' ') }} FCFA
                            </td>
                            
                            <!-- UTILISATEUR -->
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-900">
                                    {{ $payment->user?->name ?? 'Système' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-search fa-3x mb-4"></i>
                                    <p class="text-lg font-medium text-gray-500">Aucun paiement trouvé</p>
                                    <p class="text-sm mt-2">Ajustez vos filtres pour voir plus de résultats</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- PIED DE TABLEAU -->
        @if($payments->count() > 0)
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        Total: <span class="font-bold">{{ number_format($payments->sum('montant'), 0, ',', ' ') }} FCFA</span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Dernière mise à jour: {{ now()->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- INDICATEUR DE CHARGEMENT -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <span class="text-lg font-medium text-gray-700">Chargement des données...</span>
            </div>
        </div>
    </div>
    
    <style>
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
        }
        
        select, input {
            transition: all 0.2s ease-in-out;
        }
        
        select:focus, input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</div>