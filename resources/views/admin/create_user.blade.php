@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6">Créer un Nouvel Utilisateur</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nom:</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Mot de passe:</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirmer le mot de passe:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <!-- Champ pour sélectionner le rôle -->
        <div class="mb-4">
            <label for="role" class="block text-gray-700">Rôle:</label>
            <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="user">Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Créer Utilisateur</button>
    </form>
</div>
@endsection

