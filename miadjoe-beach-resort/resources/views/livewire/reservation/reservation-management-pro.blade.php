{{-- resources/views/livewire/reservation/reservation-management-pro.blade.php --}}

<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6 space-x-4">
        <div class="flex space-x-4 flex-1">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher par client..."
                   class="form-input rounded-lg shadow-sm mt-1 block w-1/3 border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">
            <select wire:model="statusFilter" class="border-brown-300 rounded-lg shadow-sm focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50 py-2 px-3">
                <option value="">Tous statuts</option>
                <option value="En attente">En attente</option>
                <option value="Confirmée">Confirmée</option>
                <option value="Annulée">Annulée</option>
            </select>
        </div>
        <button
            wire:click="openFormModal"
            wire:loading.attr="disabled"
            class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-2 px-4 rounded-lg shadow-md
                transition duration-150 ease-in-out flex items-center space-x-2 active:scale-95 relative">

            <!-- Spinner (visible pendant l'action) -->
            <span
                wire:loading
                wire:target="openFormModal"
                class="absolute left-3 animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full">
            </span>

            <!-- Icône cachée pendant le chargement -->
            <svg class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                wire:loading.remove
                wire:target="openFormModal">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4"></path>
            </svg>

            <!-- Texte normal -->
            <span wire:loading.remove wire:target="openFormModal">
                Nouvelle Réservation
            </span>

            <!-- Texte pendant chargement -->
            <span wire:loading wire:target="openFormModal">
                Chargement…
            </span>
        </button>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow border border-brown-200">
        <table class="min-w-full divide-y divide-brown-200">
            <thead class="bg-brown-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Chambre(s)</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Payé</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">À payer</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-brown-200">
                @forelse($reservations as $res)
                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-brown-900">{{ $res['client_nom'] }} {{ $res['client_prenom'] }}</div>
                            <div class="text-xs text-brown-500">{{ $client->email ?? 'Email non renseigné' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($res['rooms'] as $room)
                                    <span class="bg-brown-100 text-brown-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $room }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-700">
                            <div>{{ $res['check_in'] }} → {{ $res['check_out'] }}</div>
                            <div class="text-xs text-brown-500 mt-1">
                                {{ \Carbon\Carbon::parse($res['check_in'])->diffInDays($res['check_out']) }} nuit(s)
                            </div>
                        </td>
                        @php
                            $totalComplet = $res['total'];
                            $paye = $res['paye'];
                            $aPayer = $res['a_payer'];
                        @endphp

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brown-900">
                                {{ number_format($totalComplet, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                {{ number_format($paye, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $aPayer > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                {{ number_format($aPayer, 0, ',', ' ') }} FCFA
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded
                                @if($res['statut'] === 'En attente') bg-gray-200 text-gray-700
                                @elseif($res['statut'] === 'Confirmée') bg-green-100 text-green-700
                                @elseif($res['statut'] === 'Terminée') bg-black text-white
                                @elseif($res['statut'] === 'Annulée') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ $res['statut'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                {{-- Bouton Modifier --}}
                                <button wire:click="openFormModal({{ $res['id'] }})" 
                                        class="text-brown-600 hover:text-brown-800 p-2 rounded-lg hover:bg-brown-100 transition-colors duration-200"
                                        title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                {{-- Bouton Paiement --}}
                                <button wire:click="openPaymentModal({{ $res['id'] }})"
                                        class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-100 transition-colors duration-200"
                                        title="Paiement">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                </button>

                                {{-- Bouton Facture --}}
                                <button wire:click="openDetailsModal({{ $res['id'] }})"
                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-100 transition-colors duration-200"
                                        title="Facture/Detaille">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </button>

                                {{-- Bouton Supprimer --}}
                                <button wire:click="confirmDelete({{ $res['id'] }})"
                                        onclick="confirm('Voulez-vous vraiment supprimer cette réservation ?') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                        title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>

                                {{-- Bouton Notify --}}
                                <button wire:click="openNotifyModal({{ $res['id'] }})"
                                        class="text-indigo-600 hover:text-indigo-800 p-2 rounded-lg hover:bg-indigo-100 transition-colors duration-200"
                                        title="Notifier le client">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V6a2 2 0 00-2-2H3a2 2 0 00-2 2v8a2 2 0 002 2z"/>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-lg font-medium">Aucune réservation trouvée</span>
                                <span class="text-sm">Commencez par créer votre première réservation</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $reservations->links() }}</div>

    {{-- Modal de création / édition --}}
    @if($showFormModal)
        @livewire('reservation.reservation-form-pro', ['reservationId' => $editingReservationId], key($editingReservationId))
    @endif

    {{-- Modal de paiement / prolongation --}}
    @if($showPaymentModal)
        @livewire('reservation.payment-settlement-modal-pro', ['reservationId' => $paymentReservationId], key('payment-'.$paymentReservationId))
    @endif

    {{-- Modal Détails / Facture --}}
    @if($showDetailsModal && $detailsReservationId)
        @livewire('reservation.reservation-details-modal-pro', ['reservationId' => $detailsReservationId], key('details-'.$detailsReservationId))
    @endif

    {{-- Modal de notification --}}
    @if($showNotifyModal && $notifyReservationId)
        <livewire:reservation.reservation-notify-pro-client 
            :reservationId="$notifyReservationId" 
            wire:key="notify-reservation-{{ $notifyReservationId }}" />
    @endif

    {{-- Modal confirmation suppression --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg p-6 shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-3">Confirmer la suppression</h2>
            <p class="text-gray-600 mb-4">Entrez le mot de passe administrateur pour confirmer la suppression :</p>

            <input type="password" wire:model="deletePassword" 
                class="border rounded w-full p-2 mb-2" placeholder="Mot de passe de suppression">

            @if($errorDeletePassword)
                <p class="text-red-600 text-sm mb-2">{{ $errorDeletePassword }}</p>
            @endif

            <div class="flex justify-end space-x-2">
                <button wire:click="$set('showDeleteModal', false)" 
                    class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">
                    Annuler
                </button>
                <button wire:click="deleteReservationSecure" 
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
    @endif
</div>