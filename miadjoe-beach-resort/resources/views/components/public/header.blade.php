{{-- resources/views/components/public/header.blade.php --}}
<header class="bg-white shadow-2xl border-b border-gray-200/60 fixed top-4 left-4 right-4 rounded-2xl z-50 transition-all duration-500">
    <div class="max-w-8xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between items-center h-20">
            {{-- Logo / Lien Accueil --}}
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-4 group transition-all duration-500 hover:scale-[1.02]">
                    <!-- Logo avec effet 3D et gradient amélioré -->
                    <div class="relative w-10 h-10 bg-gradient-to-br from-brown-500 via-brown-600 to-brown-800 rounded-2xl flex items-center justify-center shadow-2xl group-hover:shadow-3xl transition-all duration-500 group-hover:rotate-6 overflow-hidden">
                        <!-- Effet de lumière dynamique -->
                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 via-transparent to-white/10 opacity-60"></div>
                        <!-- Animation de brillance au survol -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Miadjoe Beach" class="w-6 h-6 object-contain relative z-10 drop-shadow-lg filter brightness-110">
                    </div>
                    
                    <!-- Texte avec améliorations typographiques -->
                    <div class="flex flex-col">
                        <span class="text-2xl font-light text-gray-900 tracking-tight group-hover:text-brown-700 transition-colors duration-500 bg-gradient-to-r from-gray-900 to-brown-800 bg-clip-text group-hover:from-brown-700 group-hover:to-brown-900">
                            Miadjoe Beach
                        </span>
                        <span class="text-xs font-semibold text-brown-500 -mt-1 opacity-90 group-hover:opacity-100 group-hover:translate-x-2 transition-all duration-500 tracking-wider">
                            RESORT & SPA
                        </span>
                    </div>
                </a>
            </div>

            {{-- Horloge en temps réel --}}
            <div class="hidden lg:flex items-center space-x-3 px-4 py-2 bg-gray-50/80 rounded-xl border border-gray-200/60">
                <svg class="w-4 h-4 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div id="real-time-clock" class="text-sm font-semibold text-gray-700 font-mono">
                    <span id="clock-time">00:00:00</span>
                    <span id="clock-date" class="text-xs text-gray-500 ml-2"></span>
                </div>
            </div>

            {{-- Liens de Navigation Centrés --}}
            <nav class="hidden xl:flex items-center space-x-10">
                @php
                    $currentRoute = request()->route()->getName();
                @endphp
                
                <a href="{{ route('public.reservation') }}" class="relative transition-all duration-500 group py-3 {{ in_array($currentRoute, ['public.reservation', 'public.select-room']) ? 'text-brown-600' : 'text-gray-700 hover:text-brown-600' }}">
                    <span class="font-semibold text-base tracking-wide relative z-10">Réservation</span>
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gradient-to-r from-brown-500 to-brown-700 rounded-full group-hover:w-full transition-all duration-500 {{ in_array($currentRoute, ['public.reservation', 'public.select-room']) ? 'w-full' : '' }}"></span>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-brown-500/50 to-brown-700/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </a>
                
                <a href="{{ route('public.rooms') }}" class="relative transition-all duration-500 group py-3 {{ $currentRoute === 'public.rooms' ? 'text-brown-600' : 'text-gray-700 hover:text-brown-600' }}">
                    <span class="font-semibold text-base tracking-wide relative z-10">Nos Chambres</span>
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gradient-to-r from-brown-500 to-brown-700 rounded-full group-hover:w-full transition-all duration-500 {{ $currentRoute === 'public.rooms' ? 'w-full' : '' }}"></span>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-brown-500/50 to-brown-700/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </a>
                
                <a href="{{ route('public.menu') }}" class="relative transition-all duration-500 group py-3 {{ $currentRoute === 'public.menu' ? 'text-brown-600' : 'text-gray-700 hover:text-brown-600' }}">
                    <span class="font-semibold text-base tracking-wide relative z-10">Menu Resto</span>
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gradient-to-r from-brown-500 to-brown-700 rounded-full group-hover:w-full transition-all duration-500 {{ $currentRoute === 'public.menu' ? 'w-full' : '' }}"></span>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-brown-500/50 to-brown-700/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </a>
                
                <a href="{{ route('public.gallery') }}" class="relative transition-all duration-500 group py-3 {{ $currentRoute === 'public.gallery' ? 'text-brown-600' : 'text-gray-700 hover:text-brown-600' }}">
                    <span class="font-semibold text-base tracking-wide relative z-10">Galeries</span>
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gradient-to-r from-brown-500 to-brown-700 rounded-full group-hover:w-full transition-all duration-500 {{ $currentRoute === 'public.gallery' ? 'w-full' : '' }}"></span>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-brown-500/50 to-brown-700/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </a>
                
                <a href="{{ route('public.contact') }}" class="relative transition-all duration-500 group py-3 {{ $currentRoute === 'public.contact' ? 'text-brown-600' : 'text-gray-700 hover:text-brown-600' }}">
                    <span class="font-semibold text-base tracking-wide relative z-10">Contact</span>
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gradient-to-r from-brown-500 to-brown-700 rounded-full group-hover:w-full transition-all duration-500 {{ $currentRoute === 'public.contact' ? 'w-full' : '' }}"></span>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-brown-500/50 to-brown-700/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </a>
            </nav>

            {{-- Liens Authentification Desktop --}}
            <div class="hidden xl:flex items-center space-x-5">
                @auth
                    {{-- Menu utilisateur avec dropdown amélioré --}}
                    <div class="relative group">
                        <button class="flex items-center space-x-3 text-gray-700 hover:text-brown-600 transition-all duration-500 p-2 rounded-2xl hover:bg-brown-50/80">
                            <div class="relative">
                                <div class="w-9 h-9 bg-gradient-to-br from-brown-500 to-brown-700 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-lg transition-all duration-500 group-hover:scale-110">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="absolute -inset-1 bg-gradient-to-r from-brown-500 to-brown-700 rounded-full opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-500"></div>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-500 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        {{-- Dropdown menu amélioré --}}
                        <div class="absolute right-0 top-full mt-3 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/60 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                            <div class="p-3">
                                <div class="px-3 py-2 border-b border-gray-200/60 mb-2">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                
                                @if(!Auth::user()->role_id)
                                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-brown-50 hover:text-brown-600 rounded-xl transition-all duration-300 group/item">
                                    <svg class="w-5 h-5 transition-transform group-hover/item:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Mon Compte</span>
                                </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-3 w-full px-3 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 group/item mt-2">
                                        <svg class="w-5 h-5 transition-transform group-hover/item:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Liens connexion/inscription améliorés --}}
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-brown-600 transition-all duration-500 font-semibold text-sm px-4 py-2 rounded-xl hover:bg-brown-50/80">
                            Connexion
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="relative bg-gradient-to-r from-brown-600 to-brown-800 hover:from-brown-700 hover:to-brown-900 text-white px-6 py-2.5 rounded-2xl text-sm font-semibold shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-1 hover:scale-105 overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                                <span class="relative z-10">S'inscrire</span>
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            {{-- Boutons authentification mobile --}}
            <div class="xl:hidden flex items-center space-x-3">
                {{-- Horloge mobile --}}
                <div class="lg:hidden flex items-center space-x-2 px-3 py-1.5 bg-gray-50/80 rounded-lg border border-gray-200/60">
                    <svg class="w-3.5 h-3.5 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div id="mobile-clock-time" class="text-xs font-semibold text-gray-700 font-mono">00:00</div>
                </div>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="relative w-8 h-8 bg-gradient-to-br from-brown-500 to-brown-700 rounded-full flex items-center justify-center text-white text-xs font-semibold shadow-lg transition-all duration-500 hover:scale-110">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-brown-600 transition-all duration-500 font-semibold text-xs px-3 py-1.5 rounded-xl hover:bg-brown-50/80">
                        Connexion
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- Espace réservé pour le header fixe --}}
<div class="h-28"></div>

