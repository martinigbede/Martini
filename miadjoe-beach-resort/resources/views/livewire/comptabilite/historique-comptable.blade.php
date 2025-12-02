{{-- resources/views/livewire/comptabilite/historique-comptable.blade.php --}}
<div class="p-6 space-y-8 bg-gradient-to-br from-gray-50 to-brown-50/40 min-h-screen">

    {{-- 🔍 FILTRES --}}
    <div class="bg-white/70 backdrop-blur-sm border border-gray-200 shadow-sm rounded-2xl p-6">
            <button wire:click="exportPdf" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" >
                Exporter PDF
            </button>
        <h2 class="text-lg font-semibold text-brown-800 mb-4 flex items-center space-x-2">
            <svg class="w-5 h-5 text-brown-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z" />
            </svg>
            <span>Filtres de recherche</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date début</label>
                <input type="date" wire:model="dateDebut"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brown-500 focus:ring-brown-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date fin</label>
                <input type="date" wire:model="dateFin"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brown-500 focus:ring-brown-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Recherche</label>
                <input type="text" wire:model.debounce.500ms="search" placeholder="ID, nom, utilisateur..."
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brown-500 focus:ring-brown-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Filtre</label>
                <select wire:model="typeFiltre"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-brown-500 focus:ring-brown-500">
                    <option value="tout">Tout</option>
                    <option value="facture">Factures</option>
                    <option value="paiement">Paiements</option>
                    <option value="reservation">Réservations</option>
                    <option value="vente">Ventes restaurant</option>
                    <option value="service">Services divers</option>
                    <option value="depense">Dépenses</option>
                </select>
            </div>
        </div>
    </div>

    {{-- 🧾 FACTURES --}}
    @if(in_array($typeFiltre, ['tout', 'facture']) && $invoices->isNotEmpty())
    <div class="bg-white border border-gray-200 shadow-lg rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-brown-600 to-brown-700 text-white px-6 py-3 font-semibold flex items-center space-x-2">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h4l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2z" />
            </svg>
            <span>Factures</span>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach(['ID','Type','Client / Vente','Montant total','Montant payé','Statut','Actions'] as $head)
                        <th class="px-5 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($invoices as $invoice)
                <tr class="hover:bg-brown-50/40 transition">
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $invoice->id }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">
                        @if($invoice->reservation_id) Réservation # {{ $invoice->reservation_id }}
                        @elseif($invoice->sale_id) Vente #{{ $invoice->sale_id }}
                        @elseif($invoice->divers_service_vente_id) Service #{{ $invoice->divers_service_vente_id }}
                        @endif
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-800">
                        @if($invoice->reservation)
                            {{ $invoice->reservation->client->nom ?? '' }}
                        @elseif($invoice->sale)
                            Vente #{{ $invoice->sale->id }}
                        @elseif($invoice->diversServiceVente)
                            {{ $invoice->diversServiceVente->nom_service ?? '' }}
                        @endif
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-800 font-medium">{{ number_format($invoice->montant_final, 2, ',', ' ') }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">{{ number_format($invoice->montant_paye, 2, ',', ' ') }}</td>
                    <td class="px-5 py-3 text-sm">
                        <span
                            class="px-3 py-1 text-xs font-semibold rounded-full {{ $invoice->statut == 'payé' ? 'bg-green-100 text-green-700' : ($invoice->statut == 'partiel' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-200 text-gray-700') }}">
                            {{ ucfirst($invoice->statut) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-sm">
                        <a href="{{ route('invoice.download', $invoice->id) }}"
                            class="text-brown-600 hover:text-brown-800 font-medium hover:underline">Télécharger</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>   
    </div>
    <div class="flex justify-center">
        {{ $invoices->links() }}
    </div>
    @endif

    {{-- 💰 PAIEMENTS --}}
    @if(in_array($typeFiltre, ['tout', 'paiement']) && $payments->isNotEmpty())
    <div class="bg-white border border-gray-200 shadow-lg rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white px-6 py-3 font-semibold flex items-center space-x-2">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.104 0-2 .896-2 2v6h4v-6c0-1.104-.896-2-2-2zm0 10a2 2 0 100 4 2 2 0 000-4z" />
            </svg>
            <span>Paiements</span>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach(['ID','Montant','Mode','Utilisateur','Type','Date'] as $head)
                        <th class="px-5 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($payments as $payment)
                <tr class="hover:bg-green-50/40 transition">
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $payment->id }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800 font-medium">{{ number_format($payment->montant, 2, ',', ' ') }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">{{ ucfirst($payment->mode_paiement) }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $payment->user->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">
                        @if($payment->reservation_id) Réservation #{{ $payment->reservation_id }}
                        @elseif($payment->sale_id) Vente #{{ $payment->sale_id }}
                        @elseif($payment->divers_service_vente_id) Service Divers #{{ $payment->divers_service_vente_id }} 
                        @endif
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>
    <div class="flex justify-center">
        {{ $payments->links() }}
    </div>
    @endif

    {{-- 🧾 DÉPENSES --}}
    @if(in_array($typeFiltre, ['tout', 'depense']) && $expenses->isNotEmpty())
    <div class="bg-white border border-gray-200 shadow-lg rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-amber-600 to-orange-700 text-white px-6 py-3 font-semibold flex items-center space-x-2">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2h6v2m3 4H6a2 2 0 01-2-2V7h16v12a2 2 0 01-2 2z" />
            </svg>
            <span>Dépenses</span>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach(['ID','Libellé','Montant','Utilisateur','Statut','Date'] as $head)
                        <th class="px-5 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($expenses as $expense)
                <tr class="hover:bg-amber-50/40 transition">
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $expense->id }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $expense->categorie }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800 font-medium">{{ number_format($expense->montant, 2, ',', ' ') }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $expense->user->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-sm text-gray-800">
                        <span class="px-3 py-1 text-xs rounded-full {{ $expense->statut == 'validé' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ ucfirst($expense->statut ?? 'en attente') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-800">{{ $expense->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-center">
        {{ $expenses->links() }}
        </div> 
    </div>
    @endif
</div>
