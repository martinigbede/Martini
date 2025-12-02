{{-- resources/views/dashboard/comptable/historique.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historique Des payements
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            {{-- Le composant Livewire est instancié ici --}}
            @livewire('comptabilite.historique-comptable') 
        </div>
    </div>
</x-app-layout>