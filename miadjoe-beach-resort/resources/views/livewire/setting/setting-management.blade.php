{{-- resources/views/livewire/setting/setting-management.blade.php --}}
<div>
    {{-- Messages de notification --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6 space-x-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher par Clé ou Libellé..."
               class="form-input rounded-lg shadow-sm mt-1 block w-1/3 border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">

        <div class="flex space-x-3 items-center">
            <select wire:model="perPage" class="form-select rounded-lg shadow-sm border-brown-300 focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50">
                <option value="10">10 / Page</option>
                <option value="25">25 / Page</option>
            </select>

            <button wire:click="openModal"
                    class="bg-brown-600 hover:bg-brown-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Ajouter Paramètre</span>
            </button>
        </div>
    </div>

    {{-- Table des Paramètres --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-brown-200">
        <table class="min-w-full divide-y divide-brown-200">
            <thead class="bg-brown-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Clé</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Libellé</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Valeur</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-brown-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-brown-200">
                @forelse ($settings as $setting)
                    <tr class="hover:bg-brown-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-brown-900">{{ $setting->key }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-brown-900">{{ $setting->label }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-brown-600 break-all max-w-xs">
                                @if(Str::contains($setting->key, 'password') || Str::startsWith($setting->value, '$2y$'))
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-brown-100 text-brown-800 border border-brown-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                        •••••• (masqué)
                                    </span>
                                @else
                                    {{ $setting->value }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                {{-- Bouton Éditer avec icône --}}
                                <button wire:click="edit({{ $setting->id }})" 
                                        class="text-brown-600 hover:text-brown-800 p-2 rounded-lg hover:bg-brown-100 transition-colors duration-200"
                                        title="Éditer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                {{-- Bouton Supprimer avec icône --}}
                                <button wire:click="confirmDelete({{ $setting->id }})"
                                        wire:confirm="Supprimer le paramètre {{ $setting->key }} ?"
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
                        <td colspan="4" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center space-y-3 text-brown-500">
                                <svg class="w-12 h-12 text-brown-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <span class="text-lg font-medium">Aucun paramètre trouvé</span>
                                <span class="text-sm">Commencez par ajouter votre premier paramètre</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $settings->links() }}
    </div>

    {{-- MODAL DE CRÉATION/ÉDITION --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 overflow-y-auto z-50">
            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                {{-- Overlay --}}
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        {{ $isEditing ? 'Modifier le Paramètre' : 'Créer un Nouveau Paramètre' }}
                                    </h3>
                                    <div class="mt-4 space-y-4">
                                        
                                        {{-- Clé (Key) --}}
                                        <div>
                                            <label for="key" class="block text-sm font-medium text-gray-700">Clé (Key - Ex: lit_dappoint_tarif)</label>
                                            <input type="text" id="key" wire:model.defer="key" class="mt-1 block w-full rounded-md border-brown-300 shadow-sm focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50 sm:text-sm" {{ $isEditing ? 'readonly' : '' }}>
                                            @error('key') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            @if ($isEditing) <p class="text-xs mt-1 text-gray-500">La clé ne peut pas être modifiée.</p> @endif
                                        </div>

                                        {{-- Libellé (Label) --}}
                                        <div>
                                            <label for="label" class="block text-sm font-medium text-gray-700">Libellé (Description)</label>
                                            <input type="text" id="label" wire:model.defer="label" class="mt-1 block w-full rounded-md border-brown-300 shadow-sm focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50 sm:text-sm">
                                            @error('label') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- Valeur (Value) --}}
                                        <div class="col-span-2">
                                            <label for="value" class="block text-sm font-medium text-gray-700">Valeur</label>
                                            <input type="text" id="value" wire:model.defer="value" class="mt-1 block w-full rounded-md border-brown-300 shadow-sm focus:border-brown-500 focus:ring focus:ring-brown-200 focus:ring-opacity-50 sm:text-sm">
                                            @error('value') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pied du Modal --}}
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring-green-500 sm:text-sm transition ease-in-out duration-150">
                                    {{ $isEditing ? 'Mettre à Jour' : 'Créer' }}
                                </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button type="button" wire:click="closeModal"
                                        class="w-full inline-flex justify-center rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue-500 sm:text-sm transition ease-in-out duration-150">
                                    Annuler
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>