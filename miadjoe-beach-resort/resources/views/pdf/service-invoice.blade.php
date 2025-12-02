<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Service Divers #{{ $vente->id }}</title>
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
    <p><strong>{{ $vente->client_nom ?? 'Client non spécifié' }}</strong></p>
    <p>Type : {{ ucfirst($vente->type_client) }}</p>

    {{-- Détails --}}
    <h2>Détails du Service Divers</h2>
    <p>Facture #{{ $vente->id }}</p>
    <p>Date : {{ $vente->created_at->format('d/m/Y') }}</p>

    {{-- Tableau --}}
    <h2>Prestations</h2>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Mode facturation</th>
                <th>Durée / Qté</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ optional($item->service)->nom ?? 'Service inconnu' }}</td>
                <td>{{ ucfirst($item->mode_facturation) }}</td>
                <td class="right">{{ $item->duree ?? $item->quantite }}</td>
                <td class="right">{{ number_format($item->prix_unitaire,0,',',' ') }} FCFA</td>
                <td class="right">{{ number_format($item->sous_total,0,',',' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Résumé financier --}}
    <h2>Résumé financier</h2>
    <div class="summary">

        {{-- Montant brut --}}
        <p>Montant facturé :
            {{ number_format($vente->invoice->montant_total ?? $vente->total, 0, ',', ' ') }} FCFA
        </p>

        {{-- Remises --}}
        @if($vente->invoice && ($vente->invoice->is_remise 
            || $vente->invoice->montant_final < $vente->invoice->montant_total))

            <p>Remise / Offre :
                @if($vente->invoice->remise_amount)
                    {{ number_format($vente->invoice->remise_amount, 0, ',', ' ') }} FCFA
                @elseif($vente->invoice->remise_percent)
                    {{ $vente->invoice->remise_percent }} %
                @else
                    {{ number_format($vente->invoice->montant_total - $vente->invoice->montant_final, 0, ',', ' ') }} FCFA
                @endif
            </p>
        @endif

        {{-- Motifs Remise (si paiements) --}}
        @foreach($vente->payments as $payment)
            @if($payment->motif_remise)
                <p>Motif Remise (Paiement #{{ $payment->id }}) :
                    {{ $payment->motif_remise }}
                </p>
            @endif
        @endforeach

        {{-- Montant final --}}
        <p>Total à payer :
            {{ number_format($vente->invoice->montant_final ?? $vente->total, 0, ',', ' ') }} FCFA
        </p>

        {{-- Paiements --}}
        <p>Payé :
            {{ number_format($vente->payments->sum('montant'), 0, ',', ' ') }} FCFA
        </p>

        {{-- Restant --}}
        <p>Restant à payer :
            {{ number_format(
                max(0, ($vente->invoice->montant_final ?? $vente->total) - $vente->payments->sum('montant')),
                0, ',', ' ') 
            }} FCFA
        </p>

    </div>

    {{-- Footer --}}
    <p style="text-align:center; font-size:10px; color:#7f8c8d; margin-top:20px;">
        Merci pour votre visite !
    </p>

</body>
</html>
