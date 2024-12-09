@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-white text-center">Gestion des Utilisateurs</h1>

    <a href="{{ route('users.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-md mb-4 inline-block">Créer un Utilisateur</a>
    <a href="{{ route('users.export') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md mb-4 inline-block">Exporter en Excel</a> <!-- Lien d'exportation -->
    
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">ID</th> <!-- Nouvelle colonne pour l'ID -->
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Nom</th>
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Email</th>
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Rôle</th>
                    <th class="py-3 px-6 border-b border-gray-300 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->id }}</td> <!-- Affichage de l'ID -->
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->name }}</td>
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->email }}</td>
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->role }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 transition duration-150 ease-in-out">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($users->isEmpty())
                    <tr>
                        <td class="py-3 px-6 text-center" colspan="5">Aucun utilisateur enregistré.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection