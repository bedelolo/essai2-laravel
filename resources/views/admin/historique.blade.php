<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historique des demandes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-800">Liste des demandes traitées</h3>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.history') }}" class="px-3 py-1 rounded-md text-sm font-medium {{ !request('statut') ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Tous
                            </a>
                            <a href="{{ route('admin.history', ['statut' => 'approuve']) }}" class="px-3 py-1 rounded-md text-sm font-medium {{ request('statut') == 'approuve' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                Approuvés
                            </a>
                            <a href="{{ route('admin.history', ['statut' => 'rejete']) }}" class="px-3 py-1 rounded-md text-sm font-medium {{ request('statut') == 'rejete' ? 'bg-red-600 text-white' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                Rejetés
                            </a>
                        </div>

                        <a href="{{ route('admin.export') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                            <i class="fas fa-file-pdf"></i> Exporter en PDF
                        </a>
                    </div>
                    
                    @if($demandes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Utilisateur
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Période
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Motif
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Date Traitement
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($demandes as $demande)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div>
                                                    <p class="text-gray-900 whitespace-no-wrap font-semibold">
                                                        {{ $demande->user->nom }} {{ $demande->user->prenom }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="capitalize">{{ $demande->type }}</span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            Du {{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }}<br>
                                            au {{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ Str::limit($demande->motif, 50) }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($demande->statut === 'approuve')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Approuvé
                                                </span>
                                            @elseif($demande->statut === 'rejete')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Rejeté
                                                </span>
                                            @endif
                                            
                                            @if($demande->commentaire_admin)
                                                <p class="text-xs text-gray-600 mt-1 italic">"{{ $demande->commentaire_admin }}"</p>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $demande->updated_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                            <h4 class="font-bold">Aucune demande dans l'historique.</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>