<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Demandes en attente de validation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($demandes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($demandes as $demande)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-yellow-50 p-4 border-b border-yellow-100">
                            <h5 class="font-bold text-lg flex justify-between items-center">
                                <span>Demande de {{ ucfirst($demande->type) }}</span>
                                <span class="text-sm text-gray-500 font-normal">
                                    {{ $demande->created_at->diffForHumans() }}
                                </span>
                            </h5>
                        </div>
                        <div class="p-6 text-gray-900">
                            <div class="mb-4 space-y-2">
                                <p><span class="font-semibold">Utilisateur:</span> {{ $demande->user->nom_complet }}</p>
                                <p><span class="font-semibold">Période:</span> {{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}</p>
                                <p><span class="font-semibold">Durée:</span> {{ \Carbon\Carbon::parse($demande->date_debut)->diffInDays(\Carbon\Carbon::parse($demande->date_fin)) + 1 }} jour(s)</p>
                                <div>
                                    <span class="font-semibold">Motif:</span>
                                    <p class="mt-1 p-2 bg-gray-50 rounded text-gray-700">{{ $demande->motif }}</p>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <form method="POST" class="mt-4">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-4">
                                    <label for="commentaire_{{ $demande->id }}" class="block text-sm font-medium text-gray-700">
                                        Commentaire (obligatoire pour le rejet, optionnel pour l'approbation) :
                                    </label>
                                    <textarea 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" 
                                        id="commentaire_{{ $demande->id }}" 
                                        name="commentaire" 
                                        rows="3"
                                        placeholder="Saisissez un commentaire..."></textarea>
                                </div>

                                <div class="flex gap-4">
                                    <button 
                                        type="submit" 
                                        formaction="{{ route('admin.approve', $demande) }}"
                                        onclick="document.getElementById('commentaire_{{ $demande->id }}').required = false;"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-bold text-sm text-white hover:bg-green-900 focus:bg-green-900 active:bg-green-950 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Approuver
                                    </button>
                                    
                                    <button 
                                        type="submit" 
                                        formaction="{{ route('admin.reject', $demande) }}"
                                        onclick="document.getElementById('commentaire_{{ $demande->id }}').required = true;"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-bold text-sm text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Rejeter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <h4 class="font-bold">Aucune demande en attente de validation.</h4>
                    <p>Toutes les demandes ont été traitées.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>