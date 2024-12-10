<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Validators\ValidationException;

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
        return back()->with('success', 'Utilisateur supprimé avec succès.');
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
            'role' => 'required|string|in:user,admin', // Validation du rôle, doit être 'user' ou 'admin'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

    return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,csv,xls',
    ]);

    $errors = [];

    try {
        Excel::import(new UsersImport, $request->file('file'));
    } catch (ValidationException $e) {
        $errors = $e->failures();
        foreach ($errors as $failure) {
            $message = "Erreur à la ligne {$failure->row()}: " . implode(", ", $failure->errors());
            $errors[] = $message;
        }
    }

    if (!empty($errors)) {
        return redirect()->route('users.index')->withErrors($errors);
    }

    return redirect()->route('users.index')->with('success', 'Utilisateurs importés avec succès.');
}
// Dans le contrôleur UserController
public function edit($id)
{
    // Trouver l'utilisateur par son ID
    $user = User::findOrFail($id);

    // Retourner la vue avec l'utilisateur
    return view('users.edit', compact('user'));
}

public function update(Request $request, $id)
{
    // Valider les données envoyées dans le formulaire
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'role' => 'required|string|in:user,admin',  // Ajouter la validation pour le rôle
    ]);

    // Trouver l'utilisateur par son ID
    $user = User::findOrFail($id);

    // Mettre à jour les informations de l'utilisateur, y compris le rôle
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,  // Ajouter la mise à jour du rôle
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
}

}
