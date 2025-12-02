{{-- resources/views/public/select-room.blade.php --}}
<x-layouts.public>
    <!-- Hero Section Sélection -->
    <section class="relative pt-32 pb-20 min-h-[40vh] flex items-center justify-center overflow-hidden">
        <!-- Background avec effet gradient -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-gradient-to-br from-brown-900 via-amber-900 to-brown-800">
                <!-- Pattern subtil en arrière-plan -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1200 400\" opacity=\"0.05\"><defs><pattern id=\"grid\" width=\"40\" height=\"40\" patternUnits=\"userSpaceOnUse\"><path d=\"M 40 0 L 0 0 0 40\" fill=\"none\" stroke=\"white\" stroke-width=\"1\"/></pattern></defs><rect width=\"1200\" height=\"400\" fill=\"url(%23grid)\"/></svg>')]"></div>
            </div>
            <!-- Overlay dynamique -->
            <div class="absolute inset-0 bg-gradient-to-r from-brown-900/80 via-brown-800/60 to-amber-900/70"></div>
        </div>

        <!-- Éléments décoratifs animés -->
        <div class="absolute top-1/4 right-1/4 w-20 h-20 bg-amber-400/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-1/3 left-1/3 w-28 h-28 bg-brown-500/30 rounded-full blur-2xl animate-bounce"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <!-- Badge élégant -->
            <div class="mb-6">
                <span class="inline-block bg-white/20 backdrop-blur-sm text-white px-6 py-2 rounded-full text-sm font-semibold border border-white/30">
                    🗓️ Finalisation Réservation
                </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-light mb-4">Sélectionnez Votre Chambre</h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto leading-relaxed">
                Personnalisez votre séjour en choisissant la chambre parfaite et ses options
            </p>
        </div>
    </section>

    <!-- Section Processus de Réservation -->
    <section class="py-12 bg-gradient-to-b from-white to-amber-50/30 border-b border-amber-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Étapes de réservation -->
            <div class="flex justify-center items-center space-x-8">
                <!-- Étape 1 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-brown-600 text-white rounded-full flex items-center justify-center font-semibold text-sm">
                        1
                    </div>
                    <span class="ml-3 text-brown-600 font-semibold">Dates & Type</span>
                </div>
                
                <!-- Flèche -->
                <div class="w-8 h-0.5 bg-brown-300"></div>

                <!-- Étape 2 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-brown-600 text-white rounded-full flex items-center justify-center font-semibold text-sm">
                        2
                    </div>
                    <span class="ml-3 text-brown-600 font-semibold">Sélection</span>
                </div>

                <!-- Flèche -->
                <div class="w-8 h-0.5 bg-brown-300"></div>

                <!-- Étape 3 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-amber-200 text-brown-700 rounded-full flex items-center justify-center font-semibold text-sm">
                        3
                    </div>
                    <span class="ml-3 text-gray-500">Paiement</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Résumé Réservation -->
    <section class="py-8 bg-white border-b border-amber-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                <!-- Informations réservation -->
                <div class="flex items-center space-x-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-brown-100 to-amber-100 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🏨</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Réservation en Cours</h3>
                        <p class="text-gray-600">
                            <span id="checkInDate">--/--/----</span> - <span id="checkOutDate">--/--/----</span> 
                            • <span id="nightsCount">-</span> nuit(s) • <span id="guestsCount">-</span> personne(s)
                        </p>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="flex gap-3">
                    <button class="px-4 py-2 border border-brown-200 text-brown-700 rounded-lg hover:bg-brown-50 transition-colors text-sm font-medium">
                        📅 Modifier dates
                    </button>
                    <button class="px-4 py-2 border border-brown-200 text-brown-700 rounded-lg hover:bg-brown-50 transition-colors text-sm font-medium">
                        👥 Modifier voyageurs
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Sélection Chambre -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Container élégant pour le composant Livewire -->
            <div class="relative">
                <!-- Éléments décoratifs -->
                <div class="absolute -top-6 -left-6 w-24 h-24 bg-amber-200/20 rounded-full blur-xl"></div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-brown-300/10 rounded-full blur-2xl"></div>
                
                <!-- Container principal -->
                <div class="relative bg-white/90 backdrop-blur-sm rounded-3xl border border-amber-100/50 shadow-2xl overflow-hidden">
                    @livewire('public.room-selector-and-payment')
                </div>
            </div>
        </div>
    </section>

    <!-- Section Assistance -->
    <section class="py-16 bg-gradient-to-b from-white to-amber-50/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-brown-100">
                <div class="w-20 h-20 bg-gradient-to-br from-brown-100 to-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <span class="text-2xl">💬</span>
                </div>
                <h3 class="text-2xl font-light text-gray-900 mb-4">Besoin d'Aide ?</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Notre équipe est disponible pour vous accompagner dans votre choix et répondre à toutes vos questions.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="tel:+22501234567" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-brown-600 text-white rounded-xl font-semibold hover:bg-brown-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Nous Appeler
                    </a>
                    <button class="inline-flex items-center justify-center px-6 py-3 border border-brown-200 text-brown-700 rounded-xl font-semibold hover:bg-brown-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        Chat en Direct
                    </button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>

<script>
// Script pour afficher les dates de réservation (à adapter avec vos données réelles)
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les paramètres d'URL ou les données de session
    const urlParams = new URLSearchParams(window.location.search);
    const checkIn = urlParams.get('check_in') || sessionStorage.getItem('checkIn');
    const checkOut = urlParams.get('check_out') || sessionStorage.getItem('checkOut');
    const guests = urlParams.get('guests') || sessionStorage.getItem('guests') || 2;

    if (checkIn && checkOut) {
        // Formater les dates
        const formatDate = (dateString) => {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR');
        };

        // Calculer le nombre de nuits
        const nights = Math.ceil((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24));

        // Mettre à jour l'interface
        document.getElementById('checkInDate').textContent = formatDate(checkIn);
        document.getElementById('checkOutDate').textContent = formatDate(checkOut);
        document.getElementById('nightsCount').textContent = nights;
        document.getElementById('guestsCount').textContent = guests;
    }
});
</script>

<style>
/* Animation pour les étapes */
@keyframes pulse-gentle {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.bg-brown-600 {
    animation: pulse-gentle 2s ease-in-out infinite;
}

/* Transition pour les hover */
.transition-smooth {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Effet de profondeur */
.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
}
</style>