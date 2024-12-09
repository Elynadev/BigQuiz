@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-white text-center">Gestion des Utilisateurs</h1>

    <a href="{{ route('users.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-md mb-4 inline-block">Créer un Utilisateur</a>
    <a href="{{ route('users.export') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md mb-4 inline-block">Exporter en Excel</a>

    @if(session('success'))
        <div 
            id="notification" 
            class="bg-green-500 text-white px-6 py-4 mb-4 rounded shadow-lg fixed top-4 right-4 animate-fade-in"
        >
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
                            <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                Modifier
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" id="deleteForm-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                    onclick="showDeletionWarning({{ $user->id }})" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 ml-4 rounded shadow-lg transition duration-200">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Notification automatique de succès
    setTimeout(() => {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.transition = 'opacity 0.5s ease';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
        }
    }, 5000);

    // Gestion des avertissements de suppression
    function showDeletionWarning(userId) {
        const existingWarning = document.getElementById('deletion-warning');
        if (existingWarning) existingWarning.remove();

        // Création de la notification d'avertissement
        const warningNotification = document.createElement('div');
        warningNotification.id = 'deletion-warning';
        warningNotification.innerHTML = `
            <p class="font-bold">Attention :</p>
            <p class="mt-1">Cette action est irréversible !</p>
            <div class="mt-2 flex justify-end">
                <button onclick="confirmDeletion(${userId})" class="bg-red-500 text-white px-4 py-2 rounded shadow-lg mr-2">Confirmer</button>
                <button onclick="cancelDeletion()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded shadow-lg">Annuler</button>
            </div>
        `;
        warningNotification.className = 'bg-yellow-500 text-black px-6 py-4 rounded shadow-lg fixed top-4 right-4 z-50';

        // Ajout de la notification au DOM
        document.body.appendChild(warningNotification);

        // Supprime la notification automatiquement après 5 secondes
        setTimeout(() => {
            if (document.body.contains(warningNotification)) {
                warningNotification.style.transition = 'opacity 0.5s ease';
                warningNotification.style.opacity = '0';
                setTimeout(() => warningNotification.remove(), 500);
            }
        }, 5000);
    }

    function confirmDeletion(userId) {
        const form = document.getElementById(`deleteForm-${userId}`);
        if (form) form.submit();
    }

    function cancelDeletion() {
        const warningNotification = document.getElementById('deletion-warning');
        if (warningNotification) warningNotification.remove();
    }
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
</style>
@endsection
