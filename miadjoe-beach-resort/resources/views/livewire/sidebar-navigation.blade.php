<div 
    x-data="{
        collapsed: @entangle('collapsed').live,
        activeMenus: @entangle('activeMenus').live,
        isMobile: window.innerWidth < 768,
        
        init() {
            // Détecter si on est sur mobile
            this.checkMobile();
            window.addEventListener('resize', () => {
                this.checkMobile();
            });
            
            // Initialiser depuis localStorage
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                this.collapsed = true;
                this.$nextTick(() => this.applyCollapsedStyles());
            }
            
            // Écouter les événements Livewire
            this.$wire.$on('sidebar-toggled', ({ collapsed }) => {
                this.collapsed = collapsed;
                localStorage.setItem('sidebarCollapsed', collapsed);
                this.applyCollapsedStyles();
            });
            
            // Appliquer les styles initiaux
            this.$nextTick(() => {
                if (this.collapsed) {
                    this.applyCollapsedStyles();
                }
            });
        },
        
        checkMobile() {
            this.isMobile = window.innerWidth < 768;
            if (this.isMobile) {
                // Sur mobile, la sidebar est cachée par défaut
                this.$refs.sidebar.classList.add('hidden');
                this.$refs.mobileToggle.classList.remove('hidden');
            } else {
                // Sur desktop, montrer la sidebar
                this.$refs.sidebar.classList.remove('hidden');
                this.$refs.mobileToggle.classList.add('hidden');
            }
        },
        
        toggleMobile() {
            this.$refs.sidebar.classList.toggle('hidden');
            this.$refs.overlay.classList.toggle('hidden');
        },
        
        applyCollapsedStyles() {
            const sidebar = this.$refs.sidebar;
            if (this.collapsed) {
                sidebar.classList.remove('w-[280px]');
                sidebar.classList.add('w-20');
                this.toggleElementsVisibility(false);
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-[280px]');
                this.toggleElementsVisibility(true);
            }
        },
        
        toggleElementsVisibility(show) {
            const selectors = ['.nav-text', '.nav-subitem-text', '.nav-section-title', 
                             '.user-info', '.user-name', '.user-role', '.logo-text'];
            selectors.forEach(selector => {
                const elements = this.$refs.sidebar.querySelectorAll(selector);
                elements.forEach(el => {
                    if (show) {
                        el.classList.remove('opacity-0', 'invisible', 'w-0', 'h-0', 'py-0', 'overflow-hidden');
                        el.classList.add('opacity-100', 'visible', 'w-auto', 'h-auto');
                    } else {
                        el.classList.add('opacity-0', 'invisible', 'w-0');
                        el.classList.remove('opacity-100', 'visible', 'w-auto');
                    }
                });
            });
        },
        
        toggleMenu(menuId) {
            this.$wire.toggleMenu(menuId);
        },
        
        isMenuOpen(menuId) {
            return this.activeMenus && this.activeMenus[menuId];
        }
    }"
    x-ref="sidebarContainer"
