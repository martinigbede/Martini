{{-- resources/views/livewire/sale/sale-form-modal.blade.php --}}
<div>
    <div x-data="{ open: @entangle('isModalOpen') }" @keydown.escape.window="$wire.closeModal()" class="fixed inset-0 z-50 overflow-y-auto" x-show="open" style="display: none;">
        {{-- BACKGROUND --}}
        <div @click="$wire.closeModal()" class="fixed inset-0 bg-brown-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen px-4 py-4 text-center sm:p-0">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            {{-- CONTENU DU MODAL --}}
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-brown-200" @click.away="open = false">
                <form wire:submit.prevent="save" class="bg-white">
                    {{-- HEADER --}}
                    <div class="bg-brown-700 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">
                                    {{ $isEditing ? '📝 Modifier la Vente' : '➕ Nouvelle Vente' }}
                                </h3>
                                <p class="text-brown-200 text-xs">Gestion des ventes</p>
                            </div>
                            <button type="button" wire:click="closeModal" @click="open = false"
                                    class="text-brown-200 hover:text-white p-1 rounded transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="px-6 pt-6 pb-4 max-h-[70vh] overflow-y-auto">
                        {{-- RÉSERVATION --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-brown-800 mb-2">Réservation (optionnel)</label>
                            <select wire:model="reservation_id" wire:change="$refresh"
                                    class="w-full border border-brown-200 rounded-lg focus:border-brown-500 focus:ring-1 focus:ring-brown-500 py-2.5 px-3 text-sm bg-white">
                                <option value="">-- Pas de réservation --</option>
                                @foreach($reservations as $reservation)
                                    <option value="{{ $reservation['id'] }}">
                                        Réservation #{{ $reservation['id'] }} — 
                                        Chambre {{ $reservation['room']['numero'] ?? 'N/A' }} 
                                        ({{ $reservation['client']['nom'] ?? 'Client inconnu' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- LISTE DES ITEMS --}}
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between border-b border-brown-200 pb-3">
                                <h4 class="text-sm font-semibold text-brown-800">Articles</h4>
                                <span class="text-xs font-medium text-brown-600 bg-brown-100 px-2 py-1 rounded">
                                    {{ count($items) }} article(s)
                                </span>
                            </div>

                            @foreach($items as $index => $item)
                                <div class="border border-brown-200 p-4 rounded-lg relative bg-white"
                                     wire:key="item-{{ $index }}">
                                    @if(count($items) > 1)
                                        <button type="button" wire:click="removeItem({{ $index }})"
                                                class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                            ✕
                                        </button>
                                    @endif

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        {{-- Menu --}}
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-brown-700 mb-1">Plat / Menu</label>
                                            <select wire:model="items.{{ $index }}.menu_id" wire:change="$refresh"
                                                    class="w-full border border-brown-200 rounded text-sm py-2 px-3">
                                                <option value="">-- Sélectionner un plat --</option>
                                                @foreach($menus as $menu)
                                                    <option value="{{ $menu['id'] }}">
                                                        {{ $menu['nom'] }} — {{ number_format($menu['prix'], 2) }} FCFA
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Unité --}}
                                        @php
                                            $menuSelected = collect($menus)->firstWhere('id', $item['menu_id']);
                                            $units = $menuSelected['units'] ?? [];
                                        @endphp

                                        @if(!empty($units))
                                            <div>
                                                <label class="block text-xs font-medium text-brown-700 mb-1">Unité</label>
                                                <select wire:model="items.{{ $index }}.unite" wire:change="$refresh"
                                                        class="w-full border border-brown-200 rounded text-sm py-2 px-3">
                                                    <option value="">-- Choisir une unité --</option>
                                                    @foreach($units as $u)
                                                        <option value="{{ $u['unit'] }}">
                                                            {{ ucfirst($u['unit']) }} — {{ number_format($u['price'], 2) }} FCFA
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        {{-- Quantité --}}
                                        <div>
                                            <label class="block text-xs font-medium text-brown-700 mb-1">Quantité</label>
                                            <div class="flex items-center space-x-2">
                                                <button type="button" wire:click="decrementQuantity({{ $index }})"
                                                        class="w-8 h-8 bg-brown-100 text-brown-700 rounded hover:bg-brown-200 transition-colors flex items-center justify-center text-sm">
                                                    -
                                                </button>
                                                <input type="number" min="1" wire:model="items.{{ $index }}.quantite" wire:change="$refresh"
                                                       class="flex-1 border border-brown-200 rounded text-center py-1 px-2 text-sm w-16">
                                                <button type="button" wire:click="incrementQuantity({{ $index }})"
                                                        class="w-8 h-8 bg-brown-100 text-brown-700 rounded hover:bg-brown-200 transition-colors flex items-center justify-center text-sm">
                                                    +
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Article offert --}}
                                        <div class="flex items-center space-x-2">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model="items.{{ $index }}.est_offert" wire:change="$refresh" class="sr-only peer">
                                                <div class="w-8 h-4 bg-brown-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-brown-600"></div>
                                            </label>
                                            <span class="text-xs text-brown-600">Offert</span>
                                        </div>
                                    </div>

                                    {{-- Remise --}}
                                    <div class="grid grid-cols-2 gap-3 mt-3 pt-3 border-t border-brown-100">
                                        <div>
                                            <label class="block text-xs font-medium text-brown-700 mb-1">Type remise</label>
                                            <select wire:model="items.{{ $index }}.remise_type" wire:change="$refresh"
                                                    class="w-full border border-brown-200 rounded text-sm py-1 px-2">
                                                <option value="">-- Aucune --</option>
                                                <option value="pourcentage">Pourcentage %</option>
                                                <option value="montant">Montant fixe</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-brown-700 mb-1">Valeur remise</label>
                                            <input type="number" wire:model="items.{{ $index }}.remise_valeur" wire:change="$refresh"
                                                   class="w-full border border-brown-200 rounded text-sm py-1 px-2"
                                                   placeholder="0">
                                        </div>
                                    </div>

                                    {{-- Totaux article --}}
                                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-brown-100 text-xs">
                                        <div>
                                            <span class="text-brown-600">Prix unitaire:</span>
                                            <span class="font-semibold text-brown-800 ml-1">
                                                {{ number_format($item['prix_unitaire'] ?? 0, 2) }} FCFA
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-brown-600">Total article:</span>
                                            <span class="font-bold {{ $item['est_offert'] ? 'text-green-600' : 'text-brown-800' }} ml-1">
                                                {{ number_format($item['total'] ?? 0, 2) }} FCFA
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- BOUTON AJOUTER PLAT --}}
                        <div class="flex justify-center mb-6">
                            <button type="button" wire:click="addItem"
                                    class="flex items-center space-x-2 px-4 py-2 bg-brown-600 text-white rounded-lg hover:bg-brown-700 transition-colors text-sm">
                                <span>+</span>
                                <span>Ajouter un plat</span>
                            </button>
                        </div>

                        {{-- TOTAL --}}
                        <div class="bg-brown-50 p-4 rounded-lg border border-brown-200 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-brown-800">Total Vente :</span>
                                <span class="text-xl font-bold text-brown-800">
                                    {{ number_format($total, 2) }} FCFA
                                </span>
                            </div>
                        </div>

                        {{-- DATE --}}
                        <div>
                            <label class="block text-sm font-medium text-brown-800 mb-2">Date de la Vente</label>
                            <input type="date" wire:model="date"
                                   class="w-full border border-brown-200 rounded-lg py-2.5 px-3 text-sm">
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="bg-brown-50 px-6 py-4 border-t border-brown-200">
                        <div class="flex flex-col sm:flex-row gap-3 justify-end">
                            <button type="button" wire:click="closeModal" @click="open = false"
                                    class="order-2 sm:order-1 w-full sm:w-auto px-4 py-2 border border-brown-300 text-brown-700 rounded-lg hover:bg-brown-100 transition-colors text-sm">
                                Annuler
                            </button>

                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    class="order-1 sm:order-2 w-full sm:w-auto px-4 py-2 bg-brown-600 text-white rounded-lg hover:bg-brown-700 transition-colors text-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">

                                <span wire:loading.remove>
                                    {{ $isEditing ? 'Mettre à jour' : 'Enregistrer' }}
                                </span>

                                <span wire:loading class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Traitement…
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>