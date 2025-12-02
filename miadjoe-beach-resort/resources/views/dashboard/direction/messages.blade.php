{{-- resources/views/dashboard/direction/messages.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administration - Gestion des Messages
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            {{-- Le composant Livewire est instancié ici --}}
            @livewire('contact.contact-message-inbox') 
        </div>
    </div>
</x-app-layout>

{{-- 
    NOTE IMPORTANTE : 
    Puisque vous avez utilisé wire:confirm dans la vue, vous n'avez plus besoin de script 
    JavaScript séparé pour la confirmation, Laravel/Livewire 3 le gère nativement.
--}}