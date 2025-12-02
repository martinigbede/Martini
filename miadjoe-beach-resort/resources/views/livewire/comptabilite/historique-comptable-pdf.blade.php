<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique Comptable</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
        h2 { margin-top: 30px; font-size: 16px; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Historique des Factures et  paiements</h1>
    <p>Période : {{ $dateDebut ?? 'N/A' }} - {{ $dateFin ?? 'N/A' }}</p>

    {{-- FACTURES --}}
    @if($invoices->count() > 0)
        <h2>Factures</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Montant Total</th>
                    <th>Montant Payé</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $totalInvoices = 0; @endphp
                @foreach($invoices as $invoice)
                    @php $totalInvoices += $invoice->montant_final ?? $invoice->montant_total ?? 0; @endphp
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->reservation->client->nom ?? '-' }}</td>
                        <td class="px-5 py-3 text-sm text-gray-800">
                            @if($invoice->reservation_id) Réservation # {{ $invoice->reservation_id }}
                            @elseif($invoice->sale_id) Vente #{{ $invoice->sale_id }}
                            @elseif($invoice->divers_service_vente_id) Service #{{ $invoice->divers_service_vente_id }}
                            @endif
                        </td>
                        <td>{{ number_format($invoice->montant_final ?? 0, 0, ',', ' ') }}</td>
                        <td>{{ number_format($invoice->montant_paye ?? 0, 0, ',', ' ') }}</td>
                        <td>{{ $invoice->statut }}</td>
                        <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="total">Total Factures : {{ number_format($totalInvoices, 0, ',', ' ') }}</p>
    @endif

    {{-- PAIEMENTS --}}
    @if($payments->count() > 0)
        <h2>Paiements</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Mode de paiement</th>
                    <th>Utilisateur</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPayments = 0; @endphp
                @foreach($payments as $payment)
                    @php $totalPayments += $payment->montant ?? 0; @endphp
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->reservation->client->nom ?? '-' }}</td>
                        <td>
                            @if($payment->reservation_id) Réservation # {{ $payment->reservation_id }}
                            @elseif($payment->sale_id) Vente #{{ $payment->sale_id }}
                            @elseif($payment->divers_service_vente_id) Service #{{ $payment->divers_service_vente_id }}
                            @endif
                        </td>
                        <td>{{ number_format($payment->montant ?? 0, 0, ',', ' ') }}</td>
                        <td>{{ $payment->mode_paiement }}</td>
                        <td>{{ $payment->user->name ?? '-' }}</td>
                        <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="total">Total Paiements : {{ number_format($totalPayments, 0, ',', ' ') }}</p>
    @endif

    {{-- RESERVATIONS --}}
    @if($reservations->count() > 0)
        <h2>Réservations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Statut</th>
                    <th>Date création</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $res)
                    <tr>
                        <td>{{ $res->id }}</td>
                        <td>{{ $res->client->nom ?? '-' }}</td>
                        <td>{{ $res->statut }}</td>
                        <td>{{ $res->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="total">
            Total Réservations :
            <strong>{{ number_format($reservations->sum(fn($r) => $r->invoice->montant_final ?? 0), 0, ',', ' ') }}</strong>
        </p>
    @endif

    {{-- VENTES RESTAURANT --}}
    @if($sales->count() > 0)
        <h2>Ventes Restaurant</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $totalSales = 0; @endphp
                @foreach($sales as $sale)
                    @php $totalSales += $sale->total ?? 0; @endphp
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->reservation->client->nom ?? '-' }}</td>
                        <td>{{ number_format($sale->invoice->montant_final ?? 0, 0, ',', ' ') }}</td>
                        <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="total">Total Ventes : {{ number_format($sale->invoice->montant_final, 0, ',', ' ') }}</p>
    @endif

    {{-- SERVICES DIVERS --}}
    @if($diversServices->count() > 0)
        <h2>Ventes Services Divers</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Utilisateur</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $totalServices = 0; @endphp
                @foreach($diversServices as $vente)
                    @foreach($vente->items as $item)
                        @php
                            $totalServices += $vente->invoice->montant_final ?? 0;
                        @endphp

                        <tr>
                            <td>{{ $vente->id }}</td>
                            <td>{{ $item->service->nom ?? 'N/A' }}</td>
                            <td>{{ $vente->user->name ?? '-' }}</td>
                            <td>{{ number_format($vente->invoice->montant_final ?? 0, 0, ',', ' ') }}</td>
                            <td>{{ $vente->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <p class="total">Total Services : {{ number_format($totalServices, 0, ',', ' ') }}</p>
    @endif

    {{-- DEPENSES --}}
    @if($expenses->count() > 0)
        <h2>Dépenses</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Utilisateur</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php $totalExpenses = 0; @endphp
                @foreach($expenses as $expense)
                    @php $totalExpenses += $expense->montant ?? 0; @endphp
                    <tr>
                        <td>{{ $expense->id }}</td>
                        <td>{{ $expense->categorie }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ $expense->user->name ?? '-' }}</td>
                        <td>{{ number_format($expense->montant ?? 0, 0, ',', ' ') }}</td>
                        <td>{{ $expense->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="total">Total Dépenses : {{ number_format($totalExpenses, 0, ',', ' ') }}</p>
    @endif

</body>
</html>