{{-- Navigation Mobile Fixe en Bas avec Fond Blanc --}}
<div class="xl:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-50 safe-bottom">
    <nav class="flex justify-around items-center py-3 px-2">
        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <a href="{{ route('public.reservation') }}" class="flex flex-col items-center space-y-1 px-3 py-2 rounded-2xl transition-all duration-300 min-w-[60px] {{ in_array($currentRoute, ['public.reservation', 'public.select-room']) ? 'text-brown-600 bg-brown-50 shadow-inner' : 'text-gray-600 hover:text-brown-600 hover:bg-gray-50' }}">
            <div class="relative w-6 h-6 flex items-center justify-center">
                <svg class="w-5 h-5 transition-transform duration-300 hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold tracking-wide">Réserv.</span>
        </a>

        <a href="{{ route('public.rooms') }}" class="flex flex-col items-center space-y-1 px-3 py-2 rounded-2xl transition-all duration-300 min-w-[60px] {{ $currentRoute === 'public.rooms' ? 'text-brown-600 bg-brown-50 shadow-inner' : 'text-gray-600 hover:text-brown-600 hover:bg-gray-50' }}">
            <div class="relative w-6 h-6 flex items-center justify-center">
                <svg class="w-5 h-5 transition-transform duration-300 hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="text-xs font-semibold tracking-wide">Chambres</span>
        </a>

        <a href="{{ route('home') }}" class="flex flex-col items-center space-y-1 px-3 py-2 rounded-2xl transition-all duration-300 min-w-[60px] {{ $currentRoute === 'home' ? 'text-brown-600 bg-brown-50 shadow-inner' : 'text-gray-600 hover:text-brown-600 hover:bg-gray-50' }}">
            <div class="relative w-8 h-8 bg-gradient-to-br from-brown-600 to-brown-800 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-4 h-4 object-contain filter brightness-110">
            </div>
            <span class="text-xs font-semibold tracking-wide">Accueil</span>
        </a>

        <a href="{{ route('public.menu') }}" class="flex flex-col items-center space-y-1 px-3 py-2 rounded-2xl transition-all duration-300 min-w-[60px] {{ $currentRoute === 'public.menu' ? 'text-brown-600 bg-brown-50 shadow-inner' : 'text-gray-600 hover:text-brown-600 hover:bg-gray-50' }}">
            <div class="relative w-6 h-6 flex items-center justify-center">
                <svg class="w-5 h-5 transition-transform duration-300 hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10"/>
                </svg>
            </div>
            <span class="text-xs font-semibold tracking-wide">Resto.</span>
        </a>

        <a href="{{ route('public.contact') }}" class="flex flex-col items-center space-y-1 px-3 py-2 rounded-2xl transition-all duration-300 min-w-[60px] {{ $currentRoute === 'public.contact' ? 'text-brown-600 bg-brown-50 shadow-inner' : 'text-gray-600 hover:text-brown-600 hover:bg-gray-50' }}">
            <div class="relative w-6 h-6 flex items-center justify-center">
                <svg class="w-5 h-5 transition-transform duration-300 hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold tracking-wide">Contact</span>
        </a>
    </nav>
</div>

{{-- CSS pour safe area --}}
<style>
.safe-bottom {
    padding-bottom: env(safe-area-inset-bottom);
}
</style>

{{-- Script pour l'horloge en temps réel --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateClock() {
        const now = new Date();
        
        // Format de l'heure
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        
        // Format de la date
        const options = { weekday: 'short', day: 'numeric', month: 'short' };
        const dateString = now.toLocaleDateString('fr-FR', options);
        
        // Mise à jour de l'horloge desktop
        const desktopClock = document.getElementById('clock-time');
        const desktopDate = document.getElementById('clock-date');
        if (desktopClock) {
            desktopClock.textContent = `${hours}:${minutes}:${seconds}`;
        }
        if (desktopDate) {
            desktopDate.textContent = dateString;
        }
        
        // Mise à jour de l'horloge mobile
        const mobileClock = document.getElementById('mobile-clock-time');
        if (mobileClock) {
            mobileClock.textContent = `${hours}:${minutes}`;
        }
    }
    
    // Mettre à jour l'horloge immédiatement puis toutes les secondes
    updateClock();
    setInterval(updateClock, 1000);
});
</script>