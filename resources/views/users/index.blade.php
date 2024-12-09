<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<nav class="bg-blue-600 border-b border-blue-700 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex-shrink-0">
                <h1 class="multicolor-text text-4xl font-bold">BigGame</h1>
            </div>
            <div class="hidden sm:block">
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Dashboard</a>

                    @if(auth()->user()->role === 'admin') <!-- Vérification du rôle -->
                        <a href="{{ route('admin.index') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Questions</a>
                    @endif

                    @if(auth()->user()->role === 'admin') <!-- Vérification du rôle -->
                        <a href="{{ route('users.index') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Utilisateurs</a>
                        @endif
                        
                        @if(auth()->user()->role === 'admin') <!-- Vérification du rôle -->
                        <a href="{{ route('users.index') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Créer un utilisateur</a>
                        @endif

                    <a href="{{ route('admin.results') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Résultats</a>
                    <a href="{{ route('profile.profil') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Profil</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:bg-red-500 px-3 py-2 rounded-md text-xl bg-green-600 font-medium">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
    <div class="container mx-auto my-8 p-4 bg-white rounded shadow">
        
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Liste des utilisateurs</h1>
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">Identifiant</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $user->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                        <td class="border border-gray-300 px-4 py-2">
    <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
        Modifier
    </a>
    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="button" 
        onclick="showDeletionWarning(this)" 
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
    @if (session('success'))
    <div 
        id="notification" 
        class="bg-green-500 text-white px-6 py-4 mb-4 rounded shadow-lg fixed top-4 right-4 animate-fade-in"
    >
        {{ session('success') }}
    </div>
@endif
<script>
    // Disparition automatique de la notification après 5 secondes
    setTimeout(() => {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.transition = 'opacity 0.5s ease';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500); // Supprime après l'animation
        }
    }, 5000);
    
    function showDeletionWarning(button) {
        // Création de la notification d'avertissement
        const warningNotification = document.createElement('div');
        warningNotification.innerHTML = `
            <p class="font-bold">Attention :</p>
            <p class="mt-1">Cette action est irréversible !</p>
            <div class="mt-2 flex justify-end">
                <button onclick="confirmDeletion(this)" class="bg-red-500 text-white px-4 py-2 rounded shadow-lg mr-2">Confirmer</button>
                <button onclick="cancelDeletion(this)" class="bg-gray-300 text-gray-700 px-4 py-2 rounded shadow-lg">Annuler</button>
            </div>
        `;
        warningNotification.className = 'bg-yellow-500 text-black px-6 py-4 rounded shadow-lg fixed top-4 right-4 z-50';

        // Ajout de la notification au DOM
        document.body.appendChild(warningNotification);

        // Supprime la notification automatiquement après 5 secondes si aucune action n'est prise
        setTimeout(() => {
            if (document.body.contains(warningNotification)) {
                warningNotification.style.transition = 'opacity 0.5s ease';
                warningNotification.style.opacity = '0';
                setTimeout(() => warningNotification.remove(), 500); // Supprime l'élément après la transition
            }
        }, 5000); // 5 secondes avant de disparaître
    }

    function confirmDeletion(button) {
        // Trouve le formulaire et le soumet
        const notification = button.closest('div');
        const form = notification.dataset.targetForm || button.closest('form');
        if (form) form.submit();

        // Supprime la notification immédiatement
        notification.remove();
    }

    function cancelDeletion(button) {
        // Supprime uniquement la notification
        button.closest('div').remove();
    }


</script>
<style>
    /* Animation de fade-in pour une meilleure transition */
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
</body>
</html>
