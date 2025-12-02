<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Comptable</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; }
        h2 { background-color: #4a90e2; color: #fff; padding: 5px 10px; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
        .section-title { background-color: #e2e8f0; font-weight: bold; padding: 5px; }
        .right { text-align: right; }
        .subtotal { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>

    <h1>Rapport Comptable</h1>
    <p>Période : {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</p>

    <!-- 1. Résumé Général -->
    <h2>Résumé Général</h2>
    <table>
        <tr><th>Élément</th><th>Montant</th></tr>
        <tr><td>Total Paiements</td><td class="right">{{ number_format($totaux['paiements'], 0, ',', ' ') }} FCFA</td></tr>
        <tr><td>Total Factures</td><td class="right">{{ number_format($totaux['factures'], 0, ',', ' ') }} FCFA</td></tr>
        <tr><td>Total Réservations</td><td class="right">{{ $totaux['reservations'] }}</td></tr>
        <tr><td>Total Ventes</td><td class="right">{{ $totaux['ventes'] }}</td></tr>
        <tr><td>Total Divers</td><td class="right">{{ $totaux['divers'] }}</td></tr>
        <tr><td>Total Dépenses</td><td class="right">{{ number_format($totaux['depenses'], 0, ',', ' ') }} FCFA</td></tr>
        <tr><td>Total En Attente</td><td class="right">{{ number_format($totaux['en_attente'], 0, ',', ' ') }} FCFA</td></tr>
    </table>

    <h2>Revenu Mensuel Global</h2>
    <table>
        <tr>
            <th>Type de Revenu</th>
            <th>Montant</th>
        </tr>
        @foreach($revenusParType as $type => $montant)
        <tr>
            <td>{{ $type }}</td>
            <td class="right">{{ number_format($montant, 0, ',', ' ') }} FCFA</td>
        </tr>
        @endforeach
    </table>
    <!-- 2. Caisses détaillées -->
    <h2>Caisses par Type</h2>
    @foreach($caisses as $type => $group)
        <div class="section-title">Type de caisse: {{ $type }}</div>
        <table>
            <tr>
                <th>Nom Compte</th>
                <th>Solde</th>
            </tr>
            @foreach($group as $c)
                <tr>
                    <td>{{ $c->nom_compte }}</td>
                    <td class="right">{{ number_format($c->solde, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
            <tr class="subtotal">
                <td>Total {{ $type }}</td>
                <td class="right">{{ number_format($group->sum('solde'), 0, ',', ' ') }} FCFA</td>
            </tr>
            @php
                // Calcul de la liquidité réelle : Espèces + Mobile Money
                $liquidite = $group->whereIn('nom_compte', ['Espèces', 'Mobile Money'])->sum('solde');
            @endphp
            <tr class="subtotal">
                <td>Liquidité réelle (Espèces + Mobile Money)</td>
                <td class="right">{{ number_format($liquidite, 0, ',', ' ') }} FCFA</td>
            </tr>
        </table>
    @endforeach

    <!-- 3. Revenus Mensuels -->
    <h2>Revenus Mensuels</h2>
    <table>
        <tr><th>Mois</th><th>Montant</th></tr>
        @foreach($revenusMensuels as $r)
            <tr>
                <td>{{ $r['mois'] }}</td>
                <td class="right">{{ number_format($r['total'], 0, ',', ' ') }} FCFA</td>
            </tr>
        @endforeach
    </table>

    <!-- 4. Paiements détaillés -->
    <h2>Paiements Détail</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Montant</th>
            <th>Mode</th>
            <th>Réservation</th>
            <th>Vente</th>
            <th>Divers</th>
            <th>Date</th>
        </tr>
        @foreach($paiements as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td class="right">{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
            <td>{{ $p->mode_paiement }}</td>
            <td>{{ $p->reservation_id ?? '-' }}</td>
            <td>{{ $p->sale_id ?? '-' }}</td>
            <td>{{ $p->divers_service_vente_id ?? '-' }}</td>
            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </table>

    <!-- 5. Décaissements / Encaissements -->
    <h2>Décaissements / Encaissements</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Montant</th>
            <th>Motif</th>
            <th>Caisse</th>
            <th>Encaisse</th>
            <th>Date</th>
        </tr>
        @foreach($decaissements as $d)
        <tr>
            <td>{{ $d->id }}</td>
            <td class="right">{{ number_format($d->montant, 0, ',', ' ') }} FCFA</td>
            <td>{{ $d->motif }}</td>
            <td>{{ $d->cashAccount?->nom_compte ?? '-' }}</td>
            <td>{{ $d->est_encaisse ? 'Oui' : 'Non' }}</td>
            <td>{{ $d->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </table>

    <!-- 6. Dépenses détaillées -->
    <h2>Dépenses Détail</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Montant</th>
            <th>Catégorie</th>
            <th>Mode de Paiement</th>
            <th>Date</th>
            <th>Statut</th>
        </tr>
        @foreach($depenses as $depense)
        <tr>
            <td>{{ $depense->id }}</td>
            <td class="right">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
            <td>{{ $depense->categorie }}</td>
            <td>{{ $depense->mode_paiement }}</td>
            <td>{{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}</td>
            <td>{!! $depense->statut_badge !!}</td>
        </tr>
        @endforeach
    </table>

    <!-- 7. Entrées Hors Vente -->
    <h2>Entrées Hors Vente</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Montant</th>
            <th>Mode de Paiement</th>
            <th>Motif</th>
            <th>Utilisateur</th>
            <th>Date</th>
        </tr>

        @foreach($horsVentes as $hv)
        <tr>
            <td>{{ $hv->id }}</td>
            <td class="right">{{ number_format($hv->montant, 0, ',', ' ') }} FCFA</td>
            <td>{{ $hv->mode_paiement }}</td>
            <td>{{ $hv->motif ?? '-' }}</td>
            <td>{{ $hv->user?->name ?? '-' }}</td>
            <td>{{ $hv->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach

        <tr class="subtotal">
            <td colspan="6" class="right">
                Total Hors Vente :
                <strong>{{ number_format($horsVentes->sum('montant'), 0, ',', ' ') }} FCFA</strong>
            </td>
        </tr>
    </table>

    <!-- 8. Légende & Explications -->
    <h2>Légende & Explications des calculs</h2>
    <ul>
        <li><strong>Revenu Global :</strong> Somme de tous les paiements payés.</li>
        <li><strong>Revenu Hébergement :</strong> Somme des paiements liés à des réservations.</li>
        <li><strong>Revenu Restaurant :</strong> Somme des paiements liés aux ventes.</li>
        <li><strong>Revenu Divers :</strong> Somme des paiements liés aux services divers.</li>
        <li><strong>Total Caisse Restaurant :</strong> (Solde Espèces + Solde Mobile Money) – Dépenses.</li>
        <li><strong>Total Caisse Hébergement :</strong> Somme des paiements Hébergement.</li>
    </ul>
    <p style="text-align:right; margin-top:20px;">Rapport généré le : {{ now()->format('d/m/Y H:i') }}</p>

</body>
</html>
