{{-- resources/views/public/rooms.blade.php --}}
<x-layouts.public>
    <!-- Hero Section Chambres Optimisée -->
    <section class="relative min-h-[80vh] md:min-h-[90vh] flex items-center justify-center overflow-hidden">
        <!-- Background simplifié -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/rooms-hero.jpg') }}" 
                 alt="Chambre luxueuse Miadjoe Beach Resort" 
                 class="w-full h-full object-cover"
                 loading="eager"
                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1200\" height=\"800\" viewBox=\"0 0 1200 800\"><defs><linearGradient id=\"grad\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"100%\"><stop offset=\"0%\" style=\"stop-color:%23846358;stop-opacity:1\" /><stop offset=\"100%\" style=\"stop-color:%2343302b;stop-opacity:1\" /></linearGradient></defs><rect width=\"1200\" height=\"800\" fill=\"url(%23grad)\"/><text x=\"50%\" y=\"50%\" font-family=\"Arial\" font-size=\"32\" fill=\"white\" text-anchor=\"middle\" dy=\"10\">Miadjoe Beach Resort - Chambres & Suites</text></svg>'">
            <div class="absolute inset-0 bg-brown-900/70"></div>
        </div>

        <!-- Contenu principal -->
        <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <!-- Badge simple -->
                <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-full text-base font-medium mb-8">
                    🏨 Hébergement d'Exception
                </div>

                <!-- Titre principal -->
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6">
                    <span class="block text-white">Nos</span>
                    <span class="block text-amber-200 mt-2">Chambres</span>
                </h1>

                <!-- Sous-titre -->
                <p class="text-lg md:text-xl lg:text-2xl text-amber-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Découvrez nos hébergements raffinés où l'élégance rencontre le confort absolu
                </p>

                <!-- Statistiques simples -->
                <div class="grid grid-cols-3 gap-4 max-w-md mx-auto pt-6 border-t border-amber-200/20">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-white mb-1">3</div>
                        <div class="text-amber-200/80 text-xs md:text-sm">Types de Chambres</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-white mb-1">24+</div>
                        <div class="text-amber-200/80 text-xs md:text-sm">Chambres Disponibles</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-white mb-1">⭐</div>
                        <div class="text-amber-200/80 text-xs md:text-sm">Confort Premium</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator simple -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2">
            <div class="w-6 h-10 border-2 border-amber-300/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-amber-300/70 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- Section Avantages Optimisée -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span class="text-brown-600 font-semibold text-sm uppercase tracking-wide mb-2 block">Excellence</span>
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-4">Un Confort Inégalé</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Chaque détail a été pensé pour votre confort absolu
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Avantage 1 -->
                <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-16 h-16 bg-brown-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🛏️</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Linge Premium</h3>
                    <p class="text-gray-600 text-sm">Draps en coton égyptien</p>
                </div>

                <!-- Avantage 2 -->
                <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-16 h-16 bg-brown-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🌅</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Vue Exceptionnelle</h3>
                    <p class="text-gray-600 text-sm">Vue mer, jardin ou piscine</p>
                </div>

                <!-- Avantage 3 -->
                <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-16 h-16 bg-brown-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🧴</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Produits d'Accueil</h3>
                    <p class="text-gray-600 text-sm">Cosmétiques haut de gamme</p>
                </div>

                <!-- Avantage 4 -->
                <div class="text-center p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-16 h-16 bg-brown-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">💎</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Service Personnalisé</h3>
                    <p class="text-gray-600 text-sm">Équipe dédiée 24h/24</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Types de Chambres Optimisée -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête section -->
            <div class="text-center mb-12 md:mb-16">
                <span class="text-brown-600 font-semibold text-sm uppercase tracking-wide mb-2 block">Nos Hébergements</span>
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-4">Découvrez Nos Chambres</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Une sélection raffinée d'hébergements pour tous vos besoins
                </p>
            </div>

            <!-- Container du composant Livewire -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                @livewire('room.public-room-availability')
            </div>
        </div>
    </section>

    <!-- Section Services Inclus Optimisée -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div>
                    <span class="text-brown-600 font-semibold text-sm uppercase tracking-wide mb-2 block">Services</span>
                    <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-6">Services Inclus</h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Profitez de nos services premium inclus dans tous nos hébergements
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="text-brown-600 text-xl">🛎️</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Service 24h/24</h3>
                                <p class="text-gray-600">Restauration et services à toute heure</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="text-brown-600 text-xl">🧹</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Nettoyage Quotidien</h3>
                                <p class="text-gray-600">Service de ménage et préparation du lit</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="text-brown-600 text-xl">📶</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Wi-Fi Haut Débit</h3>
                                <p class="text-gray-600">Connexion illimitée dans tout le resort</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="text-brown-600 text-xl">🏊</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Accès Piscine & Spa</h3>
                                <p class="text-gray-600">Inclus avec tous les types de chambres</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/room-service.jpg') }}" 
                             alt="Service en chambre Miadjoe Beach Resort" 
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"600\" height=\"600\" viewBox=\"0 0 600 600\"><defs><linearGradient id=\"grad\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"100%\"><stop offset=\"0%\" style=\"stop-color:%23f2e8e5;stop-opacity:1\" /><stop offset=\"100%\" style=\"stop-color:%23e0cec7;stop-opacity:1\" /></linearGradient></defs><rect width=\"600\" height=\"600\" fill=\"url(%23grad)\"/><text x=\"50%\" y=\"50%\" font-family=\"Arial\" font-size=\"20\" fill=\"%23846358\" text-anchor=\"middle\">Services Premium</text></svg>'">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA Réservation Optimisée -->
    <section class="py-12 md:py-16 bg-brown-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-semibold mb-6">Trouvez Votre Hébergement Idéal</h2>
            <p class="text-lg text-amber-100 mb-8 max-w-2xl mx-auto">
                Réservez dès maintenant votre séjour de rêve dans nos chambres d'exception
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('public.reservation') }}" 
                   class="bg-white text-brown-800 hover:bg-amber-50 px-8 py-3 rounded-xl font-semibold shadow-lg transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Réserver Maintenant
                </a>
                <a href="tel:+22870703783" 
                   class="border-2 border-amber-300 text-amber-100 hover:bg-amber-400/10 px-8 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                    📞 Nous Contacter
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>