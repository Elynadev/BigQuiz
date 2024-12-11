<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    $users = User::all(); 
    return view('admin.create_user', compact('users')); // Assurez-vous de créer cette vue
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

    logger('Fichier reçu : ' . $request->file('file')->getClientOriginalName());

    $errors = [];

    try {
        Excel::import(new UsersImport, $request->file('file'));
    } catch (ValidationException $e) {
        foreach ($e->failures() as $failure) {
            $message = "Erreur à la ligne {$failure->row()}: " . implode(", ", $failure->errors());
            $errors[] = $message;
        }
    } catch (\Exception $e) {
        logger('Erreur lors de l\'importation : ' . $e->getMessage());
        return redirect()->route('users.index')->withErrors(['Erreur d\'importation : ' . $e->getMessage()]);
    }

    if (!empty($errors)) {
        return redirect()->route('users.index')->withErrors($errors);
    }

    return redirect()->route('users.index')->with('success', 'Utilisateurs importés avec succès.');
}

public function edit($id)
{
    // Trouver l'utilisateur par son ID
    $user = User::findOrFail($id);

public function submitText(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'role' => 'required|string|in:user,admin',  // Ajouter la validation pour le rôle
    ]);

    $user = auth()->user(); // Récupération de l'utilisateur connecté
    $submittedText = $request->input('text');
    $recipientEmail = $request->input('recipient_email'); // Récupération de l'email du destinataire

    // Mettre à jour les informations de l'utilisateur, y compris le rôle
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,  // Ajouter la mise à jour du rôle
    ]);

    // Envoi de l'email
    Mail::send('emails.user_notification', [
        'user' => $user,
        'submittedText' => $submittedText,
    ], function ($message) use ($recipientEmail, $user) {
        $message->to($recipientEmail)
                ->subject('Nouveau commentaire de ' . $user->name);
    });

    return back()->with('success', 'Commentaire soumis avec succès.');
}

}
