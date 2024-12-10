@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-white text-center">Gestion des Utilisateurs</h1>

    <div class="flex justify-center space-x-4 mb-4">
        <a href="{{ route('users.create') }}" class="bg-orange-500 text-white py-2 px-4 rounded-md flex items-center space-x-2">
            
            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 12H18M12 6V18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            Créer un Utilisateur</a>
        
        <a href="{{ route('users.export') }}" class="bg-green-500  text-white py-2 px-4 rounded-md flex items-center space-x-2">
            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.71,7.71,11,5.41V15a1,1,0,0,0,2,0V5.41l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-4-4a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-4,4A1,1,0,1,0,8.71,7.71ZM21,14a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V15a1,1,0,0,0-2,0v4a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V15A1,1,0,0,0,21,14Z"/>
            </svg>
            <span>Exporter des Utilisateurs</span>
        </a>

        <a href="{{ route('users.import.view') }}" class="bg-blue-500  text-white py-2 px-4 rounded-md flex items-center space-x-2">
            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M21,14a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V15a1,1,0,0,0-2,0v4a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V15A1,1,0,0,0,21,14Zm-9.71,1.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V3a1,1,0,0,0-2,0v9.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z"/>
            </svg>
            <span>Importer des Utilisateurs</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">ID</th>
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Nom</th>
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Email</th>
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Rôle</th>
                    <th class="py-3 px-6 border-b border-gray-300 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
              
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->id }}</td>
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->name }}</td>
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->email }}</td>
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $user->role }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;" class="delete-form">
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

<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Empêche la soumission du formulaire
            const userName = this.closest('tr').querySelector('td:nth-child(2)').innerText; // Récupère le nom de l'utilisateur
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `Vous allez supprimer l'utilisateur ${userName}. Cette action est irréversible.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Soumet le formulaire si l'utilisateur confirme
                }
            });
        });
    });
</script>
@endsection