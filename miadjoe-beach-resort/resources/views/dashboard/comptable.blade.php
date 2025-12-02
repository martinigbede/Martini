{{-- resources/views/dashboard/ --}}
<x-app-layout>

    <div class="py-6">
       {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            
            {{-- Composant Livewire pour toute la logique comptable --}}
            @livewire('comptabilite.comptabilite-dashboard')

       {{-- </div> --}}
    </div>
</x-app-layout>