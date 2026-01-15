<!DOCTYPE html>
<html>
<head>
    <title>Historique Global des Demandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Historique Global des Demandes</h1>
    <p>Date d'export : {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Type</th>
                <th>Période</th>
                <th>Motif</th>
                <th>Statut</th>
                <th>Commentaire</th>
                <th>Date Demande</th>
                <th>Date Validation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandes as $demande)
            <tr>
                <td>{{ $demande->user->nom }}</td>
                <td>{{ $demande->user->prenom }}</td>
                <td>{{ ucfirst($demande->type) }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }}<br>
                    au {{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}
                </td>
                <td>{{ Str::limit($demande->motif, 30) }}</td>
                <td>
                    @if($demande->statut === 'en_attente')
                        En attente
                    @elseif($demande->statut === 'approuve')
                        Approuvé
                    @elseif($demande->statut === 'rejete')
                        Rejeté
                    @endif
                </td>
                <td>{{ $demande->commentaire_admin ?? '-' }}</td>
                <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($demande->statut !== 'en_attente')
                        {{ $demande->updated_at->format('d/m/Y H:i') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
