<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

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

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    Excel::import(new UsersImport, $request->file('file'));

     // Redirection vers la liste des utilisateurs
     return redirect()->route('users.index')->with('success', 'Utilisateurs importés avec succès.');
}
}
