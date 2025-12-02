<nav x-data="{ open: false }" class="bg-white border-b border-brown-200 lg:hidden">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-brown-600 to-brown-800 rounded-lg flex items-center justify-center shadow-md">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-4 h-4 object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-light text-gray-800 tracking-tight">Miadjoe Beach</span>
                        <span class="text-xs font-medium text-brown-600 -mt-1">Dashboard</span>
                    </div>
                </a>
            </div>

            <!-- User Menu Mobile -->
            <div class="flex items-center space-x-3">
                <!-- Notifications Bell -->
                <button class="p-2 text-brown-600 hover:text-brown-800 hover:bg-brown-50 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.115 5.308c.483-.323 1.13-.19 1.448.298.318.488.178 1.138-.304 1.462-.483.323-1.13.19-1.448-.298-.318-.488-.178-1.138.304-1.462zM5.115 5.308c.483-.323 1.13-.19 1.448.298.318.488.178 1.138-.304 1.462-.483.323-1.13.19-1.448-.298-.318-.488-.178-1.138.304-1.462z"></path>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 p-1 rounded-lg hover:bg-brown-50 transition-colors duration-200">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="size-8 rounded-full object-cover border-2 border-brown-200" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-brown-500 to-brown-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-brown-200 z-50"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95">
                        <div class="p-2">
                            <!-- User Info -->
                            <div class="px-3 py-2 border-b border-brown-100">
                                <p class="text-sm font-semibold text-brown-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-brown-600 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <a href="{{ route('profile.show') }}" class="flex items-center space-x-2 px-3 py-2 text-sm text-brown-700 hover:bg-brown-50 hover:text-brown-900 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Mon Profil</span>
                            </a>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <a href="{{ route('api-tokens.index') }}" class="flex items-center space-x-2 px-3 py-2 text-sm text-brown-700 hover:bg-brown-50 hover:text-brown-900 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                    <span>Tokens API</span>
                                </a>
                            @endif

                            <!-- Team Management -->
                            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                <div class="border-t border-brown-100 mt-2 pt-2">
                                    <p class="px-3 py-1 text-xs font-medium text-brown-500">Équipe</p>
                                    <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="flex items-center space-x-2 px-3 py-2 text-sm text-brown-700 hover:bg-brown-50 hover:text-brown-900 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span>Paramètres</span>
                                    </a>
                                </div>
                            @endif

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-brown-100 mt-2 pt-2">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger Menu for Sidebar -->
            <div class="flex items-center">
                <button @click="open = ! open" class="p-2 rounded-lg text-brown-600 hover:text-brown-800 hover:bg-brown-50 transition-colors duration-200">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="open" class="fixed inset-0 bg-brown-900 bg-opacity-50 z-40 lg:hidden" @click="open = false"></div>

    <!-- Mobile Sidebar -->
    <div x-show="open" 
         class="fixed top-0 left-0 h-full w-64 bg-white shadow-2xl z-50 transform transition-transform duration-300 lg:hidden"
         :class="{'translate-x-0': open, '-translate-x-full': !open}">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-brown-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-brown-600 to-brown-800 rounded-lg flex items-center justify-center shadow-md">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-4 h-4 object-contain">
                </div>
                <span class="text-lg font-semibold text-brown-900">Menu</span>
            </div>
            <button @click="open = false" class="p-1 text-brown-500 hover:text-brown-700 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Sidebar Content -->
        <div class="p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 p-3 rounded-lg text-brown-700 hover:bg-brown-50 hover:text-brown-900 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-brown-50 text-brown-900 border-r-2 border-brown-600' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Add more sidebar items here based on your sidebar component -->
            <!-- Example additional items -->
            <div class="pt-4 border-t border-brown-100">
                <p class="px-3 py-2 text-xs font-semibold text-brown-500 uppercase tracking-wider">Gestion</p>
                
                <!-- You can add more menu items here that match your sidebar -->
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-brown-600 hover:bg-brown-50 hover:text-brown-900 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Chambres</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-brown-600 hover:bg-brown-50 hover:text-brown-900 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Utilisateurs</span>
                </a>
            </div>
        </div>
    </div>
</nav>