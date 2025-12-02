{{-- resources/views/components/public/footer.blade.php --}}
<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-brown-900 text-white relative overflow-hidden">
    <!-- Éléments décoratifs -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-brown-500/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-gray-700/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section principale -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            <!-- Colonne 1 : Logo et description -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-brown-500 to-brown-700 rounded-xl flex items-center justify-center shadow-lg">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Miadjoe Beach" class="w-7 h-7 object-contain">
                    <!-- Logo avec gradient brun -->
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-light text-white">Miadjoe Beach</span>
                        <span class="text-sm font-medium text-brown-300 -mt-1">Resort & Spa</span>
                    </div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed mb-6">
                    Découvrez l'expérience ultime du luxe et de la détente dans notre resort de charme au bord de la mer. Un havre de paix où le confort rencontre l'élégance.
                </p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/miadjoebresort" target="_blank" class="w-10 h-10 bg-gray-700 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/miadjoebresort" target="_blank" class="w-10 h-10 bg-gray-700 hover:bg-pink-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="https://www.x.com/miadjoebresort" target="_blank" class="w-10 h-10 bg-gray-700 hover:bg-black rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="https://www.tiktok.com/@miadjoebresort" target="_blank" class="w-10 h-10 bg-gray-700 hover:bg-gray-900 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Colonne 2 : L'Hôtel -->
            <div>
                <h4 class="font-semibold text-lg mb-6 text-white relative inline-block">
                    L'Hôtel
                    <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-gradient-to-r from-brown-400 to-brown-600"></span>
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            À Propos de Nous
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Nos Services
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Galerie Photos
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Événements
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Colonne 3 : Réservations -->
            <div>
                <h4 class="font-semibold text-lg mb-6 text-white relative inline-block">
                    Réservations
                    <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-gradient-to-r from-brown-400 to-brown-600"></span>
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('public.reservation') }}" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Réserver en Ligne
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Tarifs & Promotions
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Chambres & Suites
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.condition') }}" class="text-gray-300 hover:text-brown-300 transition-colors duration-300 flex items-center group">
                            <svg class="w-4 h-4 mr-3 text-brown-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Conditions Générales
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Colonne 4 : Contact -->
            <div>
                <h4 class="font-semibold text-lg mb-6 text-white relative inline-block">
                    Contact
                    <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-gradient-to-r from-brown-400 to-brown-600"></span>
                </h4>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-brown-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-gray-300 text-sm">
                            Quartier Kpota (Aného)<br>
                            Miadjoe Beach Resort<br>
                        </span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-brown-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-300 text-sm">+228 92 06 21 21 | 96 99 04 45</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-brown-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-300 text-sm">reservation@miadjoebeachresort.com</span>
                    </li>
                </ul>
                
                <!-- Newsletter -->
                <div class="mt-6">
                    <p class="text-gray-300 text-sm mb-3">Restez informé de nos offres</p>
                    <div class="flex">
                        <input type="email" placeholder="Votre email" class="flex-1 bg-gray-700 border border-gray-600 rounded-l-lg px-4 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-brown-400 focus:ring-1 focus:ring-brown-400">
                        <button class="bg-gradient-to-r from-brown-500 to-brown-700 hover:from-brown-600 hover:to-brown-800 text-white px-4 rounded-r-lg transition-all duration-300 shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section basse -->
        <div class="mt-12 pt-8 border-t border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Miadjoe Beach Resort. Tous droits réservés.
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-brown-300 transition-colors duration-300">Mentions légales</a>
                    <a href="#" class="text-gray-400 hover:text-brown-300 transition-colors duration-300">Politique de confidentialité</a>
                    <a href="{{ route('public.condition') }}" class="text-gray-400 hover:text-brown-300 transition-colors duration-300">CGV</a>
                </div>
            </div>
        </div>
    </div>
</footer>