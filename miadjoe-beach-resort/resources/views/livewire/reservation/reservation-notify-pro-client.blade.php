<div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">

        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            ✉️ Notifier le client : {{ $clientName }}
        </h2>

        {{-- Messages --}}
        @if (session('message'))
            <div class="p-3 mb-3 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-3 mb-3 text-sm text-red-700 bg-red-100 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4">

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input type="email" wire:model.defer="clientEmail" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('clientEmail') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Template --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Modèle d’email</label>
                <select wire:model.defer="template" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="confirmation">📩 Confirmation de réservation</option>
                    <option value="facture">💰 Envoi de facture</option>
                    <option value="rappel">⏰ Rappel de réservation</option>
                </select>
                @error('template') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Sujet --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Sujet</label>
                <input type="text" wire:model.defer="subject" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('subject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Message --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Message</label>
                <textarea wire:model.defer="messageContent" rows="5" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                @error('messageContent') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Pièce jointe PDF --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Joindre une facture (PDF)</label>
                <input type="file" wire:model="attachment" accept="application/pdf"
                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                @error('attachment') 
                    <span class="text-xs text-red-500">{{ $message }}</span> 
                @enderror

                {{-- Prévisualisation du fichier sélectionné --}}
                @if ($attachment)
                    <p class="text-sm text-green-600 mt-2">
                        📎 Fichier sélectionné : <span class="font-medium">{{ $attachment->getClientOriginalName() }}</span>
                    </p>
                @endif
            </div>

        </div>

        {{-- Actions --}}
        <div class="flex justify-end space-x-3 mt-6">

            <button wire:click="closeModal" type="button"
                class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                Fermer
            </button>

            <button wire:click="sendNotification" type="button"
                class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Envoyer</span>
                <span wire:loading>Envoi...</span>
            </button>

        </div>

    </div>
</div>
