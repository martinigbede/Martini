{{-- resources/views/livewire/admin/contact-message-inbox.blade.php --}}
<div>
    {{-- Notifications --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <h2 class="text-2xl font-bold mb-4">Boîte de Réception des Contacts</h2>

    <div class="flex justify-between items-center mb-4 space-x-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher par Nom, Email ou Sujet..."
               class="form-input rounded-md shadow-sm mt-1 block w-1/3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

        <div class="flex space-x-2 items-center">
            <select wire:model="statusFilter" wire:change="$dispatch('refreshList')" class="form-select rounded-md shadow-sm border-gray-300">
                <option value="">Tous les Statuts</option>
                <option value="Nouveau">Nouveau</option>
                <option value="En cours">En cours</option>
                <option value="Traité">Traité</option>
            </select>
        </div>
    </div>

    {{-- Table des Messages --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom / Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sujet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($messages as $msg)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $msg->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $msg->nom }}</div>
                            <div class="text-xs text-gray-500">{{ $msg->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $msg->sujet }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($msg->reponse_statut)
                                    @case('Nouveau') bg-red-100 text-red-800 @break
                                    @case('En cours') bg-yellow-100 text-yellow-800 @break
                                    @case('Traité') bg-green-100 text-green-800 @break
                                @endswitch">
                                {{ $msg->reponse_statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                            <button wire:click="viewDetails({{ $msg->id }})" class="text-indigo-600 hover:text-indigo-900">Voir</button>
                            @if($msg->reponse_statut !== 'Traité')
                                <button wire:click="markAs('Traité')" wire:confirm="Marquer ce message comme traité ?" class="text-green-600 hover:text-green-900">Traiter</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun message reçu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $messages->links() }}
    </div>

    {{-- MODAL DE DÉTAILS (À créer: MessageDetailModal) --}}
    @if ($isDetailModalOpen)
        {{-- Placeholder: @livewire('admin.contact-message-detail-modal', ['messageId' => $selectedMessageId], key($selectedMessageId)) --}}
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-xl w-full">
                <h3 class="text-xl font-bold mb-3 border-b pb-2">Détails du Message</h3>
                <p class="text-sm text-red-500">MODALE DE DÉTAIL À CONSTRUIRE</p>
                <button wire:click="$dispatch('closeDetailModal')" class="mt-4 btn-secondary">Fermer</button>
            </div>
        </div>
    @endif
</div>