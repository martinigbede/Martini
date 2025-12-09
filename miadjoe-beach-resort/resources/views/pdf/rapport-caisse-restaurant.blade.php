<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Caisse Restaurant</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1, h2, h3 {
            margin: 5px 0;
            padding: 0;
        }
        .section {
            margin-top: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table th, table td {
            border: 1px solid #444;
            padding: 4px;
            font-size: 11px;
        }
        table th {
            background: #bbb;
        }
        .summary-table td {
            border: none;
            padding: 3px 0;
        }
        .total-row {
            background: #ddd;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>Rapport Caisse - Restaurant</h1>
    <p>Généré le : {{ $generated_at }}</p>

    @if($filterDateType == 'jour')
        <p>Période : Aujourd’hui</p>
    @elseif($filterDateType == 'mois')
        <p>Période : Mois {{ $filterMonth }}/{{ $filterYear }}</p>
    @elseif($filterDateType == 'annee')
        <p>Période : Année {{ $filterYear }}</p>
    @elseif($filterDateType == 'semaine')
        <p>Période : Semaine {{ $filterWeek }} / {{ $filterYear }}</p>
    @elseif($filterDateType == 'perso')
        <p>Période : du {{ $filterStartDate }} au {{ $filterEndDate }}</p>
    @endif

    <!-- ====================== -->
    <!-- SECTION : SYNTHÈSE     -->
    <!-- ====================== -->
    <div class="section">
        <h2>Synthèse Globale</h2>

        <table class="summary-table">
            <tr><td>Total Espèces / MoMo :</td><td>{{ number_format($kpiEspMomo, 0, ',', ' ') }} F</td></tr>
            <tr><td>Total Carte / TPE :</td><td>{{ number_format($kpiTPE, 0, ',', ' ') }} F</td></tr>
            <tr><td>Total Virement :</td><td>{{ number_format($kpiVirement, 0, ',', ' ') }} F</td></tr>
            <tr><td>Total Paiements :</td><td>{{ number_format($totalPayments, 0, ',', ' ') }} F</td></tr>
            <tr><td>Total Dépenses :</td><td>{{ number_format($totalExpenses, 0, ',', ' ') }} F</td></tr>
            <tr><td><strong>Solde Net :</strong></td><td><strong>{{ number_format($soldeNet, 0, ',', ' ') }} F</strong></td></tr>
        </table>
    </div>

    <!-- ====================== -->
    <!-- SECTION : VENTES       -->
    <!-- ====================== -->
    <div class="section">
        <h2>Détail des Ventes</h2>

        <table>
            <thead>
                <tr>
                    <th>ID Vente</th>
                    <th>Date</th>
                    <th>Origine</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->date }}</td>
                    <td>
                        @if($sale->reservation_id)
                            Réservation #{{ $sale->reservation_id }}
                        @else
                            Vente directe
                        @endif
                    </td>
                    <td>{{ number_format($sale->total, 0, ',', ' ') }} F</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- ============================= -->
    <!-- SECTION : ITEMS VENDUS        -->
    <!-- ============================= -->
    <div class="section">
        <h2>Détail des Articles Vendus</h2>

        <table>
            <thead>
                <tr>
                    <th>Vente</th>
                    <th>Article</th>
                    <th>Qté</th>
                    <th>PU</th>
                    <th>Total</th>
                    <th>Remise</th>
                    <th>Offert</th>
                </tr>
            </thead>
            <tbody>
            @foreach($saleItems as $item)
                <tr>
                    <td>#{{ $item->sale_id }}</td>
                    <td>{{ $item->menu->nom ?? '—' }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F</td>
                    <td>{{ number_format($item->total, 0, ',', ' ') }} F</td>
                    <td>
                        @if($item->remise_type)
                            {{ $item->remise_valeur }} 
                            {{ $item->remise_type == 'pourcentage' ? '%' : 'F' }}
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $item->est_offert ? 'Oui' : 'Non' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- ============================= -->
    <!-- SECTION : PAIEMENTS           -->
    <!-- ============================= -->
    <div class="section">
        <h2>Détail des Paiements</h2>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Vente / Réservation</th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($p->montant, 0, ',', ' ') }} F</td>
                    <td>{{ $p->mode_paiement }}</td>
                    <td>
                        @if($p->sale_id)
                            Vente #{{ $p->sale_id }}
                        @elseif($p->reservation_id)
                            Réservation #{{ $p->reservation_id }}
                        @else
                            Service #{{ $p->divers_service_vente_id }}
                        @endif
                    </td>
                    <td>{{ $p->user->name ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- ============================= -->
    <!-- SECTION : DIVERS SERVICES      -->
    <!-- ============================= -->
    @if(isset($diversServices) && $diversServices->count() > 0)
    <div class="section">
        <h2>Détail des Ventes Divers Service</h2>

        <table>
            <thead>
                <tr>
                    <th>ID Vente</th>
                    <th>Client</th>
                    <th>Utilisateur</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
            @foreach($diversServices as $ds)
                <tr>
                    <td>#{{ $ds->id }}</td>
                    <td>{{ $ds->client_nom }}</td>
                    <td>{{ $ds->user->name ?? '—' }}</td>
                    <td>{{ number_format($ds->total, 0, ',', ' ') }} F</td>
                    <td>{{ ucfirst($ds->statut) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- ============================= -->
    <!-- SECTION : ITEMS DIVERS SERVICE -->
    <!-- ============================= -->
    <div class="section">
        <h2>Détail des Articles Divers Service</h2>

        <table>
            <thead>
                <tr>
                    <th>Vente</th>
                    <th>Service</th>
                    <th>Qté</th>
                    <th>Durée</th>
                    <th>PU</th>
                    <th>Sous-total</th>
                    <th>Mode facturation</th>
                </tr>
            </thead>
            <tbody>
            @foreach($diversServiceItems as $item)
                <tr>
                    <td>#{{ $item->divers_service_vente_id }}</td>
                    <td>{{ $item->service->nom ?? '—' }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ $item->duree ?? '—' }}</td>
                    <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F</td>
                    <td>{{ number_format($item->sous_total, 0, ',', ' ') }} F</td>
                    <td>{{ $item->mode_facturation ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- ============================= -->
    <!-- SECTION : PAIEMENTS DIVERS SERVICE -->
    <!-- ============================= -->
    <div class="section">
        <h2>Paiements Divers Service</h2>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Vente</th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
            @foreach($diversServicePayments as $p)
                <tr>
                    <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($p->montant, 0, ',', ' ') }} F</td>
                    <td>{{ $p->mode_paiement }}</td>
                    <td>#{{ $p->divers_service_vente_id }}</td>
                    <td>{{ $p->user->name ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="1">TOTAL PAIEMENTS DIVERS</td>
                    <td colspan="4">{{ number_format($totalDiversPayments ?? 0, 0, ',', ' ') }} F</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    <!-- ================================== -->
    <!-- SECTION : ENCAISSEMENTS + HV       -->
    <!-- ================================== -->
    <div class="section">
        <h2>Encaissements & Hors Vente</h2>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Type</th>
                    <th>Référence</th>
                    <th>Encaisseur</th>
                    <th>Mode</th>
                </tr>
            </thead>
            <tbody>
            @foreach($encaissements as $e)
                <tr>
                    <td>{{ $e['date'] }}</td>
                    <td>{{ number_format($e['montant'], 0, ',', ' ') }} F</td>
                    <td>{{ ucfirst($e['type']) }}</td>
                    <td>{{ $e['reference'] }}</td>
                    <td>{{ $e['encaisseur'] ?? '—' }}</td>
                    <td>{{ $e['mode'] ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- ============================= -->
    <!-- SECTION : DÉPENSES            -->
    <!-- ============================= -->
    <div class="section">
        <h2>Liste des Dépenses</h2>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Motif</th>
                    <th>Montant</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
            @foreach($expenses as $exp)
                <tr>
                    <td>{{ $exp->date_depense }}</td>
                    <td>{{ $exp->motif }}</td>
                    <td>{{ number_format($exp->montant, 0, ',', ' ') }} F</td>
                    <td>{{ $exp->user->name ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="2">TOTAL DÉPENSES</td>
                    <td colspan="2">{{ number_format($totalExpenses, 0, ',', ' ') }} F</td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
