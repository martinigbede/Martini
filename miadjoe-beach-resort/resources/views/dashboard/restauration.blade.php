{{-- resources/views/dashboard/restaurant.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-amber-900 leading-tight flex items-center">
                    <span class="inline-flex items-center justify-center w-10 h-10 bg-amber-100 rounded-xl mr-3">
                        🍽️
                    </span>
                    Tableau de Bord Restaurant
                </h2>
                <p class="text-amber-600 mt-1 text-sm">Gestion des ventes et performance en temps réel</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm text-amber-500 bg-amber-50 px-3 py-1.5 rounded-full border border-amber-200">
                    📅 {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-amber-50/30 rounded-3xl shadow-2xl border border-amber-100 overflow-hidden">
                @livewire('restaurant.restaurant-dashboard')
            </div>
        </div>
    </div>

    {{-- Styles additionnels pour l'animation des messages flash --}}
    <style>
        @keyframes bounce-in {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.9);
            }
            50% {
                opacity: 1;
                transform: translateY(-5px) scale(1.02);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .animate-bounce-in {
            animation: bounce-in 0.5s ease-out;
        }
    </style>
</x-app-layout>