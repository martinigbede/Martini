<div class="mt-3">
    <h4 class="px-4 text-xs text-gray-500 uppercase nav-section-title">Direction</h4>

    <a href="{{ route('dashboard.direction') }}"
       class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('dashboard.direction') ? 'bg-gray-200' : '' }}">
        <span class="nav-text">Accueil Direction</span>
    </a>

    <a href="{{ route('dashboard.direction.users') }}"
       class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('dashboard.direction.users') ? 'bg-gray-200' : '' }}">
        <span class="nav-text">Utilisateurs</span>
    </a>

    <a href="{{ route('dashboard.direction.messages') }}"
       class="block px-4 py-2 hover:bg-gray-100 {{ request()->routeIs('dashboard.direction.messages') ? 'bg-gray-200' : '' }}">
        <span class="nav-text">Messages</span>
    </a>
</div>
