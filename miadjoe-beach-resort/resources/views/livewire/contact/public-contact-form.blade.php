{{-- resources/views/livewire/contact/public-contact-form.blade.php --}}
<div class="bg-white rounded-3xl shadow-2xl border border-brown-100 overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        
        <!-- Informations côté formulaire -->
        <div class="bg-gradient-to-br from-amber-600 to-amber-700 p-10 text-white">
            <h2 class="text-3xl font-light mb-6">Envoyez-nous un Message</h2>
            <p class="text-amber-100 text-lg leading-relaxed mb-8">
                Notre équipe vous répondra dans les plus brefs délais. 
                Pour les réservations urgentes, nous vous recommandons d'appeler directement.
            </p>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold">Réponse sous 24h</p>
                        <p class="text-amber-100 text-sm">Pour tous les emails</p>
                    </div>
                </div>
                
                {{-- Autres blocs d'information (Gardés tels quels) --}}
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold">Service Personnalisé</p>
                        <p class="text-amber-100 text-sm">Adapté à vos besoins</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold">Rapidité d'exécution</p>
                        <p class="text-amber-100 text-sm">Pour les demandes urgentes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire HTML Simple et Élégant -->
        <div class="p-12">
            
            @if($formSubmitted)
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">Votre message a bien été envoyé. Nous vous répondrons rapidement.</span>
                </div>
            @endif
            
            <h3 class="text-2xl font-light text-gray-900 mb-2">Formulaire de Contact</h3>
            <p class="text-gray-600 mb-8">Remplissez ce formulaire et nous vous recontacterons</p>
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Prénom --}}
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                        <input type="text" id="first_name" wire:model.defer="first_name" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                        @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    {{-- Nom --}}
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                        <input type="text" id="last_name" wire:model.defer="last_name" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                        @error('last_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" wire:model.defer="email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                {{-- Téléphone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                    <input type="tel" id="phone" wire:model.defer="phone" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                    @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                {{-- Sujet --}}
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                    <select id="subject" wire:model.defer="subject" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                        <option value="">Choisissez un sujet</option>
                        <option value="reservation">Réservation</option>
                        <option value="information">Demande d'information</option>
                        <option value="group">Événement de groupe</option>
                        <option value="other">Autre</option>
                    </select>
                    @error('subject') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                {{-- Message --}}
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="message" wire:model.defer="message" rows="5"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition-all duration-200">
                    </textarea>
                    @error('message') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-amber-600 to-amber-700 text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-[1.01]">
                    Envoyer le Message
                </button>
            </div>
        </div>
    </div>
</div>