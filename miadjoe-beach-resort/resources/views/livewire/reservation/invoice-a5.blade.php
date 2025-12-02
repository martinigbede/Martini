<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Réservation #{{ $reservation->id }}</title>
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
        .tax-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 5px;
            margin: 5px 0;
            border-radius: 3px;
            font-size: 10px;
        }
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
        .sales-table th, .sales-table td {
            border: 1px solid #95a5a6;
            font-size: 10px;
            padding: 3px 5px;
        }
    </style>
</head>
<body>
    <h1>Miadjoe Beach Resort</h1>
    <div class="hotel-info">
        Quartier Kpota, Aného<br>
        Tél : (+228) 92 06 21 21 | 96 99 04 45<br>
        Email : reservationmiadjoebeachresort@gmail.com
    </div>

    <h2>Client</h2>
    <p><strong>{{ $client->nom }} {{ $client->prenom }}</strong></p>
    <p>{{ $client->email }}</p>
    <p>{{ $client->telephone }}</p>

    <h2>Détails de la réservation</h2>
    <p>Réservation #{{ $reservation->id }}</p>
    <p>Check-in : {{ $reservation->check_in }} | Check-out : {{ $reservation->check_out }}</p>
    <p>Nuits : {{ \Carbon\Carbon::parse($reservation->check_in)->diffInDays(\Carbon\Carbon::parse($reservation->check_out)) }}</p>
    <p>Total de personnes : {{ $reservation->items->sum('nb_personnes') }}</p>

    <h2>Chambres réservées</h2>
    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Type</th>
                <th>Nb Pers.</th>
                <th>Lit d'appoint</th>
                <th>Prix / nuit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservation->items as $item)
            <tr>
                <td>{{ $item->room->numero ?? '-' }}</td>
                <td>{{ $item->room->roomType->nom ?? '-' }}</td>
                <td class="right">{{ $item->nb_personnes }}</td>
                <td class="right">{{ $item->lit_dappoint ? 'Oui' : 'Non' }}</td>
                <td class="right">{{ number_format($item->prix_unitaire,0,',',' ') }} FCFA</td>
                <td class="right">{{ number_format($item->total,0,',',' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($reservation->sales->isNotEmpty())
    <h2>Ventes liées</h2>
    <table class="sales-table">
        <thead>
            <tr>
                <th># Vente</th>
                <th>Description</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservation->sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->description ?? 'Services additionnels' }}</td>
                <td class="right">{{ number_format($sale->total,0,',',' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="tax-notice">
        <strong>Note :</strong> Une taxe de séjour de 1 000 FCFA par personne et par nuit est incluse dans le total.
    </div>

    <h2>Résumé financier</h2>
    <div class="summary">
        <p>Montant facturé : {{ number_format($reservation->invoice->montant_total,0,',',' ') }} FCFA</p>

        @if($reservation->invoice->is_remise || $reservation->invoice->montant_final < $reservation->invoice->montant_total)
        <p>Remise / Offre : 
            @if($reservation->invoice->remise_amount)
                {{ $reservation->invoice->remise_amount }} FCFA
            @elseif($reservation->invoice->remise_percent)
                {{ $reservation->invoice->remise_percent }} %
            @else
                {{ number_format($reservation->invoice->montant_total - $reservation->invoice->montant_final,0,',',' ') }} FCFA
            @endif
        </p>
        @endif
        {{-- Motif Remise / Offres --}}
        @foreach($reservation->payments as $payment)
            @if($payment->motif_remise)
                <p>Motif Remise / Offre (Paiement #{{ $payment->id }}) : {{ $payment->motif_remise }}</p>
            @endif
        @endforeach

        <p>Total à payer : {{ number_format($reservation->invoice->montant_final,0,',',' ') }} FCFA</p>
        <p>Payé : {{ number_format($reservation->payments->sum('montant'),0,',',' ') }} FCFA</p>
        <p>Restant à payer : {{ number_format(max(0, $reservation->invoice->montant_final - $reservation->payments->sum('montant')),0,',',' ') }} FCFA</p>
    </div>
</body>
</html>
