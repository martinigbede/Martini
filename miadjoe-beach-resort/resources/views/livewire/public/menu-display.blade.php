{{-- resources/views/livewire/public/menu-display.blade.php --}}
<div>
    {{-- Notification Messages (Pour les erreurs de chargement, etc.) --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @forelse ($categories as $category)
        <div class="mb-12 p-6 border-b border-gray-200">
            <h2 class="text-3xl font-bold text-indigo-700 border-b-2 border-indigo-200 pb-2 mb-6">{{ $category->name }}</h2>
            <div class="space-y-6">
                @forelse ($category->menus as $menuItem)
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-dashed pb-3 last:border-b-0">
                        <div class="flex-1 min-w-0 pr-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $menuItem->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $menuItem->description }}</p>
                        </div>
                        
                        {{-- Image (si elle existe) --}}
                        @if ($menuItem->image_path)
                            <img src="{{ asset($menuItem->image_path) }}" alt="{{ $menuItem->title }}" 
                                 class="w-24 h-24 object-cover rounded-lg mb-2 md:mb-0 md:ml-4 shrink-0">
                        @endif

                        <div class="text-lg font-bold text-gray-900 ml-4 shrink-0">
                            {{ number_format($menuItem->price, 2) }} €
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 italic p-4 border rounded">Aucun plat actif dans cette catégorie pour le moment.</p>
                @endforelse
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500 text-lg italic p-10 border rounded">Le restaurant est actuellement fermé ou son menu n'est pas encore publié.</p>
    @endforelse
</div>