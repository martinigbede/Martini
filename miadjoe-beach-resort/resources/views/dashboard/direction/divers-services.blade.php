{{-- resources/views/dashboard/direction/divers-services.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-br from-brown-600 to-brown-800 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 bg-gradient-to-r from-gray-900 to-brown-800 bg-clip-text text-transparent">
                        Services Divers
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Gestion des services supplémentaires</p>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center space-x-2 text-sm text-brown-600 bg-brown-50 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Gérez vos services en temps réel</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-brown-50/30 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Composant Livewire --}}
                    @livewire('divers-service-component')
        </div>
    </div>
</x-app-layout>