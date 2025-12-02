{{-- resources/views/dashboard/direction.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-900 leading-tight flex items-center">
                    <span class="inline-flex items-center justify-center w-10 h-10 bg-purple-100 rounded-xl mr-3">
                        👨‍💼
                    </span>
                    Tableau de Bord Direction
                </h2>
                <p class="text-purple-600 mt-1 text-sm">Vue d'ensemble des performances hôtel et restaurant</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm text-purple-500 bg-purple-50 px-3 py-1.5 rounded-full border border-purple-200">
                    📅 {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }}
                </span>
                <span class="text-sm text-purple-500 bg-purple-50 px-3 py-1.5 rounded-full border border-purple-200">
                    ⚡ Temps réel
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-purple-50/30 rounded-3xl shadow-2xl border border-purple-100 overflow-hidden">
                @livewire('direction.direction-dashboard')
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
        
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(147, 51, 234, 0.1);
            }
            50% {
                box-shadow: 0 0 30px rgba(147, 51, 234, 0.2);
            }
        }
        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
    </style>
</x-app-layout>