<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Vente #{{ $sale->id }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11px; 
            margin: 10px;
            line-height: 1.4;
            color: #2c3e50;
        }
        h1 { 
            text-align: center; 
            color: #d35400;
            margin-bottom: 5px;
            font-size: 16px;
        }
        h2 {
            color: #34495e;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 2px;
            margin-top: 15px;
            font-size: 13px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 5px;
            margin-bottom: 10px;
            font-size: 10px;
        }
        th, td { 
            border: 1px solid #7f8c8d; 
            padding: 4px 6px; 
            text-align: left; 
        }
        th {
            background-color: #ecf0f1;
        }
        .right { text-align: right; }
        .hotel-info {
            text-align: center;
            margin-bottom: 10px;
            font-size: 10px;
            color: #34495e;
        }
        .summary p {
            margin: 2px 0;
            font-size: 10px;
        }
    </style>
</head>
<body>

    {{-- En-tête --}}
    <h1>Miadjoe Beach Resort</h1>
    <div class="hotel-info">
        Quartier Kpota, Aného<br>
        Tél : (+228) 92 06 21 21 | 96 99 04 45<br>
        Email : reservations@miadjoebeachresort.com
    </div>

    {{-- CLIENT --}}
    <h2>Client</h2>
    @if($sale->reservation)
        <p><strong>{{ $sale->reservation->client->nom }} {{ $sale->reservation->client->prenom }}</strong></p>
        <p>{{ $sale->reservation->client->email }}</p>
        <p>{{ $sale->reservation->client->telephone }}</p>
    @else
        <p><strong>Client : </strong>Non spécifié</p>
    @endif

    {{-- Détails vente --}}
    <h2>Détails de la Vente</h2>
    <p>Vente #{{ $sale->id }}</p>
    <p>Date : {{ $sale->date }}</p>

    @if($sale->reservation)
        <p>Chambre liée : {{ $sale->reservation->items->first()->room->numero ?? 'N/A' }}</p>
    @endif

    {{-- Tableau des articles --}}
    <h2>Articles</h2>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Unité</th>
                <th>Qté</th>
                <th>Prix unité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->menu->nom ?? 'N/A' }}</td>
                <td>{{ $item->unite ?? '-' }}</td>
                <td class="right">{{ $item->quantite }}</td>
                <td class="right">{{ number_format($item->prix_unitaire,0,',',' ') }} FCFA</td>
                <td class="right">{{ number_format($item->total,0,',',' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Résumé financier --}}
    <h2>Résumé financier</h2>
    <div class="summary">

        {{-- Montant brut avant remises --}}
        <p>Montant facturé : 
            {{ number_format($sale->invoice->montant_total ?? $total, 0, ',', ' ') }} FCFA
        </p>

        {{-- Remises --}}
        @if($sale->invoice && ($sale->invoice->is_remise 
            || $sale->invoice->montant_final < $sale->invoice->montant_total))

            <p>Remise / Offre :
                @if($sale->invoice->remise_amount)
                    {{ number_format($sale->invoice->remise_amount, 0, ',', ' ') }} FCFA
                @elseif($sale->invoice->remise_percent)
                    {{ $sale->invoice->remise_percent }} %
                @else
                    {{-- Cas où la remise est seulement calculée (ex : final < total) --}}
                    {{ number_format($sale->invoice->montant_total - $sale->invoice->montant_final, 0, ',', ' ') }} FCFA
                @endif
            </p>
        @endif

        {{-- Motif(s) remise(s) venant des paiements --}}
        @if($sale->payments)
            @foreach($sale->payments as $payment)
                @if($payment->motif_remise)
                    <p>Motif Remise / Offre (Paiement #{{ $payment->id }}) :
                        {{ $payment->motif_remise }}
                    </p>
                @endif
            @endforeach
        @endif

        {{-- Montant après remises --}}
        <p>Total à payer :
            {{ number_format($sale->invoice->montant_final ?? $total, 0, ',', ' ') }} FCFA
        </p>

        {{-- Paiements --}}
        <p>Payé :
            {{ number_format($sale->payments->sum('montant') ?? 0, 0, ',', ' ') }} FCFA
        </p>

        {{-- Restant --}}
        <p>Restant à payer :
            {{ number_format(
                max(0, ($sale->invoice->montant_final ?? $total) - $sale->payments->sum('montant')),
                0, ',', ' '
            ) }} FCFA
        </p>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <p style="text-align: center; font-size: 10px; color: #7f8c8d; margin-top: 20px;">
            Merci pour votre visite !
        </p>
    </div>

</body>
</html>