>
    <!-- Overlay pour mobile -->
    <div x-ref="overlay" @click="toggleMobile()" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>
    
    <!-- Bouton mobile toggle -->
    <button 
        x-ref="mobileToggle"
        @click="toggleMobile()"
        class="fixed bottom-4 right-4 z-50 bg-brown-600 text-white p-3 rounded-full shadow-lg hover:bg-brown-700 transition-colors duration-200 hidden"
    >
        <i class="fas fa-bars text-lg"></i>
    </button>
    
    <aside 
        x-ref="sidebar"
        id="sidebar"
        :class="{
            'w-20': collapsed && !isMobile,
            'w-[280px]': !collapsed || isMobile
        }"
        class="fixed top-0 left-0 h-full z-50 bg-white shadow-xl border-r border-brown-200 transition-all duration-300 ease-in-out flex flex-col"
    >
        <!-- HEADER -->
        <div class="flex items-center justify-between border-b border-brown-200 bg-gradient-to-b from-white to-brown-50 p-3">
            <div class="flex items-center gap-3 transition-all duration-300 ease-in-out">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-b from-brown-600 to-brown-800 font-bold text-white shadow-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-full w-full object-cover rounded-xl">
                </div>
                <span class="logo-text text-xl font-bold tracking-tight bg-gradient-to-b from-brown-800 to-brown-600 bg-clip-text text-transparent transition-all duration-300 ease-in-out">
                    Miadjoe Resort
                </span>
            </div>

            <!-- TOGGLE BUTTON - Desktop -->
            <button 
                @click="$wire.toggleSidebar()"
                class="flex items-center justify-center rounded-lg border border-brown-200 bg-brown-100 p-2 text-brown-700 shadow-sm 
                       transition-all duration-300 ease-in-out hover:border-brown-300 hover:bg-brown-200 hover:shadow-md"
                x-show="!isMobile"
            >
                <i :class="{'fa-chevron-left': !collapsed, 'fa-chevron-right': collapsed}" 
                   class="fas transition-transform duration-300 ease-in-out"></i>
            </button>
            
            <!-- Close button - Mobile -->
            <button 
                @click="toggleMobile()"
                class="flex items-center justify-center rounded-lg border border-brown-200 bg-brown-100 p-2 text-brown-700 shadow-sm 
                       transition-all duration-300 ease-in-out hover:border-brown-300 hover:bg-brown-200 hover:shadow-md"
                x-show="isMobile"
            >
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="flex flex-1 flex-col gap-2 p-2 overflow-y-auto">
            <!-- PRINCIPAL -->
            <div class="mb-2">
                <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">
                    Principal
                </div>
                <a href="{{ route('dashboard') }}" wire:navigate class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                    <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                        Tableau de bord
                    </span>
                </a>
            </div>

            <!-- DIRECTION -->
            @if($isDirection)
            <div class="mb-2">
                <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">
                    Direction
                </div>

                <!-- Tableaux de bord Direction -->
                <div class="nav-menu mb-1">
                    <div @click="toggleMenu('direction-dashboards-menu')" class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50">
                        <div class="flex items-center">
                            <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                                Tableaux de bord
                            </span>
                        </div>
                        <i class="fas fa-chevron-down nav-menu-arrow h-4 w-4 transition-all duration-300 ease-in-out" :class="{'transform rotate-180': isMenuOpen('direction-dashboards-menu')}"></i>
                    </div>
                    <div x-show="isMenuOpen('direction-dashboards-menu')" x-collapse class="bg-brown-50">
                        <a href="{{ route('dashboard.direction') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500">
                            <div class="mr-3"><i class="fas fa-eye"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Vue d'ensemble
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Gestion Hôtelière -->
                <div class="nav-menu mb-1">
                    <div @click="toggleMenu('direction-gestion-menu')" class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50">
                        <div class="flex items-center">
                            <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                                Gestion Hôtelière
                            </span>
                        </div>
                        <i class="fas fa-chevron-down nav-menu-arrow h-4 w-4 transition-all duration-300 ease-in-out" :class="{'transform rotate-180': isMenuOpen('direction-gestion-menu')}"></i>
                    </div>
                    <div x-show="isMenuOpen('direction-gestion-menu')" x-collapse class="bg-brown-50">
                        <a href="{{ route('dashboard.gestion.room-types') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.room-types') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-tags"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Types de chambres
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.rooms') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.rooms') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-bed"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Gestion des chambres
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.reservations') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.reservations') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-calendar-alt"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Réservations
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.vente-services') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-money-bill-wave"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Ventes de services
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.calendar') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.calendar') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-calendar"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Calendrier
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Administration -->
                <div class="nav-menu mb-1">
                    <div @click="toggleMenu('direction-admin-menu')" class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50">
                        <div class="flex items-center">
                            <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                                Administration
                            </span>
                        </div>
                        <i class="fas fa-chevron-down nav-menu-arrow h-4 w-4 transition-all duration-300 ease-in-out" :class="{'transform rotate-180': isMenuOpen('direction-admin-menu')}"></i>
                    </div>
                    <div x-show="isMenuOpen('direction-admin-menu')" x-collapse class="bg-brown-50">
                        <a href="{{ route('dashboard.directions.divers-services') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.directions.divers-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-plus-circle"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Divers Services
                            </span>
                        </a>
                        <a href="{{ route('dashboard.direction.users') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.direction.users') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-users"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Utilisateurs
                            </span>
                        </a>
                        <a href="{{ route('dashboard.direction.messages') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.direction.messages') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-comments"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Messages
                            </span>
                        </a>
                        <a href="{{ route('dashboard.direction.settings') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.direction.settings') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-tools"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Paramètres
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Multimédia -->
                <div class="nav-menu mb-1">
                    <div @click="toggleMenu('direction-gallery-menu')" class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50">
                        <div class="flex items-center">
                            <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                                <i class="fas fa-images"></i>
                            </div>
                            <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                                Multimédia
                            </span>
                        </div>
                        <i class="fas fa-chevron-down nav-menu-arrow h-4 w-4 transition-all duration-300 ease-in-out" :class="{'transform rotate-180': isMenuOpen('direction-gallery-menu')}"></i>
                    </div>
                    <div x-show="isMenuOpen('direction-gallery-menu')" x-collapse class="bg-brown-50">
                        <a href="{{ route('dashboard.gestion.gallery') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.gallery') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-camera"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Galerie photos
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- COMPTABILITÉ -->
            @if($isComptable)
            <div class="mb-2">
                <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">
                    Comptabilité
                </div>

                <a href="{{ route('dashboard.comptable') }}" wire:navigate class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.comptable') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                    <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                        Tableau de bord
                    </span>
                </a>

                <a href="{{ route('dashboard.caisse') }}" wire:navigate class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.caisse') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                    <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                        Caisse
                    </span>
                </a>

                <a href="{{ route('dashboard.caisse.depenses') }}" wire:navigate class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.caisse.depenses') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                    <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                        Gestion Dépenses
                    </span>
                </a>

                <a href="{{ route('dashboard.comptable.historique') }}" wire:navigate class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.comptable.historique') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                    <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                        <i class="fas fa-history"></i>
                    </div>
                    <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                        Historique
                    </span>
                </a>
            </div>
            @endif

            <!-- RÉCEPTION -->
            @if($isReception)
            <div class="mb-2">
                <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">
                    Réception
                </div>

                <a href="{{ route('dashboard.reception') }}" wire:navigate class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.reception') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                    <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                        Tableau de bord
                    </span>
                </a>

                <!-- Menu Gestion Réception -->
                <div class="nav-menu mb-1">
                    <div @click="toggleMenu('reception-gestion-menu')" class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50">
                        <div class="flex items-center">
                            <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                                Gestion
                            </span>
                        </div>
                        <i class="fas fa-chevron-down nav-menu-arrow h-4 w-4 transition-all duration-300 ease-in-out" :class="{'transform rotate-180': isMenuOpen('reception-gestion-menu')}"></i>
                    </div>
                    <div x-show="isMenuOpen('reception-gestion-menu')" x-collapse class="bg-brown-50">
                        <a href="{{ route('dashboard.gestion.caisse-hebergement') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.caisse-hebergement') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-money-bill-alt"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Caisse Hébergement
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.reservations') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.reservations') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-calendar-alt"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Réservations
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.calendar') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.calendar') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-calendar"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Calendrier
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.rooms') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.rooms') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-bed"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                État des chambres
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.vente-services') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-money-bill-wave"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Ventes de services
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.clients') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.clients') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-users"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Gestion des clients
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- RESTAURATION -->
            @if($isRestauration)
            <div class="mb-2">
                <div class="nav-section-title px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-brown-500 transition-all duration-300 ease-in-out">
                    Restauration
                </div>

                <a href="{{ route('dashboard.restauration') }}" wire:navigate class="nav-item group flex items-center rounded-lg border-l-[4px] border-transparent px-3 py-2.5 text-brown-700 transition-all duration-300 ease-in-out hover:translate-x-[4px] hover:border-l-brown-600 hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50 hover:shadow-md {{ request()->routeIs('dashboard.restauration') ? 'active !border-l-brown-600 !bg-gradient-to-b !from-brown-100 !to-brown-50 shadow-inner' : '' }}">
                    <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out group-[.active]:text-brown-700 group-[.active]:scale-110">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                        Tableau de bord
                    </span>
                </a>

                <!-- Menu Gestion Restauration -->
                <div class="nav-menu mb-1">
                    <div @click="toggleMenu('restauration-gestion-menu')" class="nav-menu-header group flex cursor-pointer items-center rounded-lg px-3 py-2 transition-all duration-300 ease-in-out hover:bg-gradient-to-b hover:from-brown-100 hover:to-brown-50">
                        <div class="flex items-center">
                            <div class="mr-3 flex h-5 w-5 items-center justify-center text-brown-600 transition-all duration-300 ease-in-out">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <span class="nav-text whitespace-nowrap text-sm font-semibold opacity-100 transition-all duration-300 ease-in-out">
                                Gestion
                            </span>
                        </div>
                        <i class="fas fa-chevron-down nav-menu-arrow h-4 w-4 transition-all duration-300 ease-in-out" :class="{'transform rotate-180': isMenuOpen('restauration-gestion-menu')}"></i>
                    </div>
                    <div x-show="isMenuOpen('restauration-gestion-menu')" x-collapse class="bg-brown-50">
                        <a href="{{ route('dashboard.gestion.caisse-restaurant') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.caisse-hebergement') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-money-bill-alt"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Caisse Restaurant
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.menus') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.menus') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-file-alt"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Menus & Carte
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.sales') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.sales') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-shopping-cart"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Commandes & Ventes
                            </span>
                        </a>
                        <a href="{{ route('dashboard.gestion.vente-services') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-money-bill-wave"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Ventes de services
                            </span>
                        </a>
                        <a href="{{ route('dashboard.caisse.depenses') }}" wire:navigate class="nav-subitem group flex items-center px-3 py-2 pl-10 text-sm text-brown-600 transition-all duration-300 ease-in-out hover:pl-[42px] hover:bg-brown-100 hover:text-brown-800 hover:border-l-3 hover:border-brown-500 {{ request()->routeIs('dashboard.gestion.vente-services') ? 'active !border-l-brown-500 !bg-brown-200 !text-brown-900 !font-semibold' : '' }}">
                            <div class="mr-3"><i class="fas fa-chart-line"></i></div>
                            <span class="nav-subitem-text whitespace-nowrap opacity-100 transition-all duration-300 ease-in-out">
                                Gestion des Dépenses
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </nav>

        <!-- FOOTER UTILISATEUR -->
        <div class="mt-auto border-t border-brown-200 bg-brown-50 p-3">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-b from-brown-500 to-brown-700 font-semibold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="user-info flex-1 min-w-0">
                    <div class="user-name text-sm font-semibold text-brown-900 transition-all duration-300 ease-in-out">
                        {{ $user->name }}
                    </div>
                    <div class="user-role text-xs text-brown-600 transition-all duration-300 ease-in-out">
                        {{ $user->role->name ?? 'Utilisateur' }}
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn rounded bg-none p-2 text-brown-600 transition-all duration-200 hover:bg-red-50 hover:text-red-500" title="Déconnexion">
                        <i class="fas fa-sign-out-alt h-5 w-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>
</div>