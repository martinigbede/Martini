<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $subjectText }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; color: #333; margin:0; padding:0;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo Hôtel" style="height: 60px;">
        </div>

        <!-- Sujet -->
        <h2 style="color: #2563eb; font-size: 24px; margin-bottom: 15px;">{{ $subjectText }}</h2>

        <!-- Message -->
        <p style="font-size: 16px; line-height: 1.5;">{{ $messageText }}</p>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

        <!-- Détails réservation -->
        <p style="font-weight: bold; margin-bottom: 10px;">Détails de la réservation :</p>

        <ul style="padding-left: 20px; font-size: 15px; line-height: 1.6;">
            <li><strong>Client :</strong> {{ $reservation->client->nom ?? '' }} {{ $reservation->client->prenom ?? '' }}</li>
            <li><strong>Arrivée :</strong> {{ $reservation->check_in ? \Carbon\Carbon::parse($reservation->check_in)->format('d/m/Y') : 'N/A' }}</li>
            <li><strong>Départ :</strong> {{ $reservation->check_out ? \Carbon\Carbon::parse($reservation->check_out)->format('d/m/Y') : 'N/A' }}</li>
            <li><strong>Chambres réservées :</strong>
                <ul style="padding-left: 15px; list-style-type: disc;">
                    @foreach($reservation->items as $item)
                        <li> {{ $item->room?->numero ?? '—' }} </li>
                    @endforeach
                </ul>
            </li>
            <li><strong>Statut :</strong> {{ ucfirst($reservation->statut ?? 'non défini') }}</li>
            <li><strong>Total :</strong> {{ number_format($reservation->total, 0, ',', ' ') }} FCFA</li>
        </ul>

        <p style="margin-top: 20px; font-size: 16px;">Merci d’avoir choisi notre service 🌴</p>

        <!-- Footer -->
        <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 13px; color: #666; text-align: center;">
            <p>📞 Téléphone : +228 92 06 21 21 | 96 99 04 45</p>
            <p>✉️ Email : reservation@miadjoebeachresort.com</p>
            <p style="margin-top:10px;">&copy; {{ date('Y') }} Miadjoe Beach Resort. Tous droits réservés.</p>
        </div>

    </div>
</body>
</html>
