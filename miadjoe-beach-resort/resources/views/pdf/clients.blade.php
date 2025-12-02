<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des clients</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #ddd; }
    </style>
</head>
<body>
    <h2>Liste des clients</h2>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Réservations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->prenom }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->telephone }}</td>
                    <td>{{ $client->reservations_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
