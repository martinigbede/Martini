<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Section gauche - Illustration -->
        <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-center lg:bg-gradient-to-br lg:from-brown-50 lg:via-white lg:to-amber-50 lg:p-8">
            <div class="max-w-md w-full space-y-8 text-center">
                <!-- Logo grande taille -->
                <div class="relative w-32 h-32 mx-auto mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-brown-500 via-brown-600 to-brown-800 rounded-3xl shadow-2xl flex items-center justify-center transform rotate-3">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 via-transparent to-white/10 rounded-3xl"></div>
                        <img src="{{ asset('images/logo.png') }}" alt="Miadjoe Resort" class="w-16 h-16 object-contain relative z-10 drop-shadow-lg filter brightness-110">
                    </div>
                </div>
                
                <!-- Texte de bienvenue -->
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold text-gray-900">
                        Rejoignez
                        <span class="bg-gradient-to-r from-brown-600 to-brown-800 bg-clip-text text-transparent">
                            Miadjoe Resort
                        </span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Créez votre compte pour accéder à nos services exclusifs et profiter de votre séjour en toute sérénité.
                    </p>
                </div>

                <!-- Avantages -->
                <div class="grid grid-cols-1 gap-3 mt-8">
                    <div class="flex items-center space-x-3 p-3 bg-white/50 rounded-xl border border-white/80">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Réservations simplifiées</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-white/50 rounded-xl border border-white/80">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Accès sécurisé 24h/24</span>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-white/50 rounded-xl border border-white/80">
                        <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Service client dédié</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section droite - Formulaire -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-sm lg:max-w-md">
                <!-- En-tête mobile -->
                <div class="lg:hidden text-center mb-8">
                    <div class="relative w-20 h-20 mx-auto mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-brown-500 via-brown-600 to-brown-800 rounded-2xl shadow-lg flex items-center justify-center">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/20 via-transparent to-white/10 rounded-2xl"></div>
                            <img src="{{ asset('images/logo.png') }}" alt="Miadjoe Resort" class="w-10 h-10 object-contain relative z-10 drop-shadow-lg filter brightness-110">
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Rejoindre <span class="text-brown-600">Miadjoe</span>
                    </h1>
                    <p class="text-gray-600 mt-2">Créez votre compte personnel</p>
                </div>

                <!-- En-tête desktop -->
                <div class="hidden lg:block text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Créer votre <span class="bg-gradient-to-r from-brown-600 to-brown-800 bg-clip-text text-transparent">compte</span>
                    </h1>
                    <p class="text-gray-600 mt-3">Rejoignez la famille Miadjoe Resort</p>
                </div>

                <!-- Carte du formulaire -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <x-validation-errors class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4" />

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Champ Nom -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-900">
                                Nom complet
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input 
                                    id="name" 
                                    name="name" 
                                    type="text" 
                                    required 
                                    autofocus 
                                    autocomplete="name"
                                    value="{{ old('name') }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                    placeholder="Votre nom complet"
                                >
                            </div>
                        </div>

                        <!-- Champ Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-900">
                                Adresse email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    required 
                                    autocomplete="username"
                                    value="{{ old('email') }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                    placeholder="votre@email.com"
                                >
                            </div>
                        </div>

                        <!-- Champ Mot de passe -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-gray-900">
                                Mot de passe
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    required 
                                    autocomplete="new-password"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                    placeholder="Créez un mot de passe sécurisé"
                                >
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Minimum 8 caractères avec chiffres et lettres
                            </p>
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-900">
                                Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    required 
                                    autocomplete="new-password"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                    placeholder="Confirmez votre mot de passe"
                                >
                            </div>
                        </div>

                        <!-- Conditions d'utilisation -->
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-6">
                                <label for="terms" class="flex items-start space-x-3 cursor-pointer group">
                                    <div class="relative mt-0.5">
                                        <input 
                                            id="terms" 
                                            name="terms" 
                                            type="checkbox" 
                                            required
                                            class="w-5 h-5 text-brown-600 border-gray-300 rounded focus:ring-brown-500 focus:ring-2 transition-all duration-200"
                                        >
                                    </div>
                                    <div class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors duration-200">
                                        {!! __('J\'accepte les :terms_of_service et la :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="font-medium text-brown-600 hover:text-brown-700 underline underline-offset-2 transition-colors duration-200">conditions d\'utilisation</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="font-medium text-brown-600 hover:text-brown-700 underline underline-offset-2 transition-colors duration-200">politique de confidentialité</a>',
                                        ]) !!}
                                    </div>
                                </label>
                            </div>
                        @endif

                        <!-- Bouton d'inscription -->
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-brown-600 to-brown-800 hover:from-brown-700 hover:to-brown-900 text-white py-3.5 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-brown-500/20"
                        >
                            <span class="flex items-center justify-center space-x-2">
                                <span>Créer mon compte</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </span>
                        </button>
                    </form>

                    <!-- Lien de connexion -->
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600">
                            Déjà un compte ?
                            <a 
                                href="{{ route('login') }}" 
                                class="font-semibold text-brown-600 hover:text-brown-700 transition-colors duration-200 underline-offset-4 hover:underline ml-1"
                            >
                                Se connecter
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>