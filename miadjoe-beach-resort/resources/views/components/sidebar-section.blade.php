@props(['title'])
<div class="mt-4">
    <h3 class="text-xs font-semibold uppercase text-gray-400 mb-1">{{ $title }}</h3>
    <div class="space-y-1">
        {{ $slot }}
    </div>
</div>
