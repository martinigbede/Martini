{{-- resources/views/public/contact.blade.php --}}
<x-layouts.public>
    <!-- Hero Section Contact -->
    <section class="relative pt-32 pb-20 min-h-[50vh] flex items-center justify-center overflow-hidden">
        <!-- Background avec effet gradient -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-gradient-to-br from-brown-900 via-amber-900 to-brown-800">
                <!-- Pattern subtil en arrière-plan -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1200 600\" opacity=\"0.05\"><defs><pattern id=\"dots\" width=\"30\" height=\"30\" patternUnits=\"userSpaceOnUse\"><circle cx=\"15\" cy=\"15\" r=\"2\" fill=\"white\"/></pattern></defs><rect width=\"1200\" height=\"600\" fill=\"url(%23dots)\"/></svg>')]"></div>
            </div>
            <!-- Overlay dynamique -->
            <div class="absolute inset-0 bg-gradient-to-r from-brown-900/80 via-brown-800/60 to-amber-900/70"></div>
        </div>

        <!-- Éléments décoratifs animés -->
        <div class="absolute top-1/4 right-1/4 w-24 h-24 bg-amber-400/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-1/3 left-1/3 w-32 h-32 bg-brown-500/30 rounded-full blur-2xl animate-bounce"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <!-- Badge élégant -->
            <div class="mb-6">
                <span class="inline-block bg-white/20 backdrop-blur-sm text-white px-6 py-2 rounded-full text-sm font-semibold border border-white/30">
                    💬 Contact & Réservations
                </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-light mb-4 animate-fade-in-up">Contactez-Nous</h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto leading-relaxed animate-fade-in-up animation-delay-200">
                Votre satisfaction est notre priorité. N'hésitez pas à nous contacter pour toute question
            </p>
        </div>
    </section>

    <!-- Section Informations de Contact -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <!-- Carte Adresse -->
                <div class="group bg-gradient-to-br from-brown-50 to-amber-50 rounded-2xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-brown-100 animate-fade-in-up">
                    <div class="w-16 h-16 bg-brown-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-light text-gray-900 mb-4">Notre Adresse</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        123 Avenue de la Plage<br>
                        Miadjoe, <br>
                        Aného, TOGO
                    </p>
                    <div class="mt-6">
                        <button onclick="scrollToMap()" class="inline-flex items-center text-brown-600 hover:text-brown-700 font-medium cursor-pointer transition-all duration-300 hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            Voir sur la carte
                        </button>
                    </div>
                </div>

                <!-- Carte Téléphone -->
                <div class="group bg-gradient-to-br from-brown-50 to-amber-50 rounded-2xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-brown-100 animate-fade-in-up animation-delay-100">
                    <div class="w-16 h-16 bg-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-light text-gray-900 mb-4">Téléphone</h3>
                    <p class="text-gray-600 text-lg mb-2">Réservations & Informations</p>
                    <a href="tel:+22892062121" class="text-2xl font-light text-brown-600 hover:text-brown-700 transition-colors hover:scale-105 inline-block transform duration-300">
                        +228 92 06 21 21
                    </a>
                    <div class="mt-4">
                        <p class="text-gray-600 text-lg mb-2">Service Client</p>
                        <a href="tel:+22896990445" class="text-xl font-light text-amber-600 hover:text-amber-700 transition-colors hover:scale-105 inline-block transform duration-300">
                            +228 96 99 04 45
                        </a>
                    </div>
                </div>

                <!-- Carte Email -->
                <div class="group bg-gradient-to-br from-brown-50 to-amber-50 rounded-2xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-brown-100 animate-fade-in-up animation-delay-200">
                    <div class="w-16 h-16 bg-brown-700 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-light text-gray-900 mb-4">Email</h3>
                    <p class="text-gray-600 text-lg mb-4">Pour toute demande</p>
                    <a href="mailto:contact@miadjoebeachresort.com" class="text-xl font-light text-brown-600 hover:text-brown-700 transition-colors break-all hover:scale-105 inline-block transform duration-300">
                        contact@miadjoebeachresort.com
                    </a>
                    <div class="mt-4">
                        <a href="mailto:reservation@miadjoebeachresort.com" class="text-lg text-amber-600 hover:text-amber-700 transition-colors break-all hover:scale-105 inline-block transform duration-300">
                            reservation@miadjoebeachresort.com
                        </a>
                    </div>
                </div>
            </div>

            <!-- Section Google Maps avec Iframe -->
            <div class="max-w-6xl mx-auto mb-16 animate-fade-in-up animation-delay-300">
                <div class="bg-gradient-to-br from-brown-50 to-amber-50 rounded-2xl p-8 shadow-lg border border-brown-100">
                    <h2 class="text-3xl font-light text-gray-900 mb-8 text-center">Notre Emplacement</h2>
                    
                    <!-- Container de la carte avec animation de chargement -->
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-200">
                        <!-- Loading State -->
                        <div id="mapLoading" class="absolute inset-0 flex items-center justify-center bg-brown-50 z-10 transition-opacity duration-500">
                            <div class="text-center">
                                <div class="w-16 h-16 border-4 border-brown-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                                <p class="text-brown-700 font-semibold">Chargement de la carte...</p>
                            </div>
                        </div>
                        
                        <!-- Iframe Google Maps -->
                        <div class="relative h-96 md:h-[500px]">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.290275841164!2d1.5879507000000002!3d6.2254054!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102393eba90bc107%3A0x8cb5608e0e4479f4!2sMiadjoe%20Beach%20Resort!5e0!3m2!1sfr!2stg!4v1763653773795!5m2!1sfr!2stg" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                onload="hideMapLoading()"
                                class="rounded-xl">
                            </iframe>
                        </div>
                    </div>
                    
                    <!-- Contrôles de la carte -->
                    <div class="flex flex-wrap gap-4 mt-6 justify-center">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=Miadjoe+Beach+Resort+Aného+Togo" 
                           target="_blank"
                           class="bg-brown-600 text-white px-6 py-3 rounded-xl hover:bg-brown-700 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            Itinéraire vers nous
                        </a>
                        <a href="https://www.google.com/maps/place/Miadjoe+Beach+Resort/@6.2254054,1.5879507,17z/data=!3m1!4b1!4m6!3m5!1s0x102393eba90bc107:0x8cb5608e0e4479f4!8m2!3d6.2254054!4d1.5905256!16s%2Fg%2F11v5v9pz4t?entry=ttu" 
                           target="_blank"
                           class="border-2 border-brown-600 text-brown-600 px-6 py-3 rounded-xl hover:bg-brown-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Ouvrir dans Google Maps
                        </a>
                    </div>
                </div>
            </div>

            <!-- Section Formulaire de Contact -->
            <div class="max-w-4xl mx-auto p-8 animate-fade-in-up animation-delay-400">
                @livewire('contact.public-contact-form')
            </div>
        </div>
    </section>

    <!-- Section Horaires -->
    <section class="py-16 bg-gradient-to-b from-white to-amber-50/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-light text-gray-900 mb-12 animate-fade-in-up">Nos Horaires d'Ouverture</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-brown-100 animate-fade-in-left">
                    <h3 class="text-xl font-semibold text-brown-600 mb-4">Réception</h3>
                    <div class="space-y-2 text-gray-600">
                        <p class="flex justify-between"><span>Lundi - Vendredi</span> <span class="font-semibold">7h - 22h</span></p>
                        <p class="flex justify-between"><span>Samedi</span> <span class="font-semibold">8h - 20h</span></p>
                        <p class="flex justify-between"><span>Dimanche</span> <span class="font-semibold">8h - 18h</span></p>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-brown-100 animate-fade-in-right">
                    <h3 class="text-xl font-semibold text-brown-600 mb-4">Service Réservation</h3>
                    <div class="space-y-2 text-gray-600">
                        <p class="flex justify-between"><span>Lundi - Dimanche</span> <span class="font-semibold">24h/24</span></p>
                        <p class="text-sm text-gray-500 mt-4">Par téléphone et en ligne</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA -->
    <section class="py-20 bg-gradient-to-br from-brown-900 to-amber-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-light mb-6 animate-fade-in-up">Prêt à Réserver ?</h2>
            <p class="text-xl text-amber-100/80 mb-8 max-w-2xl mx-auto animate-fade-in-up animation-delay-200">
                Ne tardez pas à vivre l'expérience Miadjoe Beach Resort. 
                Notre équipe est disponible pour vous accompagner.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('public.reservation') }}" 
                   class="bg-white text-brown-800 hover:bg-amber-50 px-8 py-4 rounded-2xl text-lg font-semibold shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center animate-bounce-subtle">
                    Réserver en Ligne
                </a>
                <a href="tel:+22892062121" 
                   class="border-2 border-amber-300 text-amber-100 hover:bg-amber-400/10 px-8 py-4 rounded-2xl text-lg font-semibold transition-all duration-300 flex items-center justify-center hover:scale-105 transform">
                    📞 Appeler Maintenant
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Fonction pour cacher le loading de la carte
        function hideMapLoading() {
            const loadingElement = document.getElementById('mapLoading');
            if (loadingElement) {
                loadingElement.style.opacity = '0';
                setTimeout(() => {
                    loadingElement.style.display = 'none';
                }, 500);
            }
        }

        // Fonction pour scroller vers la carte
        function scrollToMap() {
            const mapSection = document.querySelector('.bg-gradient-to-br.from-brown-50.to-amber-50.rounded-2xl');
            if (mapSection) {
                mapSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }

        // Cacher le loading après un timeout de secours (au cas où l'iframe ne charge pas)
        setTimeout(hideMapLoading, 3000);
    </script>

    <style>
        /* Animations personnalisées */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounceSubtle {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
        }

        .animate-bounce-subtle {
            animation: bounceSubtle 2s ease-in-out infinite;
        }

        .animation-delay-100 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        /* Améliorations responsive pour l'iframe */
        @media (max-width: 768px) {
            .rounded-2xl .h-96 {
                height: 300px !important;
            }
            
            .flex-wrap.gap-4 {
                flex-direction: column;
                align-items: center;
            }
            
            .flex-wrap.gap-4 a {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }
        }

        /* Amélioration du loading */
        #mapLoading {
            background: linear-gradient(135deg, #fef3e2 0%, #f5e6d3 100%);
            border-radius: 1rem;
        }

        /* Style pour l'iframe */
        iframe {
            border-radius: 0.75rem;
        }
    </style>
    @endpush
</x-layouts.public>