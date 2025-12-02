<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Dashboard</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        h1, h2 {
            color: #4B5563; /* gris foncé */
            margin: 0;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background-color: #F3F4F6;
            padding: 10px;
            font-weight: bold;
            border-left: 4px solid #3B82F6;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        table th {
            background-color: #F9FAFB;
            font-weight: bold;
        }

        .highlight {
            font-weight: bold;
            color: #1F2937;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #6B7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rapport Dashboard</h1>
        <p>Période : <span class="highlight">{{ $startDate }}</span> au <span class="highlight">{{ $endDate }}</span></p>

        {{-- Revenus --}}
        <div class="section">
            <div class="section-title">Revenus</div>
            <table>
                <tr>
                    <th>Type</th>
                    <th>Montant (FCFA)</th>
                </tr>
                <tr>
                    <td>Hôtel</td>
                    <td>{{ number_format($hotel, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td>Restaurant</td>
                    <td>{{ number_format($restaurant, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td>Divers services</td>
                    <td>{{ number_format($divers, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <th>Total global</th>
                    <th>{{ number_format($global, 0, ',', ' ') }}</th>
                </tr>
            </table>
        </div>

        {{-- Paiements --}}
        <div class="section">
            <div class="section-title">Paiements</div>
            <table>
                <tr>
                    <th>Type</th>
                    <th>Montant (FCFA)</th>
                </tr>
                <tr>
                    <td>Payé</td>
                    <td>{{ number_format($payments, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td>Restant dû</td>
                    <td>{{ number_format($due, 0, ',', ' ') }}</td>
                </tr>
            </table>
        </div>

        {{-- Occupation --}}
        <div class="section">
            <div class="section-title">Occupation des chambres</div>
            <table>
                <tr>
                    <th>Chambres occupées</th>
                    <th>Taux d’occupation</th>
                </tr>
                <tr>
                    <td>{{ $occupiedRooms }} / {{ $totalRooms }}</td>
                    <td>{{ $occupationRate }}%</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            Généré le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
