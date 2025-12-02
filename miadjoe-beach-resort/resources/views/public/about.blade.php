</x-layouts.public>

@section('title', 'À propos — Miadjoe Beach Resort')
@section('meta_description', "Découvrez l'histoire, la mission et les services du Miadjoe Beach Resort.")

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="display-4">À propos</h1>
            <p class="lead">Bienvenue au Miadjoe Beach Resort — un havre de paix au bord de la mer, dédié au confort, à la détente et à la découverte.</p>
        </div>
        <div class="col-md-4 text-md-right">
            <a href="{{ route('contact') }}" class="btn btn-primary">Contactez-nous</a>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-6">
            <h2>Notre histoire</h2>
            <p>Depuis notre ouverture, nous offrons une expérience authentique combinant hospitalité locale et services soignés. Notre équipe s'engage pour votre confort et la préservation de l'environnement.</p>
        </div>
        <div class="col-md-6">
            <h2>Notre mission</h2>
            <p>Créer des souvenirs durables grâce à un accueil chaleureux, des activités variées et des installations confortables adaptées à tous.</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <h3>Ce que nous proposons</h3>
            <ul class="list-unstyled row">
                <li class="col-md-4 mb-3"><strong>Plage privée</strong><br>Accès direct, transats et services de plage.</li>
                <li class="col-md-4 mb-3"><strong>Restauration</strong><br>Spécialités locales et menus internationaux.</li>
                <li class="col-md-4 mb-3"><strong>Activités</strong><br>Plongée, excursions, bien-être et animations.</li>
            </ul>
        </div>
    </div>

    <div class="row bg-light p-4 rounded">
        <div class="col-md-9">
            <h4>Prêt à réserver votre séjour ?</h4>
            <p>Contactez notre équipe pour une réservation ou des questions sur nos offres.</p>
        </div>
        <div class="col-md-3 text-md-right">
            <a href="" class="btn btn-success">Réserver</a>
        </div>
    </div>
</div>
</x-layouts.public>