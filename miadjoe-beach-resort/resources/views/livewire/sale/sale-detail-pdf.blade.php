<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $sale->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f3f3f3; }
        h1, h2 { margin: 0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Facture #{{ $sale->id }}</h1>
    <p>Date : {{ $sale->date }}</p>

    @if($sale->reservation)
        <p>Client : {{ $sale->reservation->client->nom ?? 'N/A' }}</p>
        <p>Chambre : {{ $sale->reservation->room->numero ?? 'N/A' }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Unité</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->menu->nom ?? 'N/A' }}</td>
                    <td>{{ $item->unite ?? '-' }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td class="text-right">{{ number_format($item->prix_unitaire, 2) }} €</td>
                    <td class="text-right">{{ number_format($item->total, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 10px;">
        <p>Total payé : {{ number_format($payment_amount, 2) }} €</p>
        <p>Reste à payer : {{ number_format($reste, 2) }} €</p>
        <p><strong>Total général : {{ number_format($sale->total, 2) }} €</strong></p>
    </div>
</body>
</html>
