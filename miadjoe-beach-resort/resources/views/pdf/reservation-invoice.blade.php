<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Réservation #{{ $reservation->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #aaa; }
        th, td { padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Facture Réservation #{{ $reservation->id }}</h1>
    <p><strong>Client :</strong> {{ $reservation->client->nom ?? 'Inconnu' }}</p>
    <p><strong>Chambres :</strong> {{ $reservation->rooms->pluck('nom')->join(', ') }}</p>
    <p><strong>Dates :</strong> {{ $reservation->check_in }} → {{ $reservation->check_out }}</p>

    <h3>Ventes associées</h3>
    <table>
        <thead>
            <tr><th>ID Vente</th><th>Montant</th></tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->total }} F</td>
                </tr>
            @empty
                <tr><td colspan="2" style="text-align:center;">Aucune vente</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Paiements</h3>
    <table>
        <thead>
            <tr><th>Date</th><th>Mode</th><th>Montant</th></tr>
        </thead>
        <tbody>
            @forelse($payments as $pay)
                <tr>
                    <td>{{ $pay->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $pay->mode_paiement }}</td>
                    <td>{{ $pay->montant }} F</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;">Aucun paiement</td></tr>
            @endforelse
        </tbody>
    </table>

    <p style="text-align:right; margin-top:15px;">
        <strong>Total :</strong> {{ $total }} F<br>
        <strong>Payé :</strong> {{ $paid }} F<br>
        <strong>Reste à payer :</strong> {{ $remaining }} F
    </p>
</body>
</html>
