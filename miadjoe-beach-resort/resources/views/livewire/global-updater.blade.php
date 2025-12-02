<div class="fixed bottom-6 right-6 flex flex-col items-end space-y-3 z-40">

    <!-- Bouton modernisé -->
    <button
        onclick="Livewire.dispatch('manual-refresh')"
        class="group relative w-14 h-14 rounded-2xl backdrop-blur-xl bg-gradient-to-br from-white/90 to-white/70 shadow-2xl flex items-center justify-center border border-white/40 hover:shadow-3xl transition-all duration-500 ease-out hover:scale-110 hover:-translate-y-1"
        title="Actualiser les données"
    >
        <!-- Effet de brillance au survol -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out rounded-2xl"></div>
        
        <!-- Animation de pulsation subtile -->
        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <!-- Cercle externe animé -->
        <div class="absolute -inset-2 rounded-2xl bg-gradient-to-r from-blue-400/20 to-purple-500/20 opacity-0 group-hover:opacity-100 blur-sm transition-all duration-500 group-hover:scale-110"></div>
        
        <!-- Icône avec animation de rotation au survol -->
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            class="h-7 w-7 text-gray-700 group-hover:text-blue-600 transition-all duration-500 group-hover:rotate-180"
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2"
                d="M4 4v6h6M20 20v-6h-6M5 19a9 9 0 0014.32-1.955M19 5a9 9 0 00-14.32 1.955"
            />
        </svg>
        
        <!-- Point d'indication animé -->
        <div class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            <div class="absolute inset-0 bg-blue-400 rounded-full animate-ping"></div>
        </div>
    </button>
</div>