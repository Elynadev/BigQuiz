<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto my-8 p-4 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Modifier l'utilisateur</h1>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nom :</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                    class="w-full border border-gray-300 rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email :</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                    class="w-full border border-gray-300 rounded px-4 py-2">
            </div>

            <!-- Champ pour sélectionner le rôle -->
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Rôle :</label>
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
</select>

            </div>

            <div class="flex justify-between">
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Sauvegarder
                </button>
            </div>
        </form>
    </div>
</body>
</html>
