<div>
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:ignore.self>
        {{-- Overlay --}}
        <div class="fixed inset-0 bg-brown-900/60 backdrop-blur-sm" wire:click="closeModal"></div>

        {{-- Contenu du modal --}}
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-auto border border-brown-200 overflow-hidden relative z-10 max-h-[85vh] flex flex-col">
            
            {{-- Header --}}
            <div class="bg-brown-700 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-1">
                            📊 Détails Vente #{{ $saleData['id'] ?? $saleId }}
                        </h2>
                        <p class="text-brown-200 text-xs">Informations de la transaction</p>
                    </div>
                    <button wire:click="closeModal" class="text-brown-200 hover:text-white transition-colors p-1 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Contenu --}}
            <div class="flex-1 overflow-y-auto">
                <div class="p-6 space-y-6">

                    {{-- Informations générales --}}
                    <div class="bg-brown-50 border border-brown-200 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-brown-800 mb-3">Informations Générales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-brown-100 rounded flex items-center justify-center">
                                    <svg class="w-3 h-3 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-brown-700 font-medium">Date</p>
                                    <p class="text-brown-800">{{ $saleData['date'] ?? now()->format('Y-m-d') }}</p>
                                </div>
                            </div>

                            @if(!empty($saleData['reservation']))
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-green-100 rounded flex items-center justify-center">
                                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-green-700 font-medium">Client</p>
                                        <p class="text-green-800">{{ $saleData['reservation']['client'] ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-purple-100 rounded flex items-center justify-center">
                                        <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-purple-700 font-medium">Chambre</p>
                                        <p class="text-purple-800">{{ $saleData['reservation']['room'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 font-medium">Type</p>
                                        <p class="text-gray-800">Vente sans réservation</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Articles --}}
                    <div class="border border-brown-200 rounded-lg overflow-hidden bg-white">
                        <div class="bg-brown-50 px-4 py-3 border-b border-brown-200">
                            <h3 class="text-sm font-semibold text-brown-800 flex items-center">
                                Articles de la Vente 
                                <span class="ml-2 text-xs font-normal text-brown-600 bg-white px-2 py-0.5 rounded">
                                    {{ count($items) }} article(s)
                                </span>
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="bg-brown-50 text-brown-700 uppercase font-semibold">
                                        <th class="px-4 py-2 text-left border-b border-brown-200">Menu</th>
                                        <th class="px-4 py-2 text-center border-b border-brown-200">Unité</th>
                                        <th class="px-4 py-2 text-center border-b border-brown-200">Qté</th>
                                        <th class="px-4 py-2 text-right border-b border-brown-200">Prix U.</th>
                                        <th class="px-4 py-2 text-right border-b border-brown-200">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-brown-100">
                                    @forelse($items as $item)
                                        <tr class="hover:bg-brown-50/50">
                                            <td class="px-4 py-2 text-brown-800 font-medium">{{ $item['menu_nom'] ?? '-' }}</td>
                                            <td class="px-4 py-2 text-center text-brown-600">{{ $item['unite'] ?? '-' }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-brown-100 text-brown-700 rounded text-xs font-medium">
                                                    {{ $item['quantite'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-right text-brown-600">{{ number_format($item['prix_unitaire'], 2) }} FCFA</td>
                                            <td class="px-4 py-2 text-right font-semibold text-green-600">{{ number_format($item['total'], 2) }} FCFA</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-4 text-center text-brown-500 text-xs">
                                                Aucun article
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Résumé du paiement --}}
                    <div class="bg-brown-50 border border-brown-200 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-brown-800 mb-3">Résumé du Paiement</h3>
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between items-center py-2 border-b border-brown-200">
                                <span class="text-brown-700 font-medium">Montant final</span>
                                <span class="text-sm font-bold text-brown-800">{{ number_format($total, 2) }} FCFA</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-brown-200">
                                <span class="text-blue-700 font-medium">Montant payé</span>
                                <span class="text-sm font-bold text-blue-600">{{ number_format($payment_amount ?? 0, 2) }} FCFA</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-brown-200">
                                <span class="text-orange-700 font-medium">Reste à payer</span>
                                <span class="text-sm font-bold text-orange-600">
                                    {{ number_format($reste_a_payer ?? max(0, $total - ($payment_amount ?? 0)), 2) }} FCFA
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-purple-700 font-medium">Mode de paiement</span>
                                <span class="text-xs font-medium text-purple-800 bg-purple-100 px-2 py-1 rounded">
                                    {{ $payment_mode ?? 'Espèces' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-brown-50 px-6 py-4 border-t border-brown-200 flex justify-end gap-3">
                @if(empty($saleData['reservation']))
                    <button wire:click="generatePdf" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Télécharger PDF
                    </button>
                @endif
                <button wire:click="closeModal" 
                        class="px-4 py-2 border border-brown-300 rounded-lg hover:bg-brown-100 transition-colors text-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>
    @endif
</div>