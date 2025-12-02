<div>
    {{-- Messages de notification --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-sm">
            <span>{{ session('message') }}</span>
            <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg mb-4 flex items-center justify-between shadow-sm">
            <span>{{ session('warning') }}</span>
            <button type="button" class="text-yellow-700 hover:text-yellow-900" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- Bouton pour créer une nouvelle dépense --}}
    <div class="flex justify-end mb-4">
        <button
            wire:click="openModal"
            wire:loading.attr="disabled"
            class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center space-x-2 active:scale-95 relative">

            <span wire:loading class="absolute left-3 animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>

            <span wire:loading.remove>Nouvelle dépense</span>
            <span wire:loading>Chargement…</span>
        </button>
    </div>

    {{-- Filtres --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        {{-- Boutons --}}
        <div class="flex flex-wrap gap-2">
            <button wire:click="$refresh"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow">
                Actualiser
            </button>

            <button wire:click="exportPdf"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow">
                Exporter PDF
            </button>
        </div>

        {{-- Filtres --}}
        <div class="flex flex-wrap gap-3 items-center">
            {{-- Statut --}}
            <div>
                <label class="text-sm font-medium text-gray-700 mr-2">Statut :</label>
                <select wire:model="filterStatut"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous</option>
                    <option value="en attente">En attente</option>
                    <option value="validée">Validée</option>
                </select>
            </div>

            {{-- Période --}}
            <div class="flex gap-2 items-center">
                <label class="text-sm font-medium text-gray-700">Du :</label>
                <input type="date" wire:model="startDate"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                <label class="text-sm font-medium text-gray-700">Au :</label>
                <input type="date" wire:model="endDate"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    {{-- Table des dépenses --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-brown-200">
        <table class="min-w-full divide-y divide-brown-200">
            <thead class="bg-brown-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Mode de paiement</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-brown-200">
                @forelse($expenses as $expense)
                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $expense->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-900">{{ $expense->categorie }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-900">{{ $expense->description ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brown-900">{{ number_format($expense->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-900">{{ \Carbon\Carbon::parse($expense->date_depense)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-900">{{ $expense->mode_paiement }}</td>
                        <td class="px-4 py-2">
                            @if($expense->statut === 'validée')
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Validée</span>
                            @else
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">En attente</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button wire:click="openModal({{ $expense->id }})"
                                        class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-100 transition-colors duration-200"
                                        title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                <button wire:click="confirmDeleteExpense({{ $expense->id }})"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                        title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center space-y-3 text-brown-500">
                                <svg class="w-12 h-12 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg font-medium">Aucune dépense trouvée</span>
                                <span class="text-sm">Essayez de modifier vos critères de recherche</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Pagination --}}
    <div class="p-4 border-t border-brown-100 bg-brown-50/50">
        {{ $expenses->links() }}
    </div>

    {{-- Modal formulaire --}}
    @if ($showModal)
    <livewire:comptabilite.expense-form-modal :expenseId="$selectedExpenseId" />
    @endif

    {{-- Modal suppression sécurisée --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">

            <h2 class="text-xl font-bold mb-4">Confirmer la suppression</h2>
            <p class="text-gray-600 mb-3">
                Entrez le mot de passe pour supprimer définitivement cette dépense.
            </p>

            <input type="password" wire:model="deletePassword"
                class="w-full border border-gray-300 rounded-lg p-3 mb-2 focus:ring-brown-400 focus:border-brown-400"
                placeholder="Mot de passe">

            @if($errorDeletePassword)
                <p class="text-red-600 text-sm mb-2">{{ $errorDeletePassword }}</p>
            @endif

            <div class="flex justify-end space-x-3 mt-4">
                <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center space-x-2"
                        wire:click="$set('showDeleteModal', false)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Annuler</span>
                </button>

                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center space-x-2"
                        wire:click="deleteExpenseSecure">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Supprimer</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>