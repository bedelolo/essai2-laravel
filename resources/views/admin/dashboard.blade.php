<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('admin.history') }}" class="bg-white border-l-4 border-blue-500 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-150">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h5 class="text-gray-500 font-medium text-sm uppercase tracking-wider">Total Demandes</h5>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalDemandes }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.history', ['statut' => 'approuve']) }}" class="bg-white border-l-4 border-green-500 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-150">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h5 class="text-gray-500 font-medium text-sm uppercase tracking-wider">Approuvées</h5>
                            <p class="text-3xl font-bold text-gray-800">{{ $demandesApprouvees }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.history', ['statut' => 'rejete']) }}" class="bg-white border-l-4 border-red-500 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-150">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h5 class="text-gray-500 font-medium text-sm uppercase tracking-wider">Rejetées</h5>
                            <p class="text-3xl font-bold text-gray-800">{{ $demandesRejetees }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-red-100 text-red-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </a>
                <div class="bg-white border-l-4 border-indigo-500 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h5 class="text-gray-500 font-medium text-sm uppercase tracking-wider">Utilisateurs</h5>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Demandes en attente de validation</h3>
                    
                    @if($demandesEnAttente->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Utilisateur</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Période</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Motif</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($demandesEnAttente as $demande)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $demande->user->nom_complet }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($demande->type) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ Str::limit($demande->motif, 30) }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <a href="{{ route('admin.pending') }}" class="text-blue-600 hover:text-blue-900 font-bold">
                                                Traiter
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">Aucune demande en attente.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>