{{-- resources/views/dashboard/direction/users.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-brown-900 leading-tight">
                    ⚙️ Administration - Paramètres Système
                </h2>
                <p class="text-sm text-brown-600 mt-1">Gérez les configurations globales de l'application</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-brown-100 text-brown-700 rounded-full text-sm font-medium">
                    {{ \App\Models\Setting::count() }} paramètres
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-brown-50 to-amber-50 rounded-xl p-4 border border-brown-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-brown-600">Total Paramètres</p>
                            <p class="text-2xl font-bold text-brown-900 mt-1">
                                {{ \App\Models\Setting::count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-brown-100 rounded-lg">
                            <svg class="w-6 h-6 text-brown-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Paramètres Sécurisés</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">
                                {{ \App\Models\Setting::where('key', 'like', '%password%')->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Dernière Mise à Jour</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1 text-sm">
                                @php
                                    $lastUpdate = \App\Models\Setting::orderBy('updated_at', 'desc')->first();
                                @endphp
                                {{ $lastUpdate ? $lastUpdate->updated_at->diffForHumans() : 'N/A' }}
                            </p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Types de Paramètres</p>
                            <p class="text-2xl font-bold text-purple-900 mt-1">
                                {{ \App\Models\Setting::distinct('key')->count('key') }}
                            </p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content with Fixed Header -->
            <div class="bg-white rounded-2xl shadow-lg border border-brown-200 overflow-hidden">
                <!-- Fixed Header Section -->
                <div class="bg-gradient-to-r from-brown-50 to-amber-50 border-b border-brown-200 p-6 sticky top-0 z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-brown-900">Configuration des Paramètres</h3>
                            <p class="text-sm text-brown-600 mt-1">Gérez tous les paramètres système de l'application</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-white rounded-lg px-3 py-2 border border-brown-200 shadow-sm">
                                <span class="text-sm text-brown-700 font-medium">
                                    Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="overflow-hidden">
                    <div class="max-h-[calc(100vh-300px)] overflow-y-auto">
                        <div class="p-6">
                            {{-- Le composant Livewire est instancié ici --}}
                            @livewire('setting.setting-management')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar for better appearance */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #fdf8f6;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #d2bab0;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #bfa094;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</x-app-layout>

{{-- 
    NOTE IMPORTANTE : 
    Puisque vous avez utilisé wire:confirm dans la vue, vous n'avez plus besoin de script 
    JavaScript séparé pour la confirmation, Laravel/Livewire 3 le gère nativement.
--}}