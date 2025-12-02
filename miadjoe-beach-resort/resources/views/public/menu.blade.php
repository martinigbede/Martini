{{-- resources/views/public/menu.blade.php --}}
<x-layouts.public>
    <!-- Hero Section Restaurant avec Overflow -->
    <section class="relative min-h-[80vh] md:min-h-[90vh] flex items-center justify-center overflow-hidden">
        <!-- Background avec effets -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/restaurant-hero.jpg') }}" 
                 alt="Restaurant Miadjoe Beach Resort - Vue intérieure élégante" 
                 class="w-full h-full object-cover scale-105"
                 loading="eager"
                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1200\" height=\"800\" viewBox=\"0 0 1200 800\"><defs><linearGradient id=\"grad\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"100%\"><stop offset=\"0%\" style=\"stop-color:%23846358;stop-opacity:1\" /><stop offset=\"100%\" style=\"stop-color:%2343302b;stop-opacity:1\" /></linearGradient></defs><rect width=\"1200\" height=\"800\" fill=\"url(%23grad)\"/><text x=\"50%\" y=\"50%\" font-family=\"Arial\" font-size=\"32\" fill=\"white\" text-anchor=\"middle\" dy=\"10\">Miadjoe Beach Resort - Restaurants</text></svg>'">
            <div class="absolute inset-0 bg-brown-900/75"></div>
            
            <!-- Overlay décoratif -->
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-brown-900/50 to-transparent"></div>
        </div>

        <!-- Contenu principal -->
        <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <!-- Badge élégant -->
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-full text-base font-medium mb-8">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span>🍽️ Expérience Gastronomique</span>
                </div>

                <!-- Titre principal -->
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6">
                    <span class="block text-white">Nos Restaurants</span>
                    <span class="block text-amber-200 mt-2">& Bars</span>
                </h1>

                <!-- Sous-titre -->
                <p class="text-lg md:text-xl lg:text-2xl text-amber-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Une symphonie de saveurs où la cuisine locale rencontre l'innovation culinaire
                </p>

                <!-- Indicateur restaurants -->
                <div class="inline-flex items-center gap-6 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3 border border-white/20">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                        <span class="text-sm font-medium">2 Restaurants</span>
                    </div>
                    <div class="w-px h-4 bg-white/30"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <span class="text-sm font-medium">Bar Signature</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2">
            <div class="flex flex-col items-center text-white/70">
                <span class="text-xs mb-2 tracking-wider">EXPLORER</span>
                <div class="w-6 h-10 border-2 border-amber-300/50 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-amber-300/70 rounded-full mt-2 animate-pulse"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Restaurants -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span class="text-brown-600 font-semibold text-sm uppercase tracking-wide mb-2 block">Nos Établissements</span>
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-4">Découvrez Nos Deux Restaurants</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Deux ambiances uniques, une même excellence culinaire
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
                <!-- Restaurant 1 -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        <img src="{{ asset('images/restaurant-main.jpg') }}" 
                             alt="Restaurant Principal Miadjoe Beach" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                            <span class="text-sm font-semibold text-amber-600">Restaurant Principal</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Le Miadjoe</h3>
                        <p class="text-gray-600 mb-6">
                            Notre restaurant signature avec vue panoramique sur l'océan. 
                            Cuisine gastronomique mettant en valeur les produits locaux.
                        </p>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 bg-brown-100 rounded-full flex items-center justify-center text-brown-600 text-xs">🕐</span>
                                <span><strong>Déjeuner:</strong> 12h - 15h • <strong>Dîner:</strong> 19h - 23h</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 bg-brown-100 rounded-full flex items-center justify-center text-brown-600 text-xs">📍</span>
                                <span>Rez-de-chaussée • Vue mer panoramique</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Restaurant 2 -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        <img src="{{ asset('images/restaurant-pool.jpg') }}" 
                             alt="Restaurant Piscine Miadjoe Beach" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm font-semibold text-blue-600">Restaurant Piscine</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">La Terrasse</h3>
                        <p class="text-gray-600 mb-6">
                            Ambiance décontractée au bord de la piscine. Grillades, salades 
                            et cuisine légère dans un cadre tropical.
                        </p>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 bg-brown-100 rounded-full flex items-center justify-center text-brown-600 text-xs">🕐</span>
                                <span><strong>Service continu:</strong> 11h - 18h</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 bg-brown-100 rounded-full flex items-center justify-center text-brown-600 text-xs">📍</span>
                                <span>Zone piscine • Ambiance détente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Informations Pratiques -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <div class="bg-white rounded-2xl p-6 text-center shadow-lg border border-gray-100">
                    <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Horaires</h3>
                    <p class="text-gray-600 text-sm">
                        <strong>Le Miadjoe:</strong><br>
                        Déjeuner 12h-15h • Dîner 19h-23h<br><br>
                        <strong>La Terrasse:</strong><br>
                        Service continu 11h-18h
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-lg border border-gray-100">
                    <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Emplacements</h3>
                    <p class="text-gray-600 text-sm">
                        <strong>Le Miadjoe:</strong><br>
                        Rez-de-chaussée, vue mer<br><br>
                        <strong>La Terrasse:</strong><br>
                        Zone piscine, ambiance tropicale
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 text-center shadow-lg border border-gray-100">
                    <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ambiances</h3>
                    <p class="text-gray-600 text-sm">
                        <strong>Le Miadjoe:</strong><br>
                        Élégant et raffiné<br><br>
                        <strong>La Terrasse:</strong><br>
                        Détente et convivialité
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Menus -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span class="text-brown-600 font-semibold text-sm uppercase tracking-wide mb-2 block">Nos Cartes</span>
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-4">Découvrez Nos Saveurs</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Une sélection raffinée de plats préparés avec des produits frais et locaux
                </p>
            </div>

            <!-- Container du composant Livewire -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                @livewire('menu.public-menu-display')
            </div>
        </div>
    </section>

    <!-- Section Bar & Cocktails -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div>
                    <span class="text-brown-600 font-semibold text-sm uppercase tracking-wide mb-2 block">Notre Bar</span>
                    <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-6">Cocktails Signature</h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Notre barman expert crée des cocktails uniques inspirés des saveurs locales 
                        et des ingrédients frais de notre région.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="text-brown-600 text-xl">🍹</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Cocktails Créatifs</h3>
                                <p class="text-gray-600">Mélanges uniques avec fruits tropicaux frais</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="text-brown-600 text-xl">🍷</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Sélection de Vins</h3>
                                <p class="text-gray-600">Cave soigneusement sélectionnée</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <span class="text-brown-600 text-xl">🥂</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Champagnes</h3>
                                <p class="text-gray-600">Grandes marques et petits producteurs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/bar-cocktails.jpg') }}" 
                             alt="Bar Miadjoe Beach Resort - Cocktails signature" 
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"600\" height=\"600\" viewBox=\"0 0 600 600\"><defs><linearGradient id=\"grad\" x1=\"0%\" y1=\"0%\" x2=\"100%\" y2=\"100%\"><stop offset=\"0%\" style=\"stop-color:%23f2e8e5;stop-opacity:1\" /><stop offset=\"100%\" style=\"stop-color:%23e0cec7;stop-opacity:1\" /></linearGradient></defs><rect width=\"600\" height=\"600\" fill=\"url(%23grad)\"/><text x=\"50%\" y=\"50%\" font-family=\"Arial\" font-size=\"20\" fill=\"%23846358\" text-anchor=\"middle\">Cocktails Signature</text></svg>'">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA Réservation -->
    <section class="py-12 md:py-16 bg-brown-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-semibold mb-6">Une Table Vous Attend</h2>
            <p class="text-lg text-amber-100 mb-8 max-w-2xl mx-auto">
                Réservez votre table pour une expérience gastronomique inoubliable
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+22870703783" 
                   class="bg-white text-brown-800 hover:bg-amber-50 px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Réserver par téléphone
                </a>
                <a href="{{ route('public.reservation') }}" 
                   class="border-2 border-amber-300 text-amber-100 hover:bg-amber-400/10 px-6 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Réserver en ligne
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>