{{-- resources/views/livewire/admin/contact-message-detail-modal.blade.php --}}
<div class="fixed inset-0 overflow-y-auto z-50" x-data="{ open: @entangle('isOpen') }" x-show="open" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        {{-- Overlay --}}
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" x-on:click="open = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal Panel --}}
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                @if($message)
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-gray-900 border-b pb-2">
                        Message de {{ $message->nom }} ({{ $message->sujet }})
                    </h3>
                    
                    <div class="text-sm text-gray-700 border-b pb-2">
                        <p><strong>Email:</strong> {{ $message->email }}</p>
                        @if($message->telephone)
                            <p><strong>Téléphone:</strong> {{ $message->telephone }}</p>
                        @endif
                        <p><strong>Reçu le:</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-semibold mb-1">Message :</p>
                        <p class="whitespace-pre-wrap">{{ $message->message }}</p>
                    </div>

                    {{-- Section Changement de Statut --}}
                    <div class="border p-3 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-1">Statut de Réponse :</p>
                        <form wire:submit.prevent="updateStatus">
                            <div class="flex space-x-3 items-center">
                                <select wire:model="newStatus" class="form-select flex-grow rounded-md border-gray-300 shadow-sm">
                                    <option value="Nouveau">Nouveau</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Traité">Traité</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                    Mettre à Jour
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                @else
                    <p class="text-center text-red-500">Message non trouvé.</p>
                @endif

                {{-- Pied du Modal --}}
                <div class="bg-gray-50 px-4 py-3 mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button" x-on:click="open = false"
                            class="w-full inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-gray-600 text-base font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>