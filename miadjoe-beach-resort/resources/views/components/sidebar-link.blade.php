@props(['route', 'icon', 'label'])
<a href="{{ route($route) }}"
   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition
          {{ request()->routeIs($route) ? 'bg-brown-700 text-white' : 'text-gray-700 hover:bg-brown-100' }}">
    {{ $label }}
</a>
