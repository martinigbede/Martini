<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket Vente #{{ $sale->id }}</title>
    <style>
        @page { margin: 0; size: 80mm auto; }
        body { 
            font-family: 'Courier New', monospace;
            font-size: 9px;
            margin: 0;
            padding: 4mm;
            width: 72mm;
            line-height: 1.2;
        }
        * { 
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 1px dashed #000;
        }
        .hotel-name {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }
        .hotel-info {
            font-size: 8px;
            margin-bottom: 3px;
        }
        .ticket-info {
            font-size: 8px;
            font-weight: bold;
        }
        .section {
            margin: 5px 0;
            padding: 3px 0;
        }
        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 1px;
            margin-bottom: 3px;
            font-size: 9px;
        }
        .client-line, .info-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1px;
            font-size: 8px;
        }
        .client-label, .info-label {
            font-weight: bold;
        }
        .table {
            width: 100%;
            margin: 4px 0;
        }
        .table-header {
            border-bottom: 1px solid #000;
            padding: 2px 0;
            font-weight: bold;
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1fr 1fr;
            gap: 2px;
            font-size: 8px;
        }
        .table-row {
            padding: 2px 0;
            border-bottom: 1px dotted #ccc;
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1fr 1fr;
            gap: 2px;
            font-size: 8px;
        }
        .table-row:last-child {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .separator {
            text-align: center;
            margin: 3px 0;
            padding: 1px;
            font-size: 7px;
            letter-spacing: 2px;
        }
        .summary-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 8px;
        }
        .summary-label {
            font-weight: bold;
        }
        .total-section {
            margin-top: 6px;
            padding-top: 4px;
            border-top: 2px solid #000;
        }
        .grand-total {
            font-weight: bold;
            font-size: 10px;
            margin-top: 3px;
            padding-top: 3px;
            border-top: 2px double #000;
        }
        .footer {
            margin-top: 8px;
            padding-top: 4px;
            border-top: 1px dashed #000;
            text-align: center;
            font-size: 7px;
            color: #666;
        }
        .line-break {
            word-break: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="hotel-name">MIADJOE BEACH RESORT</div>
        <div class="hotel-info">Kpota, Aného | Tél: 92 06 21 21</div>
        <div class="ticket-info">TICKET DE VENTE #{{ $sale->id }}</div>
        <div>Date: {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y H:i') }}</div>
        <div>Caisse: Restaurant</div>
    </div>

    <div class="separator">----------------</div>

    {{-- Client --}}
    @if($sale->reservation)
    <div class="section">
        <div class="section-title">CLIENT</div>
        <div class="client-line">
            <span class="client-label">Nom:</span>
            <span>{{ $sale->reservation->client->nom }} {{ $sale->reservation->client->prenom }}</span>
        </div>
        @if($sale->reservation->client->telephone)
        <div class="client-line">
            <span class="client-label">Tél:</span>
            <span>{{ $sale->reservation->client->telephone }}</span>
        </div>
        @endif
        @if($sale->reservation->items->first()->room->numero)
        <div class="client-line">
            <span class="client-label">Chambre:</span>
            <span>{{ $sale->reservation->items->first()->room->numero }}</span>
        </div>
        @endif
    </div>
    @endif

    <div class="separator">----------------</div>

    {{-- Articles --}}
    <div class="section">
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse; margin: 4px 0;">
                <thead>
                    <tr style="font-weight: bold; border-bottom: 2px solid #000; background-color: #f5f5f5;">
                        <th style="text-align: left; padding: 4px; width: 35%;">ARTICLES</th>
                        <th style="text-align: center; padding: 4px; width: 10%;">UNIT</th>
                        <th style="text-align: center; padding: 4px; width: 10%;">QTÉ</th>
                        <th style="text-align: right; padding: 4px; width: 15%;">P.U</th>
                        <th style="text-align: right; padding: 4px; width: 15%;">Remise</th>
                        <th style="text-align: right; padding: 4px; width: 15%;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="text-align: left; padding: 4px; word-break: break-word;">{{ $item->menu->nom ?? 'N/A' }}</td>
                        <td style="text-align: center; padding: 4px;">{{ $item->unite ?? '-' }}</td>
                        <td style="text-align: center; padding: 4px;">{{ $item->quantite }}</td>
                        <td style="text-align: right; padding: 4px;">{{ number_format($item->prix_unitaire, 0, ',', ' ') }}</td>
                        <td style="text-align: right; padding: 4px;">
                            @if($item->est_offert)
                                Offert
                            @elseif($item->remise_type === 'pourcentage')
                                {{ $item->remise_valeur }}%
                            @elseif($item->remise_type === 'montant')
                                {{ number_format($item->remise_valeur, 0, ',', ' ') }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align: right; padding: 4px; font-weight: bold;">{{ number_format($item->total, 0, ',', ' ') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="separator">----------------</div>

    {{-- Résumé financier --}}
    <div class="section">
        <div class="section-title">RÉSUMÉ FINANCIER</div>
        
        {{-- Montant facturé --}}
        <div class="summary-line">
            <span>Montant facturé:</span>
            <span>{{ number_format($sale->invoice->montant_total ?? $total, 0, ',', ' ') }} FCFA</span>
        </div>

        {{-- Remises --}}
        @if($sale->invoice && ($sale->invoice->is_remise || $sale->invoice->montant_final < $sale->invoice->montant_total))
        <div class="summary-line">
            <span>Remise:</span>
            <span>
                @if($sale->invoice->remise_amount)
                    {{ number_format($sale->invoice->remise_amount, 0, ',', ' ') }} FCFA
                @elseif($sale->invoice->remise_percent)
                    {{ $sale->invoice->remise_percent }}%
                @else
                    {{ number_format($sale->invoice->montant_total - $sale->invoice->montant_final, 0, ',', ' ') }} FCFA
                @endif
            </span>
        </div>
        @endif

        {{-- Total à payer --}}
        <div class="summary-line">
            <span>Total à payer:</span>
            <span>{{ number_format($sale->invoice->montant_final ?? $total, 0, ',', ' ') }} FCFA</span>
        </div>

        {{-- Payé --}}
        <div class="summary-line">
            <span>Payé:</span>
            <span>{{ number_format($sale->payments->sum('montant') ?? 0, 0, ',', ' ') }} FCFA</span>
        </div>

        {{-- Restant --}}
        <div class="summary-line">
            <span>Reste à payer:</span>
            <span>{{ number_format(max(0, ($sale->invoice->montant_final ?? $total) - $sale->payments->sum('montant')), 0, ',', ' ') }} FCFA</span>
        </div>

        <div class="separator">----------------</div>

        {{-- Total général --}}
        <div class="summary-line grand-total">
            <span>TOTAL:</span>
            <span>{{ number_format($sale->invoice->montant_final ?? $total, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <div class="separator">* * * * * * * * *</div>

    {{-- Motif(s) remise(s) --}}
    @if($sale->payments)
        @foreach($sale->payments as $payment)
            @if($payment->motif_remise)
            <div class="section">
                <div class="summary-line">
                    <span>Motif remise:</span>
                    <span class="line-break">{{ substr($payment->motif_remise, 0, 25) }}</span>
                </div>
            </div>
            @endif
        @endforeach
    @endif

    <div class="footer">
        <div>Merci de votre visite !</div>
        <div>Réf: {{ $sale->id }}/{{ date('Ymd') }}</div>
        <div>Imprimé: {{ now()->format('d/m/Y H:i') }}</div>
        <div>Conservez ce ticket</div>
    </div>
</body>
</html>