{{-- resources/views/livewire/menu/public-menu-display.blade.php --}}
<div class="p-6 bg-gradient-to-b from-white via-gray-50 to-gray-100 shadow-xl rounded-2xl">
    <h1 class="text-4xl font-serif font-extrabold text-center text-gray-800 mb-8 border-b-4 border-amber-500 pb-3">
        🍽️ Notre Menu
    </h1>

    {{-- 🔍 Filtres --}}
    <div class="flex flex-col md:flex-row justify-center items-center mb-10 space-y-3 md:space-y-0 md:space-x-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher un plat..."
               class="form-input rounded-xl shadow-sm w-full md:w-1/3 border-gray-300 focus:ring-amber-500 focus:border-amber-500 transition">

        <select wire:model="categoryFilter" wire:change="$dispatch('refresh')"
                class="p-2 border rounded-xl shadow-sm w-full md:w-1/4 bg-white appearance-none focus:ring-amber-500 focus:border-amber-500 transition">
            <option value="">🍴 Toutes les Catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
            @endforeach
        </select>
    </div>

    {{-- 🍲 Liste des Menus --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($menus as $menu)
            <div class="border border-gray-200 rounded-2xl shadow-md overflow-hidden flex flex-col bg-white hover:shadow-xl hover:scale-[1.02] transition-transform duration-300">
                
                {{-- 📸 Photo --}}
                <div class="h-40 bg-gray-200 overflow-hidden">
                    @if ($menu->photo)
                        <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->nom }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500 text-sm">Image Non Disponible</div>
                    @endif
                </div>
                
                {{-- 📝 Infos du menu --}}
                <div class="p-5 flex-grow flex flex-col">
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ $menu->nom }}</h2>
                    <p class="text-sm text-amber-600 font-medium mb-2 uppercase">{{ $menu->categorie }}</p>
                    <p class="text-gray-600 text-sm flex-grow leading-relaxed">
                        {{ $menu->description ?? 'Description non fournie.' }}
                    </p>

                    {{-- 💰 Prix par unité (si applicable) --}}
                    @if($menu->units && $menu->units->count() > 0)
                        <div class="mt-4 bg-amber-50 border border-amber-100 rounded-lg p-3">
                            <p class="text-sm font-semibold text-amber-700 mb-1">Prix par unité :</p>
                            <ul class="text-sm text-gray-700 space-y-1">
                                @foreach($menu->units as $unit)
                                    <li class="flex justify-between">
                                        <span>{{ ucfirst($unit->unit) }}</span>
                                        <span class="font-medium">{{ number_format($unit->price, 0, ',', ' ') }} FCFA</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                
                {{-- 💵 Pied de carte --}}
                <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                    <span class="text-xl font-bold text-green-700">
                        {{ number_format($menu->prix, 0, ',', ' ') }} FCFA
                    </span>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $menu->disponibilite ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $menu->disponibilite ? 'DISPONIBLE' : 'RUPTURE' }}
                    </span>
                </div>
            </div>
        @empty
            {{-- 🟡 Aucun plat --}}
            <div class="md:col-span-3 text-center p-10 bg-yellow-50 rounded-xl border border-yellow-200">
                <p class="text-lg font-semibold text-yellow-800">Aucun plat disponible actuellement 🍛</p>
                <p class="text-sm text-yellow-600 mt-1">Vérifiez les filtres ou revenez plus tard.</p>
            </div>
        @endforelse
    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-8">
        {{ $menus->links() }}
    </div>
</div>
