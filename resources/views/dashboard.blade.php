<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(Auth::user()->role === 'admin')
                        <h3 class="text-lg font-bold mb-4">Espace Administrateur</h3>
                        <div class="space-y-4">
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-full text-center sm:w-auto">
                                Accéder au Dashboard Admin
                            </a>
                        </div>
                    @else
                        <h3 class="text-lg font-bold mb-4">Espace Employé</h3>
                        <div class="space-y-4">
                            <a href="{{ route('demandes.create') }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 mr-2">
                                Nouvelle Demande
                            </a>
                            <a href="{{ route('demandes.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Mes Demandes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
