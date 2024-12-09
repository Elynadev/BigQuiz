<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Récupérer tous les utilisateurs
        return view('admin.user', compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete(); // Supprimer l'utilisateur
        return redirect()->route('admin.user')->with('success', 'Utilisateur supprimé avec succès.');
    }


    public function create()
{
    return view('admin.create_user'); // Assurez-vous de créer cette vue
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed', // Assurez-vous d'avoir un champ de confirmation de mot de passe
        'role' => 'required|string|max:255', // Si vous avez un rôle
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
}
public function edit($id)
{
    // Trouver l'utilisateur par son ID
    $user = User::findOrFail($id);

    // Retourner la vue de l'édition avec l'utilisateur
    return view('admin.edit', compact('user'));
}
public function update(Request $request, $id)
{
    // Validation des données
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string',
    ]);

    // Trouver l'utilisateur
    $user = User::findOrFail($id);

    // Mettre à jour l'utilisateur
    $user->update($validated);

    // Rediriger avec un message de succès
    return redirect()->route('admin.index')->with('success', 'Utilisateur mis à jour avec succès.');
}

}
