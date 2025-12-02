{{-- Modal confirmation suppression --}}
@if($showDeleteModal)
<div class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 transition-all duration-300">
    <div class="bg-white rounded-2xl p-8 shadow-2xl w-96 mx-4 transform transition-all duration-300 scale-95 hover:scale-100">
        <!-- En-tête avec icône -->
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Confirmer la suppression</h2>
                <p class="text-sm text-gray-500 mt-1">Action irréversible</p>
            </div>
        </div>

        <!-- Message d'information -->
        <p class="text-gray-600 mb-6 leading-relaxed">
            Pour confirmer la suppression, veuillez saisir votre mot de passe administrateur.
        </p>

        <!-- Champ mot de passe avec option de visibilité -->
        <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Mot de passe de confirmation
            </label>
            <div class="relative">
                <input 
                    type="password" 
                    wire:model="deletePassword" 
                    id="deletePasswordInput"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 pr-12"
                    placeholder="Saisissez votre mot de passe"
                >
                <!-- Bouton toggle visibilité -->
                <button 
                    type="button"
                    onclick="togglePasswordVisibility()"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1"
                >
                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <!-- Message d'erreur -->
            @if($errorDeletePassword)
                <div class="flex items-center space-x-2 text-red-600 text-sm bg-red-50 p-3 rounded-lg border border-red-200">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $errorDeletePassword }}</span>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
            <button 
                wire:click="$set('showDeleteModal', false)" 
                class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 active:scale-95"
            >
                Annuler
            </button>
            <button 
                wire:click="deleteReservationSecure" 
                class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                {{ empty($deletePassword) ? 'disabled' : '' }}
            >
                Supprimer
            </button>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('deletePasswordInput');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}

// Focus sur le champ mot de passe quand le modal s'ouvre
document.addEventListener('livewire:load', function() {
    Livewire.on('showDeleteModalChanged', (value) => {
        if (value) {
            setTimeout(() => {
                const passwordInput = document.getElementById('deletePasswordInput');
                if (passwordInput) {
                    passwordInput.focus();
                }
            }, 100);
        }
    });
});
</script>
@endif