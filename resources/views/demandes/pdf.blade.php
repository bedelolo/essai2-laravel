<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Historique des Demandes</title>
    <style>
        @page {
            margin: 20px;
            size: A4 portrait;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        h1 {
            font-size: 18px;
            color: #333;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        
        .user-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        
        .user-info p {
            margin: 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }
        
        th {
            background-color: #4a5568;
            color: white;
            font-weight: bold;
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .statut {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .statut-en_attente {
            background-color: #fbbf24;
            color: #78350f;
        }
        
        .statut-approuve {
            background-color: #10b981;
            color: white;
        }
        
        .statut-rejete {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Historique de mes demandes</h1>
    </div>
    
    <div class="user-info">
        <p><strong>Nom complet :</strong> {{ Auth::user()->nom_complet }}</p>
        <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
        <p><strong>Date de génération :</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p><strong>Nombre total de demandes :</strong> {{ $demandes->count() }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="15%">Type</th>
                <th width="25%">Période</th>
                <th width="25%">Motif</th>
                <th width="15%">Statut</th>
                <th width="20%">Date de demande</th>
            </tr>
        </thead>
        <tbody>
            @forelse($demandes as $demande)
            <tr>
                <td><strong>{{ ucfirst($demande->type) }}</strong></td>
                <td>
                    Du {{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }}<br>
                    au {{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}
                </td>
                <td>{{ $demande->motif }}</td>
                <td>
                    @if($demande->statut === 'en_attente')
                        <span class="statut statut-en_attente">En attente</span>
                    @elseif($demande->statut === 'approuve')
                        <span class="statut statut-approuve">Approuvé</span>
                    @elseif($demande->statut === 'rejete')
                        <span class="statut statut-rejete">Rejeté</span>
                    @endif
                </td>
                <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    Aucune demande trouvée.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Document généré automatiquement par le système de gestion des demandes</p>
        <p>Page 1/1 - {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>