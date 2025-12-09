{{-- resources/views/livewire/comptabilite/historique-comptable.blade.php --}}
<div class="p-4 md:p-6 bg-gray-50 min-h-screen">

    <!-- =======================
         HEADER & BOUTONS
    ======================== -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                📊 Historique Comptable
            </h1>
            <p class="text-gray-600 mt-1">Vue d'ensemble de toutes les transactions</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <button wire:click="exportPdf"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2">
                <i class="fas fa-file-pdf"></i>
                Exporter PDF
            </button>
            
            <button wire:click="$refresh"
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
            <!-- Date début -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                <input type="date" wire:model.lazy="dateDebut"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Date fin -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                <input type="date" wire:model.lazy="dateFin"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Type de filtre -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type d'élément</label>
                <select wire:model.lazy="typeFiltre"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="tout">Tout afficher</option>
                    <option value="facture">Factures</option>
                    <option value="paiement">Paiements</option>
                    <option value="reservation">Réservations</option>
                    <option value="vente">Ventes restaurant</option>
                    <option value="service">Services divers</option>
                    <option value="depense">Dépenses</option>
                </select>
            </div>

            <!-- Utilisateur -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Utilisateur</label>
                <select wire:model.lazy="filterUser"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Recherche -->
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" wire:model.lazy="search" 
                       placeholder="Rechercher par ID, nom, libellé..."
                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- =======================
         TAB NAVIGATION
    ======================== -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 overflow-x-auto">
                <button wire:click="$set('activeTab', 'tout')"
                        class="{{ $activeTab === 'tout' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-layer-group mr-2"></i>
                    Vue d'ensemble
                </button>
                <button wire:click="$set('activeTab', 'facture')"
                        class="{{ $activeTab === 'facture' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Factures ({{ $invoices->count() ?? 0 }})
                </button>
                <button wire:click="$set('activeTab', 'paiement')"
                        class="{{ $activeTab === 'paiement' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Paiements ({{ $payments->count() ?? 0 }})
                </button>
                <button wire:click="$set('activeTab', 'reservation')"
                        class="{{ $activeTab === 'reservation' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Réservations ({{ $reservations->count() ?? 0 }})
                </button>
                <button wire:click="$set('activeTab', 'vente')"
                        class="{{ $activeTab === 'vente' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-utensils mr-2"></i>
                    Ventes ({{ $sales->count() ?? 0 }})
                </button>
                <button wire:click="$set('activeTab', 'service')"
                        class="{{ $activeTab === 'service' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-concierge-bell mr-2"></i>
                    Services ({{ $diversServices->count() ?? 0 }})
                </button>
                <button wire:click="$set('activeTab', 'depense')"
                        class="{{ $activeTab === 'depense' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                    <i class="fas fa-receipt mr-2"></i>
                    Dépenses ({{ $expenses->count() ?? 0 }})
                </button>
            </nav>
        </div>
    </div>

    <!-- =======================
         CONTENU DES ONGLETS
    ======================== -->

    <!-- ONGLET FACTURES -->
    @if($activeTab === 'facture' || ($activeTab === 'tout' && $invoices->isNotEmpty()))
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-brown-50 to-brown-100">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-file-invoice text-brown-600"></i>
                Historique des Factures
                <span class="ml-auto text-sm font-normal text-gray-500">{{ $invoices->count() ?? 0 }} facture(s)</span>
            </h2>
        </div>
        
        @if($invoices->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant payé</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($invoices as $invoice)
                    <tr class="hover:bg-brown-50/40 transition duration-150">
                        <td class="px-4 py-3 font-mono text-sm text-gray-600">#{{ $invoice->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($invoice->reservation_id)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    Réservation
                                </span>
                            @elseif($invoice->sale_id)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Vente
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                    Service
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($invoice->reservation?->client)
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->reservation->client->nom }}</div>
                            @elseif($invoice->sale?->reservation?->client)
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->sale->reservation->client->nom }}</div>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">
                                {{ number_format($invoice->montant_final, 0, ',', ' ') }} FCFA
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-green-600">
                            {{ number_format($invoice->montant_paye, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-bold">
                            {{ number_format($invoice->montant_final - $invoice->montant_paye, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'payé' => 'bg-green-100 text-green-800',
                                    'partiel' => 'bg-yellow-100 text-yellow-800',
                                    'impayé' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$invoice->statut] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $color }}">
                                {{ ucfirst($invoice->statut) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $invoice->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="{{ route('invoice.download', $invoice->id) }}"
                               class="text-brown-600 hover:text-brown-800 font-medium hover:underline text-sm">
                                <i class="fas fa-download mr-1"></i> PDF
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-600">
                    Total: <span class="font-bold">{{ number_format($invoices->sum('montant_final'), 0, ',', ' ') }} FCFA</span>
                </p>
                @if($invoices instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">
                        Page {{ $invoices->currentPage() }} sur {{ $invoices->lastPage() }}
                    </span>
                    {{ $invoices->links('components.custom-pagination') }}
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="px-4 py-12 text-center">
            <div class="text-gray-400">
                <i class="fas fa-file-invoice fa-3x mb-4"></i>
                <p class="text-lg font-medium text-gray-500">Aucune facture trouvée</p>
                <p class="text-sm mt-2">Ajustez vos filtres pour voir plus de résultats</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- ONGLET PAIEMENTS -->
    @if($activeTab === 'paiement' || ($activeTab === 'tout' && $payments->isNotEmpty()))
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-green-100">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-money-bill-wave text-green-600"></i>
                Historique des Paiements
                <span class="ml-auto text-sm font-normal text-gray-500">{{ $payments->count() ?? 0 }} paiement(s)</span>
            </h2>
        </div>
        
        @if($payments->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($payments as $payment)
                    <tr class="hover:bg-green-50/40 transition duration-150">
                        <td class="px-4 py-3 font-mono text-sm text-gray-600">#{{ $payment->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $payment->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $payment->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($payment->reservation?->client)
                                <div class="text-sm font-medium text-gray-900">{{ $payment->reservation->client->nom }}</div>
                            @elseif($payment->sale?->reservation?->client)
                                <div class="text-sm font-medium text-gray-900">{{ $payment->sale->reservation->client->nom }}</div>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($payment->reservation_id)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    Réservation
                                </span>
                            @elseif($payment->sale_id)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Vente
                                </span>
                            @elseif($payment->divers_service_vente_id)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    Service
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $modeColors = [
                                    'Espèces' => 'bg-green-100 text-green-800',
                                    'Mobile Money' => 'bg-blue-100 text-blue-800',
                                    'Carte/TPE' => 'bg-purple-100 text-purple-800',
                                    'Virement' => 'bg-indigo-100 text-indigo-800',
                                ];
                                $color = $modeColors[$payment->mode_paiement] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $color }}">
                                {{ $payment->mode_paiement }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">
                                {{ number_format($payment->montant, 0, ',', ' ') }} FCFA
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $modeColors = [
                                    'Payé' => 'bg-green-100 text-green-800',
                                    'En attente' => 'bg-blue-100 text-blue-800',    
                                ];
                                $color = $modeColors[$payment->statut] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $color }}">
                                {{ $payment->statut }}
                            </span>
                         </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-900">{{ $payment->user?->name ?? 'Système' }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-600">
                    Total: <span class="font-bold">{{ number_format($payments->sum('montant'), 0, ',', ' ') }} FCFA</span>
                </p>
                @if($payments instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">
                        Page {{ $payments->currentPage() }} sur {{ $payments->lastPage() }}
                    </span>
                    {{ $payments->links('components.custom-pagination') }}
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="px-4 py-12 text-center">
            <div class="text-gray-400">
                <i class="fas fa-money-bill-wave fa-3x mb-4"></i>
                <p class="text-lg font-medium text-gray-500">Aucun paiement trouvé</p>
                <p class="text-sm mt-2">Ajustez vos filtres pour voir plus de résultats</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- ONGLET DÉPENSES -->
    @if($activeTab === 'depense' || ($activeTab === 'tout' && $expenses->isNotEmpty()))
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-amber-100">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-receipt text-amber-600"></i>
                Historique des Dépenses
                <span class="ml-auto text-sm font-normal text-gray-500">{{ $expenses->count() ?? 0 }} dépense(s)</span>
            </h2>
        </div>
        
        @if($expenses->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Libellé</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($expenses as $expense)
                    <tr class="hover:bg-amber-50/40 transition duration-150">
                        <td class="px-4 py-3 font-mono text-sm text-gray-600">#{{ $expense->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                {{ $expense->categorie }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $expense->libelle }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-bold text-red-600">
                                {{ number_format($expense->montant, 0, ',', ' ') }} FCFA
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'validé' => 'bg-green-100 text-green-800',
                                    'en attente' => 'bg-yellow-100 text-yellow-800',
                                    'refusé' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$expense->statut] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $color }}">
                                {{ ucfirst($expense->statut) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-900">{{ $expense->user?->name ?? '—' }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $expense->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-600">
                    Total: <span class="font-bold text-red-600">{{ number_format($expenses->sum('montant'), 0, ',', ' ') }} FCFA</span>
                </p>
                @if($expenses instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">
                        Page {{ $expenses->currentPage() }} sur {{ $expenses->lastPage() }}
                    </span>
                    {{ $expenses->links('components.custom-pagination') }}
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="px-4 py-12 text-center">
            <div class="text-gray-400">
                <i class="fas fa-receipt fa-3x mb-4"></i>
                <p class="text-lg font-medium text-gray-500">Aucune dépense trouvée</p>
                <p class="text-sm mt-2">Ajustez vos filtres pour voir plus de résultats</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- NOTE: Ajoutez les autres onglets (reservation, vente, service) de la même manière -->
    
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