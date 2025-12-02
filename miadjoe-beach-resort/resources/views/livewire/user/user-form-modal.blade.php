{{-- MODAL DE CRÉATION/ÉDITION --}}
@if ($isModalOpen)
    <div class="fixed inset-0 overflow-y-auto z-50">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            {{-- Overlay --}}
            <div class="fixed inset-0 transition-opacity bg-brown-900 bg-opacity-50" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal Panel --}}
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-brown-200">
                <form wire:submit.prevent="{{ $isEditing ? 'save' : 'save' }}">
                    {{-- En-tête du modal --}}
                    <div class="bg-gradient-to-r from-brown-600 to-brown-800 px-6 py-4">
                        <h3 class="text-xl font-semibold text-white" id="modal-title">
                            {{ $isEditing ? '👤 Modifier l\'Utilisateur' : '👤 Créer un Nouvel Utilisateur' }}
                        </h3>
                    </div>

                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Champ Nom --}}
                            <div>
                                <label for="name_field" class="block text-sm font-medium text-brown-700 mb-2">Nom</label>
                                <input type="text" id="name_field" wire:model.defer="name" 
                                       class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                @error('name') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Champ Prénom --}}
                            <div>
                                <label for="prenom_field" class="block text-sm font-medium text-brown-700 mb-2">Prénom</label>
                                <input type="text" id="prenom_field" wire:model.defer="prenom" 
                                       class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                @error('prenom') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Champ Email --}}
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-brown-700 mb-2">Email</label>
                                <input type="email" id="email" wire:model.defer="email" 
                                       class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50 {{ $isEditing ? 'bg-brown-100 cursor-not-allowed' : '' }}" 
                                       {{ $isEditing ? 'readonly' : '' }}>
                                @error('email') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Champ Téléphone --}}
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-brown-700 mb-2">Téléphone</label>
                                <input type="text" id="telephone" wire:model.defer="telephone" 
                                       class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                @error('telephone') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Champ Statut --}}
                            <div>
                                <label for="statut" class="block text-sm font-medium text-brown-700 mb-2">Statut</label>
                                <select id="statut" wire:model.defer="statut" 
                                        class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                    <option value="actif" class="text-brown-700">Actif</option>
                                    <option value="inactif" class="text-brown-700">Inactif</option>
                                </select>
                                @error('statut') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Champ Rôle (Spatie) --}}
                            <div class="md:col-span-2">
                                <label for="role_id" class="block text-sm font-medium text-brown-700 mb-2">Rôle</label>
                                <select id="role_id" wire:model.defer="role_id" 
                                        class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                    <option value="" class="text-brown-400">-- Choisir un rôle --</option>
                                    @foreach($allRoles as $role)
                                        <option value="{{ $role->id }}" class="text-brown-700">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Champ Mot de Passe --}}
                            <div class="{{ $isEditing ? 'md:col-span-1' : 'md:col-span-2' }}">
                                <label for="password" class="block text-sm font-medium text-brown-700 mb-2">Mot de Passe</label>
                                <input type="password" id="password" wire:model.defer="password" 
                                       class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                @error('password') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Champ Confirmation Mot de Passe --}}
                            @if (!$isEditing || $password)
                                <div class="md:col-span-1">
                                    <label for="password_confirmation" class="block text-sm font-medium text-brown-700 mb-2">Confirmation MP</label>
                                    <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" 
                                           class="mt-1 block w-full rounded-xl border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 transition-colors duration-200 py-3 px-4 bg-brown-50/50">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Pied du Modal --}}
                    <div class="bg-gradient-to-r from-brown-50 to-amber-50 px-6 py-4 border-t border-brown-200">
                        <div class="flex flex-col sm:flex-row gap-3 justify-end">
                            <button type="button" wire:click="closeModal"
                                    class="order-2 sm:order-1 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border-2 border-brown-300 text-brown-700 font-medium rounded-xl hover:bg-brown-100 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Annuler
                            </button>
                            <button type="submit"
                                    class="order-1 sm:order-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $isEditing ? 'Mettre à Jour' : 'Créer' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif