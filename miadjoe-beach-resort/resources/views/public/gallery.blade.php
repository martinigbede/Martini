{{-- resources/views/public/gallery.blade.php --}}
<x-layouts.public>
    <!-- Hero Section Galerie -->
    <section class="relative pt-32 pb-28 min-h-[70vh] flex items-center justify-center overflow-hidden">
        <!-- Background avec image dynamique -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-gradient-to-br from-brown-900 via-amber-900 to-brown-800">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1200 800\" opacity=\"0.1\"><defs><pattern id=\"grid\" width=\"50\" height=\"50\" patternUnits=\"userSpaceOnUse\"><path d=\"M 50 0 L 0 0 0 50\" fill=\"none\" stroke=\"white\" stroke-width=\"2\"/></pattern></defs><rect width=\"1200\" height=\"800\" fill=\"url(%23grid)\"/></svg>')]"></div>
            </div>
            <!-- Overlay dynamique -->
            <div class="absolute inset-0 bg-gradient-to-br from-brown-900/80 via-brown-800/60 to-amber-900/70"></div>
        </div>

        <!-- Éléments décoratifs animés -->
        <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-amber-400/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/3 w-48 h-48 bg-brown-500/30 rounded-full blur-2xl animate-bounce"></div>
        <div class="absolute top-1/3 right-1/4 w-24 h-24 bg-amber-300/40 rounded-full blur-lg animate-ping"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <!-- Badge élégant -->
            <div class="mb-8">
                <span class="inline-block bg-white/20 backdrop-blur-md text-white px-8 py-3 rounded-2xl text-lg font-semibold border border-white/30 shadow-2xl">
                    📸 Immersion Visuelle
                </span>
            </div>

            <!-- Titre principal -->
            <h1 class="text-5xl md:text-7xl font-light mb-6 tracking-tight">
                <span class="block bg-gradient-to-r from-white to-amber-200 bg-clip-text text-transparent">
                    Galerie
                </span>
                <span class="block text-3xl md:text-4xl font-serif italic mt-4 text-amber-100">
                    Resort & Spa
                </span>
            </h1>

            <!-- Sous-titre -->
            <p class="text-xl md:text-2xl text-amber-100/90 mb-8 max-w-3xl mx-auto leading-relaxed font-light">
                Plongez dans l'univers envoûtant du Miadjoe Beach Resort à travers nos moments capturés
            </p>

            <!-- Statistiques -->
            <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto pt-8 border-t border-amber-200/20">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">150+</div>
                    <div class="text-amber-200/80 text-sm">Photos Exclusives</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">25+</div>
                    <div class="text-amber-200/80 text-sm">Vidéos Immersives</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">10+</div>
                    <div class="text-amber-200/80 text-sm">Albums Thématiques</div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator animé -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="w-8 h-12 border-2 border-amber-300/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-amber-300/70 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- Section Navigation Galeries -->
    <section class="py-16 bg-gradient-to-b from-white to-amber-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête section -->
            <div class="text-center mb-16">
                <span class="text-brown-600 font-semibold text-sm uppercase tracking-wider mb-4 block">Exploration</span>
                <h2 class="text-4xl md:text-5xl font-light text-gray-900 mb-6">Découvrez Notre Univers</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Parcourez nos différentes galeries thématiques et laissez-vous transporter 
                    par l'atmosphère unique de notre resort
                </p>
            </div>

            <!-- Navigation par catégories -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Container avec effets de bordure -->
                    <div class="relative">
                        <!-- Éléments décoratifs -->
                        <div class="absolute -top-6 -left-6 w-24 h-24 bg-amber-200/20 rounded-full blur-xl"></div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-brown-300/10 rounded-full blur-2xl"></div>
                        
                        <!-- Composant Livewire intégré dans un container élégant -->
                        <div class="relative bg-white/80 backdrop-blur-sm rounded-3xl border border-amber-100/50 shadow-2xl overflow-hidden">
                            @livewire('public.gallery-display')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Section CTA Immersive -->
    <section class="py-20 bg-gradient-to-br from-brown-900 via-amber-900 to-brown-800 text-white relative overflow-hidden">
        <!-- Éléments décoratifs animés -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent animate-pulse"></div>
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-amber-400/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-brown-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-light mb-6">Vivez l'Expérience</h2>
            <p class="text-xl text-amber-100/80 mb-8 max-w-2xl mx-auto">
                Ces images ne sont qu'un avant-goût de l'expérience exceptionnelle qui vous attend 
                au Miadjoe Beach Resort
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('public.reservation') }}" 
                   class="group bg-white text-brown-800 hover:bg-amber-50 px-8 py-4 rounded-2xl text-lg font-semibold shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Réserver Maintenant
                </a>
                <a href="{{ route('public.menu') }}" 
                   class="group border-2 border-amber-300/50 hover:border-amber-300 text-amber-100 px-8 py-4 rounded-2xl text-lg font-semibold hover:bg-amber-400/10 transition-all duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Découvrir le Menu
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>

<style>
/* Animations personnalisées */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Effets de scroll personnalisés */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: linear-gradient(to bottom, #fef3c7, #fef3c7);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #d97706, #92400e);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #b45309, #78350f);
}

/* Effets de hover avancés */
.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>