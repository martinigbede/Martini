<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-brown-200">

        <h1 class="text-2xl font-bold mb-6 text-brown-900">👥 Gestion des Utilisateurs</h1>

        {{-- Messages de notification --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Filtres et Bouton d'Ajout --}}
        <div class="flex justify-between items-center mb-6 space-x-4">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher par nom, prénom ou email..."
                   class="form-input rounded-lg shadow-sm mt-1 block w-1/3 border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">

            <div class="flex space-x-3">
                <select wire:model="statusFilter" class="form-select rounded-lg shadow-sm border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">
                    <option value="actif">Actifs</option>
                    <option value="inactif">Inactifs</option>
                    <option value="">Tous les statuts</option>
                </select>

                <select wire:model="roleFilter" class="form-select rounded-lg shadow-sm border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">
                    <option value="">Tous les rôles</option>
                    @foreach ($allRoles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <button wire:click="openModal"
                        class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Ajouter Utilisateur</span>
                </button>
            </div>
        </div>

        {{-- Table des Utilisateurs --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow border border-brown-200">
            <table class="min-w-full divide-y divide-brown-200">
                <thead class="bg-brown-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Nom & Prénom</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-brown-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-brown-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-brown-500 to-brown-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-brown-900">{{ $user->name }} {{ $user->prenom }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-brown-600">{{ $user->telephone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->roles->count())
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                        {{ $user->roles->first()->name }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Aucun rôle
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->statut === 'actif' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                    {{ ucfirst($user->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    {{-- Bouton Éditer avec icône --}}
                                    <button wire:click="edit({{ $user->id }})" 
                                            class="text-brown-600 hover:text-brown-800 p-2 rounded-lg hover:bg-brown-100 transition-colors duration-200"
                                            title="Éditer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    {{-- Bouton Réinitialiser MP avec icône --}}
                                    <button wire:click="resetPassword({{ $user->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir réinitialiser le mot de passe de {{ $user->name }} ?"
                                            class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-100 transition-colors duration-200"
                                            title="Réinitialiser mot de passe">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </button>

                                    {{-- Bouton Supprimer avec icône --}}
                                    <button wire:click="delete({{ $user->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer {{ $user->name }} ?"
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
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center space-y-3 text-brown-500">
                                    <svg class="w-12 h-12 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <span class="text-lg font-medium">Aucun utilisateur trouvé</span>
                                    <span class="text-sm">Essayez de modifier vos critères de recherche</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
    {{-- MODAL FORMULAIRE (Création/Édition) --}}
    @if ($isModalOpen)
        @include('livewire.user.user-form-modal')
    @endif
</div>