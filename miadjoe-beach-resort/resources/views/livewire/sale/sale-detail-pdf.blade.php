<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $sale->id }}</title>
    <style>
        @page { margin: 0; size: 80mm auto; }
        body { 
            font-family: 'Courier New', monospace;
            font-size: 10px;
            margin: 0;
            padding: 5mm;
            width: 70mm;
        }
        * { 
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #000;
        }
        .header h1 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .subtitle {
            font-size: 8px;
            color: #666;
            margin-bottom: 5px;
        }
        .info {
            margin: 5px 0;
            padding: 3px 0;
            border-bottom: 1px dashed #ccc;
        }
        .info-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .info-label {
            font-weight: bold;
        }
        .table {
            width: 100%;
            margin: 5px 0;
            font-size: 9px;
        }
        .table-header {
            border-bottom: 1px solid #000;
            padding: 2px 0;
            font-weight: bold;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 2px;
        }
        .table-row {
            padding: 2px 0;
            border-bottom: 1px dotted #ccc;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 2px;
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
        .total-section {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 2px solid #000;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .grand-total {
            font-weight: bold;
            font-size: 11px;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 2px double #000;
        }
        .separator {
            text-align: center;
            margin: 5px 0;
            padding: 2px;
            font-size: 8px;
            letter-spacing: 3px;
        }
        .footer {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px dashed #000;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HÔTEL RESTAURANT</h1>
        <div class="subtitle">Facture/Ticket de caisse</div>
        <div>#{{ $sale->id }}</div>
    </div>

    <div class="info">
        <div class="info-line">
            <span class="info-label">Date:</span>
            <span>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y H:i') }}</span>
        </div>
        @if($sale->reservation)
        <div class="info-line">
            <span class="info-label">Client:</span>
            <span>{{ $sale->reservation->client->nom ?? 'N/A' }}</span>
        </div>
        <div class="info-line">
            <span class="info-label">Chambre:</span>
            <span>{{ $sale->reservation->room->numero ?? 'N/A' }}</span>
        </div>
        @endif
        <div class="info-line">
            <span class="info-label">Caisse:</span>
            <span>001</span>
        </div>
    </div>

    <div class="separator">----------------</div>

    <div class="table-header">
        <div>ARTICLE</div>
        <div class="text-center">UNITÉ</div>
        <div class="text-center">QTÉ</div>
        <div class="text-right">P.U</div>
        <div class="text-right">TOTAL</div>
    </div>

    @foreach($sale->items as $item)
    <div class="table-row">
        <div>{{ substr($item->menu->nom ?? 'N/A', 0, 15) }}</div>
        <div class="text-center">{{ substr($item->unite ?? '-', 0, 4) }}</div>
        <div class="text-center">{{ $item->quantite }}</div>
        <div class="text-right">{{ number_format($item->prix_unitaire, 2) }}</div>
        <div class="text-right">{{ number_format($item->total, 2) }}</div>
    </div>
    @endforeach

    <div class="separator">----------------</div>

    <div class="total-section">
        <div class="total-line">
            <span>Sous-total:</span>
            <span>{{ number_format($sale->total, 2) }} FCFA</span>
        </div>
        @if($payment_amount > 0)
        <div class="total-line">
            <span>Payé:</span>
            <span>{{ number_format($payment_amount, 2) }} FCFA</span>
        </div>
        <div class="total-line">
            <span>Reste:</span>
            <span>{{ number_format($reste, 2) }} FCFA</span>
        </div>
        @endif
        <div class="grand-total total-line">
            <span>TOTAL:</span>
            <span>{{ number_format($sale->total, 2) }} FCFA</span>
        </div>
    </div>

    <div class="separator">* * * * * * * * *</div>

    <div class="footer">
        <div>Merci de votre visite !</div>
        <div>Référence: {{ $sale->id }}/{{ date('Ymd') }}</div>
        <div>Imprimé le: {{ now()->format('d/m/Y H:i') }}</div>
        <div>Conservez ce ticket</div>
    </div>
</body>
</html>