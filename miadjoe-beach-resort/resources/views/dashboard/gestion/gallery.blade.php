{{-- resources/views/dashboard/gestion/gallery.blade.php --}}
<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion de la Galerie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @livewire('gallery.gallery-management')
            </div>
        </div>
    </div>
</x-app-layout>