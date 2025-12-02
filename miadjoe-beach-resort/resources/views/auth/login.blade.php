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
                        Bienvenue à
                        <span class="bg-gradient-to-r from-brown-600 to-brown-800 bg-clip-text text-transparent">
                            Miadjoe Resort
                        </span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Accédez à votre espace personnel pour gérer vos réservations et profiter de nos services exclusifs.
                    </p>
                </div>

                <!-- Points forts -->
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <div class="w-2 h-2 bg-brown-500 rounded-full"></div>
                        <span>Réservations</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <div class="w-2 h-2 bg-brown-500 rounded-full"></div>
                        <span>Services Spa</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <div class="w-2 h-2 bg-brown-500 rounded-full"></div>
                        <span>Restauration</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <div class="w-2 h-2 bg-brown-500 rounded-full"></div>
                        <span>Activités</span>
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
                        Miadjoe <span class="text-brown-600">Resort</span>
                    </h1>
                    <p class="text-gray-600 mt-2">Connexion à votre compte</p>
                </div>

                <!-- En-tête desktop -->
                <div class="hidden lg:block text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Connexion à votre <span class="bg-gradient-to-r from-brown-600 to-brown-800 bg-clip-text text-transparent">compte</span>
                    </h1>
                    <p class="text-gray-600 mt-3">Accédez à votre espace personnel</p>
                </div>

                <!-- Carte du formulaire -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <x-validation-errors class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4" />

                    @session('status')
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 text-green-700 text-sm">
                            {{ $value }}
                        </div>
                    @endsession

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

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
                                    autofocus 
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
                                    autocomplete="current-password"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brown-500 focus:border-brown-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                    placeholder="Votre mot de passe"
                                >
                            </div>
                        </div>

                        <!-- Se souvenir de moi -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center space-x-3 cursor-pointer group">
                                <div class="relative">
                                    <input 
                                        id="remember_me" 
                                        name="remember" 
                                        type="checkbox" 
                                        class="w-5 h-5 text-brown-600 border-gray-300 rounded focus:ring-brown-500 focus:ring-2 transition-all duration-200"
                                    >
                                </div>
                                <span class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors duration-200">
                                    Se souvenir de moi
                                </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a 
                                    href="{{ route('password.request') }}" 
                                    class="text-sm font-medium text-brown-600 hover:text-brown-700 transition-colors duration-200 underline-offset-4 hover:underline"
                                >
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>

                        <!-- Bouton de connexion -->
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-brown-600 to-brown-800 hover:from-brown-700 hover:to-brown-900 text-white py-3.5 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-brown-500/20"
                        >
                            <span class="flex items-center justify-center space-x-2">
                                <span>Se connecter</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </button>
                    </form>

                    <!-- Lien d'inscription -->
                    @if (Route::has('register'))
                        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                            <p class="text-sm text-gray-600">
                                Pas encore de compte ?
                                <a 
                                    href="{{ route('register') }}" 
                                    class="font-semibold text-brown-600 hover:text-brown-700 transition-colors duration-200 underline-offset-4 hover:underline ml-1"
                                >
                                    Créer un compte
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>