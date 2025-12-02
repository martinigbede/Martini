<x-layouts.public>
    <!-- Hero Section Réservation Moderne (Adapté pour une structure Split View plus systématique) -->
    <section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">
        <!-- Background avec effets avancés -->
        <div class="absolute inset-0 z-0">
            <!-- Image de fond principale (pour le rendu complet, toujours en arrière-plan) -->
            <div class="absolute inset-0">
                <img src="{{ asset('images/reservation-hero.jpg') }}" 
                    alt="Réservation Miadjoe Beach Resort - Chambre luxueuse avec vue mer" 
                    class="w-full h-full object-cover scale-110 animate-zoom-slow"
                    loading="eager"
                    onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1200\" height=\"800\" viewBox=\"0 0 1200 800\"><defs><linearGradient id=\"grad\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"100%\"><stop offset=\"0%\" style=\"stop-color:%23846358;stop-opacity:1\" /><stop offset=\"100%\" style=\"stop-color:%2343302b;stop-opacity:1\" /></linearGradient></defs><rect width=\"1200\" height=\"800\" fill=\"url(%23grad)\"/><text x=\"50%\" y=\"50%\" font-family=\"Arial\" font-size=\"32\" fill=\"white\" text-anchor=\"middle\" dy=\"10\">Miadjoe Beach Resort - Réservation</text></svg>'">
            </div>
            
            <!-- Overlay gradient dynamique -->
            <div class="absolute inset-0 bg-gradient-to-br from-brown-900/85 via-brown-800/70 to-brown-900/90"></div>
            
            <!-- Effet de particules flottantes -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white/30 rounded-full animate-float-1"></div>
                <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-white/40 rounded-full animate-float-2"></div>
                <div class="absolute bottom-1/4 left-1/3 w-3 h-3 bg-white/20 rounded-full animate-float-3"></div>
                <div class="absolute top-1/2 right-1/4 w-1.5 h-1.5 bg-white/25 rounded-full animate-float-4"></div>
            </div>
            
            <!-- Lignes décoratives -->
            <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
        </div>

        <!-- Contenu principal -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <!-- Badge élégant -->
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-6 py-3 mb-8 animate-fade-in-up">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-medium tracking-wide">Réservation en ligne sécurisée</span>
                </div>

                <!-- Titre principal avec effet de découpage -->
                <div class="mb-6 overflow-hidden">
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-bold mb-4 leading-tight">
                        <span class="block bg-gradient-to-r from-white via-white/95 to-white/80 bg-clip-text text-transparent animate-title-slide">
                            Réserver
                        </span>
                        <span class="block bg-gradient-to-r from-amber-200 via-amber-100 to-amber-50 bg-clip-text text-transparent animate-title-slide-delay">
                            Votre Séjour
                        </span>
                    </h1>
                </div>

                <!-- Sous-titre animé -->
                <div class="mb-12 overflow-hidden">
                    <p class="text-lg sm:text-xl lg:text-2xl font-light text-white/90 max-w-4xl mx-auto leading-relaxed animate-subtitle-slide">
                        Vivez une expérience d'exception dans notre 
                        <span class="text-amber-200 font-semibold">resort à l'images de vos goût</span> 
                        au bord de la mer
                    </p>
                </div>
                
                <!-- STRUCTURE DIVISÉE POUR TOUTES LES TAILLES (Texte à Gauche / Aperçu Image à Droite) -->
                <!-- L'utilisation de flex-col/md:flex-row permet d'empiler sur mobile, mais ici on force md:flex-row pour coller au besoin. -->
                <div class="flex flex-col md:flex-row items-center justify-center md:justify-between gap-8 md:gap-12 lg:gap-16 mt-10 md:mt-16">
                    
                    <!-- Contenu Textuel et Boutons (Gauche/Ordre 1) -->
                    <div class="w-full md:w-1/2 lg:w-1/2 text-center md:text-left order-1 md:order-1">
                        <!-- Boutons d'action professionnels -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start"
                            x-data="{ shown: false }" x-intersect:enter="shown = true">
                            <!-- Bouton principal -->
                            <div x-show="shown" 
                                x-transition:enter="transition ease-out duration-1000 delay-1500"
                                x-transition:enter-start="opacity-0 transform translate-y-8"
                                x-transition:enter-end="opacity-100 transform translate-y-0">
                                <a href="#reservation-form" 
                                class="group relative bg-gradient-to-r from-brown-600 to-brown-700 hover:from-brown-700 hover:to-brown-800 text-white px-8 py-4 rounded-full text-base sm:text-lg font-semibold shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center min-w-[200px] overflow-hidden border border-brown-500/30">
                                    <span class="relative z-10 flex items-center">
                                        Réserver Maintenant
                                        <svg class="w-5 h-5 ml-3 relative z-10 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </a>
                            </div>
                            
                            <!-- Bouton secondaire -->
                            <div x-show="shown" 
                                x-transition:enter="transition ease-out duration-1000 delay-1700"
                                x-transition:enter-start="opacity-0 transform translate-y-8"
                                x-transition:enter-end="opacity-100 transform translate-y-0">
                                <a href="#reservation-form" 
                                class="group border-2 border-white/60 hover:border-white text-white px-8 py-4 rounded-full text-base sm:text-lg font-semibold backdrop-blur-lg hover:bg-white/10 transition-all duration-300 flex items-center justify-center min-w-[200px] hover:shadow-xl bg-white/5">
                                    <span class="flex items-center">
                                        Voir les Prix
                                        <svg class="w-5 h-5 ml-3 group-hover:translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bloc Image/Aperçu (Droite/Ordre 2) -->
                    <div class="w-full md:w-1/2 lg:w-1/2 mt-8 md:mt-0 order-2 md:order-2">
                        <!-- L'image devient un aperçu contraint -->
                        <div class="relative w-full aspect-[16/9] max-h-[300px] mx-auto rounded-xl overflow-hidden shadow-2xl border-4 border-amber-300/50">
                            <img src="{{ asset('images/reservation-hero.jpg') }}" 
                                alt="Aperçu de la chambre" 
                                class="w-full h-full object-cover"
                                loading="eager"
                                onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"400\" height=\"225\" viewBox=\"0 0 400 225\"><defs><linearGradient id=\"grad\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"100%\"><stop offset=\"0%\" style=\"stop-color:%23f2e8e5;stop-opacity:1\" /><stop offset=\"100%\" style=\"stop-color:%23e0cec7;stop-opacity:1\" /></linearGradient></defs><rect width=\"400\" height=\"225\" fill=\"url(%23grad)\"/><text x=\"50%\" y=\"50%\" font-family=\"Arial\" font-size=\"20\" fill=\"%23846358\" text-anchor=\"middle\" dy=\"10\">Aperçu Chambre</text></svg>'">
                        </div>
                    </div>
                </div>
                
                <!-- Indicateur de défilement -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
                    <div class="flex flex-col items-center text-white/70">
                        <span class="text-sm mb-2 tracking-wider">DÉFILER</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- Élément décoratif flottant (Masqué sur mobile < md) -->
        <div class="absolute right-10 top-1/4 transform -translate-y-1/2 hidden md:block">
            <div class="relative">
                <div class="w-20 h-20 bg-amber-400/20 rounded-full blur-xl animate-pulse-slow"></div>
                <div class="absolute inset-0 w-20 h-20 border-2 border-amber-400/30 rounded-full animate-spin-slow"></div>
            </div>
        </div>

        <!-- Élément décoratif gauche (Masqué sur mobile < md) -->
        <div class="absolute left-10 bottom-1/4 transform translate-y-1/2 hidden md:block">
            <div class="relative">
                <div class="w-16 h-16 bg-white/10 rounded-full blur-lg animate-pulse-slower"></div>
                <div class="absolute inset-0 w-16 h-16 border border-white/20 rounded-full animate-ping-slow"></div>
            </div>
        </div>
    </section>

    <!-- Section Réservation Principale (Inchangée) -->
    <section class="py-16 bg-gradient-to-b from-white to-brown-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Formulaire de Réservation -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-2xl border border-brown-100 overflow-hidden">
                        <!-- En-tête du formulaire -->
                        <div class="bg-gradient-to-r from-brown-600 to-brown-800 px-8 py-6 text-white">
                            <h2 class="text-2xl font-light mb-2">Votre Réservation</h2>
                            <p class="text-brown-100">Complétez les informations pour votre séjour</p>
                        </div>
                        
                        <!-- Contenu du formulaire Livewire -->
                        <div class="p-8" id="reservation-form">
                            @livewire('reservation.public-booking-form')
                        </div>
                    </div>

                    <!-- Informations supplémentaires -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-brown-100 text-center">
                            <div class="w-12 h-12 bg-brown-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-brown-900 mb-2">Meilleur Prix Garanti</h3>
                            <p class="text-sm text-gray-600">Réservez directement et bénéficiez des meilleurs tarifs</p>
                        </div>
                        
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-brown-100 text-center">
                            <div class="w-12 h-12 bg-brown-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-brown-900 mb-2">Annulation Flexible</h3>
                            <p class="text-sm text-gray-600">Annulation gratuite jusqu'à 48h avant l'arrivée</p>
                        </div>
                        
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-brown-100 text-center">
                            <div class="w-12 h-12 bg-brown-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-brown-900 mb-2">Support 24/7</h3>
                            <p class="text-sm text-gray-600">Notre équipe est disponible pour vous accompagner</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Informations -->
                <div class="lg:col-span-1">
                    <!-- Résumé Réservation (Sticky sur Desktop) -->
                    <div class="bg-white rounded-2xl shadow-2xl border border-brown-100 sticky top-8">
                        <div class="bg-brown-50 px-6 py-4 border-b border-brown-100">
                            <h3 class="text-lg font-semibold text-brown-900">Votre Séjour</h3>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Image chambre -->
                            <div class="rounded-xl overflow-hidden shadow-md">
                                <img src="{{ asset('images/chambre-preview.jpg') }}" 
                                     alt="Aperçu chambre Miadjoe Beach Resort" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"400\" height=\"200\" viewBox=\"0 0 400 200\"><defs><linearGradient id=\"grad\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"100%\"><stop offset=\"0%\" style=\"stop-color:%23f2e8e5;stop-opacity:1\" /><stop offset=\"100%\" style=\"stop-color:%23e0cec7;stop-opacity:1\" /></linearGradient></defs><rect width=\"400\" height=\"200\" fill=\"url(%23grad)\"/><text x=\"50%\" y=\"50%\" font-family=\"Arial\" font-size=\"16\" fill=\"%23846358\" text-anchor=\"middle\" dy=\"10\">Chambre de Luxe</text></svg>'">
                            </div>
                            
                            <!-- Détails séjour -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center pb-3 border-b border-brown-100">
                                    <span class="text-gray-600">Type de chambre</span>
                                    <span class="font-semibold text-brown-900">Standard</span>
                                </div>
                                
                                <div class="flex justify-between items-center pb-3 border-b border-brown-100">
                                    <span class="text-gray-600">Durée</span>
                                    <span class="font-semibold text-brown-900">1 nuits</span>
                                </div>
                                
                                <div class="flex justify-between items-center pb-3 border-b border-brown-100">
                                    <span class="text-gray-600">Voyageurs</span>
                                    <span class="font-semibold text-brown-900">2 adultes</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-lg font-semibold pt-2">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-brown-600">60.000 FCFA</span>
                                </div>
                            </div>
                            
                            <!-- Services inclus -->
                            <div class="bg-brown-50 rounded-lg p-4">
                                <h4 class="font-semibold text-brown-900 mb-3">Services inclus</h4>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-brown-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Petit-déjeuner buffet
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-brown-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Accès spa & piscine
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-brown-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Wi-Fi gratuit
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-brown-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Stationnement sécurisé
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Assistance -->
                    <div class="mt-6 bg-gradient-to-r from-brown-600 to-brown-800 rounded-2xl p-6 text-white text-center">
                        <h3 class="text-lg font-semibold mb-2">Besoin d'aide ?</h3>
                        <p class="text-brown-100 mb-4 text-sm">Notre équipe est à votre disposition</p>
                        <a href="tel:+22892062121" class="inline-flex items-center bg-white text-brown-700 px-4 py-2 rounded-lg font-semibold hover:bg-brown-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +228 92 06 21 21
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Témoignages (Inchangée) -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-light text-gray-900 mb-12">Ils Nous Ont Fait Confiance</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Témoignage 1 -->
                <div class="bg-brown-50 rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 bg-brown-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"Un séjour exceptionnel ! Le service est impeccable et le cadre magnifique."</p>
                    <div class="font-semibold text-brown-900">Marie L.</div>
                    <div class="text-sm text-gray-500">Paris, France</div>
                </div>
                
                <!-- Témoignage 2 -->
                <div class="bg-brown-50 rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 bg-brown-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"La réservation était simple et rapide. Nous reviendrons certainement !"</p>
                    <div class="font-semibold text-brown-900">Thomas B.</div>
                    <div class="text-sm text-gray-500">Lyon, France</div>
                </div>
                
                <!-- Témoignage 3 -->
                <div class="bg-brown-50 rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 bg-brown-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"Une expérience 5 étoiles du début à la fin. Je recommande vivement !"</p>
                    <div class="font-semibold text-brown-900">Sophie M.</div>
                    <div class="text-sm text-gray-500">Bruxelles, Belgique</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Animations personnalisées */
        @keyframes zoom-slow {
            0% { transform: scale(1.1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1.1); }
        }

        @keyframes float-1 {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-20px) translateX(10px); }
        }

        @keyframes float-2 {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(15px) translateX(-15px); }
        }

        @keyframes float-3 {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-15px) translateX(-10px); }
        }

        @keyframes float-4 {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(10px) translateX(15px); }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes title-slide {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes subtitle-slide {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.5; }
        }
        
        @keyframes pulse-slower {
            0%, 100% { opacity: 0.1; }
            50% { opacity: 0.3; }
        }

        .animate-zoom-slow {
            animation: zoom-slow 20s ease-in-out infinite;
        }

        .animate-float-1 {
            animation: float-1 8s ease-in-out infinite;
        }

        .animate-float-2 {
            animation: float-2 12s ease-in-out infinite;
        }

        .animate-float-3 {
            animation: float-3 10s ease-in-out infinite;
        }

        .animate-float-4 {
            animation: float-4 15s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out;
        }

        .animate-title-slide {
            animation: title-slide 1.2s ease-out;
        }

        .animate-title-slide-delay {
            animation: title-slide 1.2s ease-out 0.3s both;
        }

        .animate-subtitle-slide {
            animation: subtitle-slide 1.5s ease-out 0.6s both;
        }

        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }

        .animate-pulse-slow {
            animation: pulse-slow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-pulse-slower {
            animation: pulse-slower 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-ping-slow {
            animation: ping 3s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        /* Optimisations pour le responsive - Masque les effets lourds sur mobile */
        @media (max-width: 767px) {
            .animate-title-slide,
            .animate-title-slide-delay {
                animation: fade-in-up 1s ease-out;
            }
            .animate-float-1, .animate-float-2, .animate-float-3, .animate-float-4, .animate-spin-slow, .animate-pulse-slow, .animate-pulse-slower, .animate-ping-slow {
                animation: none; /* Désactive les animations lourdes sur mobile */
            }
            .animate-zoom-slow {
                animation: none; /* Désactive le zoom lent */
                transform: scale(1.1); /* Garde un léger zoom statique */
            }
        }
    </style>

    <!-- Script pour les interactions supplémentaires -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Effet de parallaxe sur l'image de fond
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelector('.animate-zoom-slow');
                // On désactive la parallaxe si l'écran est petit
                if (window.innerWidth >= 768 && parallax) {
                   parallax.style.transform = `scale(${1.1 + scrolled * 0.0001})`;
                } else if (parallax) {
                   parallax.style.transform = 'scale(1.1)';
                }
            });

            // Animation d'entrée progressive des éléments
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observer les éléments animés
            const animatedElements = document.querySelectorAll('.animate-fade-in-up, .animate-title-slide, .animate-subtitle-slide');
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
</x-layouts.public>