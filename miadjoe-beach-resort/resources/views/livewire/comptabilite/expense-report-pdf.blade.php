<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Dépenses</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Rapport des Dépenses</h2>
    <p>Période : {{ $startDate ?? '...' }} à {{ $endDate ?? '...' }}</p>
    <p>Statut : {{ $statut ?? 'Tous' }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Catégorie</th>
                <th>Description</th>
                <th>Montant</th>
                <th>Mode paiement</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                    <td>{{ $expense->categorie }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ number_format($expense->montant, 0, ',', ' ') }}</td>
                    <td>{{ $expense->mode_paiement }}</td>
                    <td>{{ $expense->statut }}</td>
                    <td>{{ $expense->date_depense->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Dépenses : <strong>{{ number_format($totalExpenses, 0, ',', ' ') }}</strong></p>
</body>
</html>
