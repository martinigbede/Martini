<!-- resources/views/components/sidebar.blade.php (Version Tailwind CSS) -->
<aside id="sidebar"
    class="fixed top-0 left-0 h-full z-50 bg-white shadow-xl border-r border-brown-200 transition-all duration-300 ease-in-out w-[280px] flex flex-col">


    <!-- HEADER -->
    <div class="flex items-center justify-between border-b border-brown-200 bg-gradient-to-b from-white to-brown-50 p-3">
        <div class="flex items-center gap-3 transition-all duration-300 ease-in-out">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-b from-brown-600 to-brown-800 font-bold text-white shadow-lg">
                 <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-full w-full object-cover rounded-xl">
            </div>
            <span class="logo-text text-xl font-bold tracking-tight bg-gradient-to-b from-brown-800 to-brown-600 bg-clip-text text-transparent transition-all duration-300 ease-in-out">
                Miadjoe Beach Resort
            </span>
        </div>

        <!-- BUTTON -->
        <button id="toggleBtn"
            class="flex items-center justify-center rounded-lg border border-brown-200 bg-brown-100 p-2 text-brown-700 shadow-sm 
                   transition-all duration-300 ease-in-out hover:border-brown-300 hover:bg-brown-200 hover:shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                class="transition-transform duration-300 ease-in-out">
                <path d="m15 18-6-6 6-6"/>
            </svg>
        </button>
    </div>

    <nav class="flex flex-1 flex-col gap-2 p-2">
        <!-- ==================== -->
        <!-- TABLEAU DE BORD PRINCIPAL -->
        <!-- ==================== -->
        <div class="mb-2">
            <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">Principal</div>
            <a href="#" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Tableau de bord</span>
            </a>
        </div>

        <!-- ==================== -->
        <!-- SECTION DIRECTION -->
        <!-- ==================== -->
        @role('Direction')
        <div class="mb-2">
            <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">Direction</div>

            <!-- Menu Tableaux de bord Direction -->
            <div class="nav-menu mb-1">
                <div class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50" onclick="toggleMenu('direction-dashboards-menu')">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3v18h18"></path>
                                <path d="m19 9-5 5-4-4-3 3"></path>
                            </svg>
                        </div>
                        <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Tableaux de bord</span>
                    </div>
                    <svg class="nav-menu-arrow h-4 w-4 transition-transform duration-300 ease-in-out" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </div>
                <div class="max-h-0 overflow-hidden bg-brown-50 transition-max-height duration-300 ease-in-out" id="direction-dashboards-menu">
                    <a href="{{ route('dashboard.direction') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3v18h18"></path>
                                <path d="m19 9-5 5-4-4-3 3"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Vue d'ensemble Direction</span>
                    </a>
                </div>
            </div>

            <!-- Menu Gestion Hôtelière -->
            <div class="nav-menu mb-1">
                <div class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50" onclick="toggleMenu('direction-gestion-menu')">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                            </svg>
                        </div>
                        <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Gestion Hôtelière</span>
                    </div>
                    <svg class="nav-menu-arrow h-4 w-4 transition-transform duration-300 ease-in-out" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </div>
                <div class="max-h-0 overflow-hidden bg-brown-50 transition-max-height duration-300 ease-in-out" id="direction-gestion-menu">
                    <a href="{{ route('dashboard.gestion.room-types') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.room-types') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                                <path d="M9 9h6v6H9z"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Types de chambres</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.rooms') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.rooms') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Gestion des chambres</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.reservations') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.reservations') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Réservations</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.vente-services') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Ventes de services</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.calendar') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.calendar') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Calendrier</span>
                    </a>
                </div>
            </div>

            <!-- Menu Administration -->
            <div class="nav-menu mb-1">
                <div class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50" onclick="toggleMenu('direction-admin-menu')">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                        <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Administration</span>
                    </div>
                    <svg class="nav-menu-arrow h-4 w-4 transition-transform duration-300 ease-in-out" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </div>
                <div class="max-h-0 overflow-hidden bg-brown-50 transition-max-height duration-300 ease-in-out" id="direction-admin-menu">
                    <a href="{{ route('dashboard.directions.divers-services') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.directions.divers-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Gestion Divers Services</span>
                    </a>
                    <a href="{{ route('dashboard.direction.users') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.direction.users') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Gestion des utilisateurs</span>
                    </a>
                    <a href="{{ route('dashboard.direction.messages') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.direction.messages') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Messages & Communication</span>
                    </a>
                    <a href="{{ route('dashboard.direction.settings') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.direction.settings') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Paramètres système</span>
                    </a>
                </div>
            </div>

            <!-- Menu Galerie -->
            <div class="nav-menu mb-1">
                <div class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50" onclick="toggleMenu('direction-gallery-menu')">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <path d="M21 15l-5-5L5 21"></path>
                            </svg>
                        </div>
                        <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Multimédia</span>
                    </div>
                    <svg class="nav-menu-arrow h-4 w-4 transition-transform duration-300 ease-in-out" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </div>
                <div class="max-h-0 overflow-hidden bg-brown-50 transition-max-height duration-300 ease-in-out" id="direction-gallery-menu">
                    <a href="{{ route('dashboard.gestion.gallery') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.gallery') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <path d="M21 15l-5-5L5 21"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Galerie photos</span>
                    </a>
                </div>
            </div>
        </div>
        @endrole

        <!-- ==================== -->
        <!-- SECTION COMPTABLE -->
        <!-- ==================== -->
        @role('Comptable')
        <div class="mb-2">
            <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">Comptabilité</div>

            <!-- Tableau de bord Comptable -->
            <a href="{{ route('dashboard.comptable') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.comptable') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Tableau de bord</span>
            </a>

            <!-- Gestion caisse -->
            <a href="{{ route('dashboard.caisse') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.caisse') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 3h6v4h-6z"></path>
                        <line x1="6" y1="11" x2="10" y2="11"></line>
                        <line x1="6" y1="15" x2="10" y2="15"></line>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Caisse</span>
            </a>

            <!-- Gestion depenses -->
            <a href="{{ route('dashboard.caisse.depenses') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.caisse.depenses') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 1v22"></path>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Gestion Dépenses</span>
            </a>

            <!-- Historique Comptable -->
            <a href="{{ route('dashboard.comptable.historique') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.comptable.historique') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Historique</span>
            </a>

        </div>
        @endrole

        <!-- ==================== -->
        <!-- SECTION RÉCEPTION -->
        <!-- ==================== -->
        @role('Réception')
        <div class="mb-2">
            <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">Réception</div>

            <!-- Tableau de bord Réception -->
            <a href="{{ route('dashboard.reception') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.reception') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                        <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Tableau de bord</span>
            </a>

            <!-- Menu Gestion Réception -->
            <div class="nav-menu mb-1">
                <div class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50" onclick="toggleMenu('reception-gestion-menu')">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                            </svg>
                        </div>
                        <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Gestion</span>
                    </div>
                    <svg class="nav-menu-arrow h-4 w-4 transition-transform duration-300 ease-in-out" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </div>
                <div class="max-h-0 overflow-hidden bg-brown-50 transition-max-height duration-300 ease-in-out" id="reception-gestion-menu">
                    <a href="{{ route('dashboard.gestion.caisse-hebergement') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.caisse-hebergement') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 3h6v4h-6z"></path>
                                <line x1="6" y1="11" x2="10" y2="11"></line>
                                <line x1="6" y1="15" x2="10" y2="15"></line>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Caisse Hébergement</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.reservations') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.reservations') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Réservations</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.calendar') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.calendar') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Calendrier</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.rooms') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.rooms') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">État des chambres</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.vente-services') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Ventes de services</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.clients') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.clients') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="7" r="4"></circle>
                                <path d="M5.5 21h13a2 2 0 0 0-2-2h-9a2 2 0 0 0-2 2z"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Gestion des clients</span>
                    </a>
                    
                </div>
            </div>
        </div>
        @endrole

        <!-- ==================== -->
        <!-- SECTION RESTAURATION -->
        <!-- ==================== -->
        @role('Restauration')
        <div class="mb-2">
            <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">Restauration</div>

            <!-- Tableau de bord Restauration -->
            <a href="{{ route('dashboard.restauration') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.restauration') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                        <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Tableau de bord</span>
            </a>

            <!-- Menu Gestion Restauration -->
            <div class="nav-menu mb-1">
                <div class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50" onclick="toggleMenu('restauration-gestion-menu')">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </div>
                        <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Gestion</span>
                    </div>
                    <svg class="nav-menu-arrow h-4 w-4 transition-transform duration-300 ease-in-out" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </div>
                <div class="max-h-0 overflow-hidden bg-brown-50 transition-max-height duration-300 ease-in-out" id="restauration-gestion-menu">
                    <a href="{{ route('dashboard.gestion.caisse-restaurant') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.caisse-hebergement') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 3h6v4h-6z"></path>
                                <line x1="6" y1="11" x2="10" y2="11"></line>
                                <line x1="6" y1="15" x2="10" y2="15"></line>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Caisse Restaurant</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.menus') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.menus') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m18 6-6 6-6-6"></path>
                                <path d="M12 12v8"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Menus & Carte</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.sales') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.sales') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Commandes & Ventes</span>
                    </a>
                    <a href="{{ route('dashboard.gestion.vente-services') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Ventes de services</span>
                    </a>
                    <!-- Gestion depenses -->
                    <a href="{{ route('dashboard.caisse.depenses') }}" class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 active:bg-brown-200 active:text-brown-900 active:font-semibold {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                        <div class="mr-3 flex h-4 w-4 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1v22"></path>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">Gestion des Dépensses</span>
                    </a>
                </div>
            </div>
        </div>
        @endrole

        <!-- ============== -->
        <!-- SECTION CAISSE -->
        <!-- ============== -->
        @role('Caisse')
        <div class="mb-2">
            <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">Caisse</div>

            <!-- Tableau de bord Caisse -->
            <a href="{{ route('dashboard.caisse') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.caisse') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 3h6v4h-6z"></path>
                        <line x1="6" y1="11" x2="10" y2="11"></line>
                        <line x1="6" y1="15" x2="10" y2="15"></line>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Tableau de bord</span>
            </a>

            <!-- Historique Comptable -->
            <a href="{{ route('dashboard.comptable.historique') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.comptable.historique') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Historique</span>
            </a>

            <!-- Gestion depenses -->
            <a href="{{ route('dashboard.caisse.depenses') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.caisse.depenses') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 1v22"></path>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Gestion Dépenses</span>
            </a>
        </div>
        @endrole

        <!-- ==================== -->
        <!-- SECTION AUTRES RÔLES -->
        <!-- ==================== -->
        @if(!Auth::user()->hasRole(['Direction', 'Comptable', 'Réception', 'Restauration','Caisse']))
        <div class="mb-2">
            <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">Espace Personnel</div>
            <a href="{{ route('dashboard') }}" class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">Mon espace</span>
            </a>
        </div>
        @endif
    </nav>

    <!-- Footer utilisateur -->
    <div class="mt-auto border-t border-brown-200 bg-brown-50 p-3">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-b from-brown-500 to-brown-700 font-semibold text-white">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info flex-1 min-w-0">
                <div class="user-name text-sm font-semibold text-brown-900 transition-all duration-300 ease-in-out">{{ Auth::user()->name }}</div>
                <div class="user-role text-xs text-brown-600 transition-all duration-300 ease-in-out">{{ Auth::user()->role->name ?? 'Utilisateur' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="logout-btn rounded bg-none p-2 text-brown-600 transition-all duration-200 hover:bg-red-50 hover:text-red-500" title="Déconnexion">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        const logoText = sidebar.querySelector('.logo-text');
        
        // --- Initialisation ---
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            sidebar.classList.remove('w-[280px]');
            sidebar.classList.add('w-20'); // largeur réduite
            logoText.classList.add('opacity-0', 'invisible', 'w-0');
            logoText.classList.remove('opacity-100', 'visible', 'w-auto');
            
            // Masquer les textes de navigation
            document.querySelectorAll('.nav-text, .nav-subitem-text').forEach(text => {
                text.classList.add('opacity-0', 'invisible', 'w-0');
                text.classList.remove('opacity-100', 'visible', 'w-auto');
            });
            
            // Masquer les titres de section
            document.querySelectorAll('.nav-section-title').forEach(title => {
                title.classList.add('opacity-0', 'h-0', 'py-0', 'overflow-hidden');
                title.classList.remove('opacity-100', 'h-auto');
            });
            
            // Masquer les flèches des menus
            document.querySelectorAll('.nav-menu-arrow').forEach(arrow => {
                arrow.classList.add('opacity-0', 'invisible');
                arrow.classList.remove('opacity-100', 'visible');
            });
            
            // Masquer les informations utilisateur
            document.querySelectorAll('.user-info, .user-name, .user-role').forEach(el => {
                el.classList.add('opacity-0', 'invisible', 'w-0');
                el.classList.remove('opacity-100', 'visible', 'w-auto');
            });
            
            // Masquer le bouton de déconnexion
            document.querySelector('.logout-btn').classList.add('opacity-0', 'invisible');
            document.querySelector('.logout-btn').classList.remove('opacity-100', 'visible');
        }

        // --- Toggle Clic ---
        toggleBtn.addEventListener('click', function() {
            const wasCollapsed = sidebar.classList.contains('collapsed');
            
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', !wasCollapsed);

            if (!wasCollapsed) {
                // On réduit
                sidebar.classList.remove('w-[280px]');
                sidebar.classList.add('w-20');
                logoText.classList.add('opacity-0', 'invisible', 'w-0');
                logoText.classList.remove('opacity-100', 'visible', 'w-auto');
                
                // Masquer les textes de navigation
                document.querySelectorAll('.nav-text, .nav-subitem-text').forEach(text => {
                    text.classList.add('opacity-0', 'invisible', 'w-0');
                    text.classList.remove('opacity-100', 'visible', 'w-auto');
                });
                
                // Masquer les titres de section
                document.querySelectorAll('.nav-section-title').forEach(title => {
                    title.classList.add('opacity-0', 'h-0', 'py-0', 'overflow-hidden');
                    title.classList.remove('opacity-100', 'h-auto');
                });
                
                // Masquer les flèches des menus
                document.querySelectorAll('.nav-menu-arrow').forEach(arrow => {
                    arrow.classList.add('opacity-0', 'invisible');
                    arrow.classList.remove('opacity-100', 'visible');
                });
                
                // Masquer les informations utilisateur
                document.querySelectorAll('.user-info, .user-name, .user-role').forEach(el => {
                    el.classList.add('opacity-0', 'invisible', 'w-0');
                    el.classList.remove('opacity-100', 'visible', 'w-auto');
                });
                
                // Masquer le bouton de déconnexion
                document.querySelector('.logout-btn').classList.add('opacity-0', 'invisible');
                document.querySelector('.logout-btn').classList.remove('opacity-100', 'visible');
            } else {
                // On agrandit
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-[280px]');
                logoText.classList.remove('opacity-0', 'invisible', 'w-0');
                logoText.classList.add('opacity-100', 'visible', 'w-auto');
                
                // Afficher les textes de navigation
                document.querySelectorAll('.nav-text, .nav-subitem-text').forEach(text => {
                    text.classList.remove('opacity-0', 'invisible', 'w-0');
                    text.classList.add('opacity-100', 'visible', 'w-auto');
                });
                
                // Afficher les titres de section
                document.querySelectorAll('.nav-section-title').forEach(title => {
                    title.classList.remove('opacity-0', 'h-0', 'py-0', 'overflow-hidden');
                    title.classList.add('opacity-100', 'h-auto');
                });
                
                // Afficher les flèches des menus
                document.querySelectorAll('.nav-menu-arrow').forEach(arrow => {
                    arrow.classList.remove('opacity-0', 'invisible');
                    arrow.classList.add('opacity-100', 'visible');
                });
                
                // Afficher les informations utilisateur
                document.querySelectorAll('.user-info, .user-name, .user-role').forEach(el => {
                    el.classList.remove('opacity-0', 'invisible', 'w-0');
                    el.classList.add('opacity-100', 'visible', 'w-auto');
                });
                
                // Afficher le bouton de déconnexion
                document.querySelector('.logout-btn').classList.remove('opacity-0', 'invisible');
                document.querySelector('.logout-btn').classList.add('opacity-100', 'visible');
            }
        });

        // --- Toggle sous-menus ---
        window.toggleMenu = function(menuId) {
            const menu = document.getElementById(menuId);
            if (!menu) return;

            if (menu.style.maxHeight && menu.style.maxHeight !== "0px") {
                menu.style.maxHeight = "0px";
            } else {
                menu.style.maxHeight = menu.scrollHeight + "px";
            }
        };
    });
</script>