<x-layouts.public>

@section('title', 'Paiement réussi')


<div class="min-h-screen flex flex-col items-center justify-center bg-green-50 p-4">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-md text-center">
        <h1 class="text-2xl font-bold text-green-600 mb-4">Paiement réussi !</h1>
        <p class="mb-4">Merci ! Votre réservation a été enregistrée et votre paiement a été validé.</p>
        <a href="{{ url('/') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
            Retour à l'accueil
        </a>
    </div>
</div>


</x-layouts.public>

