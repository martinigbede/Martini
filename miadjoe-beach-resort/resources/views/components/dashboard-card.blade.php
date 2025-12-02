@props(['title', 'value', 'icon', 'color' => 'bg-gray-500'])
<div class="p-4 rounded-lg text-white {{ $color }} shadow">
    <div class="text-3xl">{{ $icon }}</div>
    <div class="text-sm uppercase">{{ $title }}</div>
    <div class="text-2xl font-bold">{{ number_format($value, 0, ',', ' ') }} FCFA</div>
</div>
