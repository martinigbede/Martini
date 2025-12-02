<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des paiements - Ventes</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table th {
            background: #f0f0f0;
            padding: 6px;
            border: 1px solid #ccc;
            font-size: 11px;
            text-align: left;
        }

        table td {
            padding: 6px;
            border: 1px solid #ccc;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: 10px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Historique des paiements - Ventes</h2>
        <div class="small">
            Période sélectionnée :
            @if($filterDateType === 'perso')
                Du {{ \Carbon\Carbon::parse($filterStartDate)->format('d/m/Y') }}
                au {{ \Carbon\Carbon::parse($filterEndDate)->format('d/m/Y') }}
            @else
                {{ ucfirst($filterDateType) }} :
                @if($filterDateType === 'mois')
                    {{ date("F", mktime(0,0,0,$filterMonth,1)) }} {{ $filterYear }}
                @elseif($filterDateType === 'semaine')
                    Semaine {{ $filterWeek }} - {{ $filterYear }}
                @elseif($filterDateType === 'annee')
                    {{ $filterYear }}
                @endif
            @endif
        </div>
    </div>

    <!-- Section KPI -->
    <div class="section-title">Statistiques Globales</div>

    <table>
        <tr>
            <th>Total des paiement</th>
            <td class="text-right">{{ number_format($caisseBrute, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <th>Caisse réel (Espèces + Mobile Money)</th>
            <td class="text-right">{{ number_format($kpiEspMomo, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <th>Paiements TPE</th>
            <td class="text-right">{{ number_format($kpiTPE, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <th>Virements Bancaires</th>
            <td class="text-right">{{ number_format($kpiVirement, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    <!-- Section Paiements -->
    <div class="section-title">Historique complet des paiements</div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <th>Référence</th>
                <th>Mode</th>
                <th class="text-right">Montant</th>
                <th class="text-right">Remise</th>
                <th>Utilisateur</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>

                    <td>
                        @if($payment->reservation?->client)
                            {{ $payment->reservation->client->nom }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($payment->reservation_id)
                            Réservation #{{ $payment->reservation_id }}
                        @elseif($payment->divers_service_vente_id)
                            Service Divers #{{ $payment->divers_service_vente_id }}
                        @elseif($payment->sale_id)
                            Vente #{{ $payment->sale_id }}
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $payment->mode_paiement }}</td>

                    <td class="text-right">
                        {{ number_format($payment->montant, 0, ',', ' ') }} FCFA
                    </td>

                    <td class="text-right">
                        {{ number_format($payment->remise_amount, 0, ',', ' ') }} FCFA
                    </td>

                    <td>{{ $payment->user?->name ?? 'Système' }}</td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Aucun paiement enregistré pour cette période.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ========================================================= --}}
    {{-- TABLEAU DES ENCAISSEMENTS RÉCEPTION (DÉCAISSEMENTS ENCAISSÉS) --}}
    {{-- ========================================================= --}}

    <h3 style="margin-top:40px; font-size:18px; font-weight:bold;">
        Encaissements Restaurant
    </h3>

    @if($encaissements->count() > 0)
    <table width="100%" cellspacing="0" cellpadding="6" style="margin-top:10px; border-collapse: collapse; font-size:12px;">
        <thead>
            <tr style="background:#f2f2f2; border-bottom:1px solid #ccc;">
                <th style="border:1px solid #ccc; text-align:left;">Date encaissement</th>
                <th style="border:1px solid #ccc; text-align:left;">Réservation</th>
                <th style="border:1px solid #ccc; text-align:left;">Montant</th>
                <th style="border:1px solid #ccc; text-align:left;">Encaisseur</th>
                <th style="border:1px solid #ccc; text-align:left;">Compte caisse</th>
            </tr>
        </thead>

        <tbody>
            @foreach($encaissements as $e)
            <tr>
                {{-- DATE --}}
                <td style="border:1px solid #ccc;">
                    {{ $e->encaisse_at ? \Carbon\Carbon::parse($e->encaisse_at)->format('d/m/Y H:i') : '--' }}
                </td>

                {{-- RÉSERVATION --}}
                <td style="border:1px solid #ccc;">
                    @if($e->reservation)
                        Réservation #{{ $e->reservation_id }}
                        @if($e->reservation->client_name)
                            ({{ $e->reservation->client_name }})
                        @endif
                    @else
                        --
                    @endif
                </td>

                {{-- MONTANT --}}
                <td style="border:1px solid #ccc;">
                    {{ number_format($e->montant, 0, ',', ' ') }} FCFA
                </td>

                {{-- UTILISATEUR QUI A ENCAISSÉ --}}
                <td style="border:1px solid #ccc;">
                    {{ $e->encaisseur?->name ?? '--' }}
                </td>

                {{-- COMPTE CAISSE --}}
                <td style="border:1px solid #ccc;">
                    {{ $e->cashAccount?->nom_compte ?? '--' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @else
    <p style="margin-top:10px; font-size:13px;">Aucun encaissement trouvé pour la période sélectionnée.</p>
    @endif

    <div class="footer">
        <em>Note : Ce document a été généré automatiquement par le système de gestion Miadjoe Beach Resort, le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} </em>
    </div>

</body>
</html>
