{{-- resources/views/public/home.blade.php --}}
<x-layouts.public>
    <!-- Hero Section avec structure adaptée pour Mobile/App-like -->
    <!-- Hero Section avec structure adaptée pour Mobile/App-like -->
    <section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden bg-brown-900">
        <!-- Overlay pour le contraste -->
        <div class="absolute inset-0 bg-gradient-to-r from-brown-900/80 via-brown-900/40 to-brown-800/60 z-0"></div>

        <!-- Conteneur principal adaptable -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            <!-- STRUCTURE ADAPTABLE : Contenu centré sur mobile, split sur md+ -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12 lg:gap-16 py-16 md:py-24">
                
                <!-- 1. Contenu Textuel & Boutons (Gauche sur MD+, Empilé sur Mobile) -->
                <div class="w-full md:w-1/2 lg:w-1/2 text-center md:text-left order-1 md:order-1">
                    
                    <!-- Badge élégant -->
                    <div class="mb-6" x-data="{ shown: false }" x-intersect:enter="shown = true">
                        <span x-show="shown" 
                            x-transition:enter="transition ease-out duration-1000 delay-300"
                            x-transition:enter-start="opacity-0 transform translate-y-8"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="inline-block bg-white/20 backdrop-blur-lg text-white px-5 py-2 rounded-full text-xs sm:text-sm font-semibold border border-white/30 shadow-lg tracking-wider">
                            ★ Resort Elegant & Spa
                        </span>
                    </div>

                    <!-- Titre principal professionnel -->
                    <div class="mb-6" x-data="{ shown: false }" x-intersect:enter="shown = true">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-light tracking-tight leading-snug md:leading-tight">
                            <span x-show="shown" 
                                x-transition:enter="transition ease-out duration-1000 delay-500"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="block text-white font-normal">
                                Miadjoe Beach
                            </span>
                            <span x-show="shown" 
                                x-transition:enter="transition ease-out duration-1000 delay-700"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="block text-3xl sm:text-4xl lg:text-5xl font-serif italic mt-2 text-brown-200 font-light">
                                Resort & Spa Premium
                            </span>
                        </h1>
                    </div>
                    
                    <!-- Sous-titre professionnel -->
                    <div class="mb-10" x-data="{ shown: false }" x-intersect:enter="shown = true">
                        <p x-show="shown" 
                        x-transition:enter="transition ease-out duration-1000 delay-1300" 
                        class="text-base sm:text-lg text-white/95 font-light max-w-xl mx-auto md:mx-0 leading-relaxed tracking-wide">
                            Un sanctuaire de luxe où l'élégance contemporaine rencontre la sérénité naturelle des plages préservées du Togo.
                        </p>
                    </div>

                    <!-- Boutons d'action professionnels -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start"
                        x-data="{ shown: false }" x-intersect:enter="shown = true">
                        <!-- Bouton principal -->
                        <div x-show="shown" 
                            x-transition:enter="transition ease-out duration-1000 delay-1500"
                            x-transition:enter-start="opacity-0 transform translate-y-8"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                            <a href="{{ route('public.reservation') }}" 
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
                            <a href="#decouvrir" 
                            class="group border-2 border-white/60 hover:border-white text-white px-8 py-4 rounded-full text-base sm:text-lg font-semibold backdrop-blur-lg hover:bg-white/10 transition-all duration-300 flex items-center justify-center min-w-[200px] hover:shadow-xl bg-white/5">
                                <span class="flex items-center">
                                    Explorer le Resort
                                    <svg class="w-5 h-5 ml-3 group-hover:translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- 2. Bloc Carousel (Position 3 sur Mobile, Droite sur MD+) -->
                <div class="w-full md:w-1/2 lg:w-1/2 mt-10 md:mt-0 order-3 md:order-2"
                     x-data="{
                        currentSlide: 0,
                        slides: 5,
                        direction: 1,
                        next() {
                            this.direction = 1;
                            this.currentSlide = (this.currentSlide + 1) % this.slides;
                        },
                        prev() {
                            this.direction = -1;
                            this.currentSlide = (this.currentSlide - 1 + this.slides) % this.slides;
                        }
                    }" 
                    x-init="setInterval(() => next(), 5000)"
                >
                    <!-- Conteneur du carousel -->
                    <div class="relative w-full aspect-[16/10] md:aspect-[4/3] max-h-[400px] rounded-xl overflow-hidden shadow-2xl border-4 border-white/20">
                        
                        <!-- Slides -->
                        <template x-for="i in slides" :key="i">
                            <div x-show="currentSlide === i-1" 
                                 x-transition:enter="transition ease-out duration-1000"
                                 x-transition:enter-start="opacity-0 transform scale-110"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-1000"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-110"
                                 class="absolute inset-0">
                                <img :src="`{{ asset('images/hero-beach-resort-${i}.jpg') }}`" 
                                     :alt="`Miadjoe Beach Resort - Vue ${i}`" 
                                     class="w-full h-full object-cover"
                                     loading="lazy"
                                     onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'1200\' height=\'800\' viewBox=\'0 0 1200 800\'><defs><linearGradient id=\'grad\' x1=\'0%\' y1=\'0%\' x2=\'100%\' y2=\'100%\'><stop offset=\'0%\' style=\'stop-color:%23a18072;stop-opacity:1\' /><stop offset=\'100%\' style=\'stop-color:%2343302b;stop-opacity:1\' /></linearGradient></defs><rect width=\'1200\' height=\'800\' fill=\'url(%23grad)\'/><text x=\'50%\' y=\'50%\' font-family=\'Arial\' font-size=\'24\' fill=\'white\' text-anchor=\'middle\'>Miadjoe Beach Resort</text></svg>'">
                            </div>
                        </template>
                        
                        <!-- Indicateurs modernes du carousel -->
                        <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                            <template x-for="i in slides" :key="i">
                                <button @click="currentSlide = i-1" 
                                        class="w-2 h-2 rounded-full transition-all duration-300 backdrop-blur-sm"
                                        :class="currentSlide === i-1 ? 'bg-white scale-125 shadow-lg' : 'bg-white/50 hover:bg-white/70'">
                                </button>
                            </template>
                        </div>
                        
                        <!-- Flèches de navigation -->
                        <button @click="prev()" 
                                class="absolute left-2 top-1/2 transform -translate-y-1/2 text-white/90 hover:text-white transition-all duration-300 z-20 bg-black/40 hover:bg-black/60 backdrop-blur-sm rounded-full p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="next()" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white/90 hover:text-white transition-all duration-300 z-20 bg-black/40 hover:bg-black/60 backdrop-blur-sm rounded-full p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                
            </div>

            <!-- Indicateurs de qualité (Apparaissent APRÈS le carousel sur mobile) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-4xl mx-auto pt-12 border-t border-white/25 mt-8 md:mt-0"
                x-data="{ shown: false }" x-intersect:enter="shown = true">
                <!-- Chambres -->
                <div x-show="shown" 
                    x-transition:enter="transition ease-out duration-1000 delay-1800"
                    class="text-center group py-6">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center group-hover:bg-white/20 transition-all duration-300 backdrop-blur-sm border border-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">24+</div>
                    <div class="text-white/90 text-base font-medium uppercase tracking-wider">Suites & Villas</div>
                    <div class="text-white/70 text-sm mt-1">Luxe Exceptionnel</div>
                </div>

                <!-- Restaurants -->
                <div x-show="shown" 
                    x-transition:enter="transition ease-out duration-1000 delay-1900"
                    class="text-center group py-6">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center group-hover:bg-white/20 transition-all duration-300 backdrop-blur-sm border border-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">2</div>
                    <div class="text-white/90 text-base font-medium uppercase tracking-wider">Restaurants</div>
                    <div class="text-white/70 text-sm mt-1">Gastronomie Étoilée</div>
                </div>

                <!-- Satisfaction -->
                <div x-show="shown" 
                    x-transition:enter="transition ease-out duration-1000 delay-2000"
                    class="text-center group py-6">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center group-hover:bg-white/20 transition-all duration-300 backdrop-blur-sm border border-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2">98%</div>
                    <div class="text-white/90 text-base font-medium uppercase tracking-wider">Satisfaction</div>
                    <div class="text-white/70 text-sm mt-1">Clients Fidèles</div>
                </div>
            </div>

            <!-- Certifications et partenariats -->
            <div class="mt-12 pt-8 border-t border-white/20" x-data="{ shown: false }" x-intersect:enter="shown = true">
                
            </div>
        </div>

        <!-- Scroll indicator (Maintenu en bas) -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-20 hidden md:block">
            <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center backdrop-blur-sm">
                <div class="w-1 h-3 bg-white/70 rounded-full mt-2"></div>
            </div>
        </div>
    </section>

    <!-- Section Découverte améliorée -->
    <section id="decouvrir" class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16" x-data="{ shown: false }" x-intersect:enter="shown = true">
                <span x-show="shown" 
                      x-transition:enter="transition ease-out duration-1000"
                      class="text-brown-600 font-semibold text-sm uppercase tracking-wider mb-4 block">
                    Découverte
                </span>
                <h2 x-show="shown" 
                    x-transition:enter="transition ease-out duration-1000 delay-300"
                    class="text-3xl sm:text-4xl md:text-5xl font-light text-gray-900 mb-6">
                    Une Expérience Unique
                </h2>
                <p x-show="shown" 
                   x-transition:enter="transition ease-out duration-1000 delay-500"
                   class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                    Plongez dans un univers où l'élégance et le confort se mêlent à la beauté naturelle de notre cadre exceptionnel.
                </p>
            </div>

            <!-- Grille de présentation améliorée -->
            <!-- Passe de 1 colonne (mobile) à 3 colonnes (lg) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <!-- Chambres -->
                <div x-data="{ shown: false }" x-intersect:enter="shown = true"
                     class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                    <!-- aspect-[4/5] est bon pour garder une forme verticale sur mobile -->
                    <div class="aspect-[4/5] bg-gradient-to-br from-brown-50 to-brown-100 overflow-hidden">
                        <img src="{{ asset('images/chambre-luxe.jpg') }}" 
                             alt="Chambre de luxe Miadjoe Beach Resort" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-brown-900/90 via-brown-900/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="absolute inset-0 flex items-end p-6 sm:p-8">
                        <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <h3 class="text-2xl font-light mb-2">Chambres & Suites</h3>
                            <p class="text-white/80 mb-4 text-sm sm:text-base">Élégance et confort dans un cadre raffiné</p>
                            <a href="{{ route('public.rooms') }}" 
                               class="inline-flex items-center text-white font-semibold hover:text-brown-200 transition-all duration-300 group/link">
                                Découvrir
                                <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <!-- Badge flottant -->
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-brown-800 px-3 py-1 rounded-full text-xs sm:text-sm font-semibold transform translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 delay-200">
                        Vue Mer
                    </div>
                </div>

                <!-- Restaurant -->
                <div x-data="{ shown: false }" x-intersect:enter="shown = true"
                     class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                    <div class="aspect-[4/5] bg-gradient-to-br from-brown-50 to-brown-100 overflow-hidden">
                        <img src="{{ asset('images/restaurant-gastronomique.jpg') }}" 
                             alt="Restaurant gastronomique Miadjoe Beach Resort" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-brown-900/90 via-brown-900/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="absolute inset-0 flex items-end p-6 sm:p-8">
                        <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <h3 class="text-2xl font-light mb-2">Restaurant</h3>
                            <p class="text-white/80 mb-4 text-sm sm:text-base">Saveurs exceptionnelles face à l'océan</p>
                            <a href="{{ route('public.menu') }}" 
                               class="inline-flex items-center text-white font-semibold hover:text-brown-200 transition-all duration-300 group/link">
                                Découvrir
                                <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <!-- Badge flottant -->
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-brown-800 px-3 py-1 rounded-full text-xs sm:text-sm font-semibold transform translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 delay-200">
                        Gastronomique
                    </div>
                </div>

                <!-- Spa -->
                <div x-data="{ shown: false }" x-intersect:enter="shown = true"
                     class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500">
                    <div class="aspect-[4/5] bg-gradient-to-br from-brown-50 to-brown-100 overflow-hidden">
                        <img src="{{ asset('images/spa-wellness.jpg') }}" 
                             alt="Spa et centre de bien-être Miadjoe Beach Resort" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-brown-900/90 via-brown-900/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="absolute inset-0 flex items-end p-6 sm:p-8">
                        <div class="text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <h3 class="text-2xl font-light mb-2">Spa & Bien-être</h3>
                            <p class="text-white/80 mb-4 text-sm sm:text-base">Détente absolue dans un havre de paix</p>
                            <a href="{{ route('public.gallery') }}" 
                               class="inline-flex items-center text-white font-semibold hover:text-brown-200 transition-all duration-300 group/link">
                                Découvrir
                                <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <!-- Badge flottant -->
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-brown-800 px-3 py-1 rounded-full text-xs sm:text-sm font-semibold transform translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 delay-200">
                        Détente
                    </div>
                </div>
            </div>

            <!-- Section services additionnels -->
            <!-- Passe de 1 colonne (mobile) à 3 colonnes (md) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 sm:mt-16 pt-8 sm:pt-16 border-t border-gray-200">
                <div class="text-center p-4" x-data="{ shown: false }" x-intersect:enter="shown = true">
                    <div x-show="shown" 
                         x-transition:enter="transition ease-out duration-1000 delay-300"
                         class="inline-flex items-center justify-center w-16 h-16 bg-brown-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Réservation Flexible</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Annulation gratuite jusqu'à 48h avant votre arrivée <a href="{{ route('public.condition') }}" class="text-red-400 hover:text-blue-300 transition-colors duration-300">En savoir plus</a> </p>
                </div>
                <div class="text-center p-4" x-data="{ shown: false }" x-intersect:enter="shown = true">
                    <div x-show="shown" 
                         x-transition:enter="transition ease-out duration-1000 delay-500"
                         class="inline-flex items-center justify-center w-16 h-16 bg-brown-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Sécurité Optimale</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Environnement sécurisé et protocoles sanitaires stricts</p>
                </div>
                <div class="text-center p-4" x-data="{ shown: false }" x-intersect:enter="shown = true">
                    <div x-show="shown" 
                         x-transition:enter="transition ease-out duration-1000 delay-700"
                         class="inline-flex items-center justify-center w-16 h-16 bg-brown-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Service Personnalisé</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Notre équipe dédiée à votre service 24h/24</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA améliorée -->
    <section class="py-16 sm:py-20 bg-gradient-to-br from-brown-900 via-brown-800 to-brown-900 text-white relative overflow-hidden">
        <!-- Élément décoratif (adapté) -->
        <div class="absolute top-0 left-0 w-48 h-48 sm:w-72 sm:h-72 bg-brown-700/20 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 sm:w-96 sm:h-96 bg-brown-600/10 rounded-full translate-x-1/2 translate-y-1/2"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-light mb-6" x-data="{ shown: false }" x-intersect:enter="shown = true">
                <span x-show="shown" 
                      x-transition:enter="transition ease-out duration-1000"
                      class="bg-gradient-to-r from-white to-brown-200 bg-clip-text text-transparent">
                    Prêt pour l'Évasion ?
                </span>
            </h2>
            <p class="text-lg sm:text-xl text-white/80 mb-8 max-w-2xl mx-auto" x-data="{ shown: false }" x-intersect:enter="shown = true">
                <span x-show="shown" 
                      x-transition:enter="transition ease-out duration-1000 delay-300">
                    Réservez dès maintenant votre séjour inoubliable dans notre resort de charme. Des moments d'exception vous attendent.
                </span>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" x-data="{ shown: false }" x-intersect:enter="shown = true">
                <div x-show="shown" 
                     x-transition:enter="transition ease-out duration-1000 delay-500">
                    <a href="{{ route('public.reservation') }}" 
                       class="bg-white text-brown-800 hover:bg-brown-50 px-8 py-4 rounded-full text-lg font-semibold shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 inline-flex items-center group w-full sm:w-auto justify-center">
                        Réserver Votre Séjour
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
                <div x-show="shown" 
                     x-transition:enter="transition ease-out duration-1000 delay-700">
                    <a href="tel:+22892062121" 
                       class="border-2 border-white/50 hover:border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white/10 transition-all duration-300 backdrop-blur-sm inline-flex items-center group w-full sm:w-auto justify-center">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        +228 92 06 21 21
                    </a>
                </div>
            </div>
            
            <!-- Avis clients -->
            <div class="mt-12 pt-8 border-t border-white/20">
                <div class="flex flex-wrap items-center justify-center space-x-2 text-white/70">
                    <div class="flex">
                        <!-- Étoiles -->
                        <template x-for="i in 5" :key="i">
                            <svg class="w-5 h-5 fill-current text-yellow-400" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </template>
                    </div>
                    <span class="text-sm whitespace-nowrap">4.9/5 • 247 avis clients</span>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
