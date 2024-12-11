<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Result;
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
public function submitText(Request $request)
{
    // Validation des données
    $request->validate([
        'text' => 'required|string',
        'recipient_email' => 'required|string|email',
    ]);

    $user = auth()->user(); // Récupération de l'utilisateur connecté
    $submittedText = $request->input('text');
    $recipientEmail = $request->input('recipient_email'); // Récupération de l'email du destinataire

    // Récupération des questions actives
    $questions = Question::where('is_active', true)->get(); // Récupérer les questions

    // Préparer les bonnes réponses
    $questionsWithCorrectAnswers = $questions->map(function ($question) {
        $answers = json_decode($question->reponses, true);
        $correctAnswer = collect($answers)->firstWhere('is_correct', true);
        return [
            'question_text' => $question->question_text,
            'correct_answer' => $correctAnswer ? $correctAnswer['response'] : 'Aucune réponse correcte',
        ];
    });

    // Envoi de l'email
    try {
         dd($questions);
        Mail::send('emails.user_notification', [
            'user' => $user,
            'submittedText' => $submittedText,
            'questions' => $questionsWithCorrectAnswers,
        ], function ($message) use ($recipientEmail, $user) {
            $message->to($recipientEmail)
                    ->subject('Nouveau commentaire de ' . $user->name);
        });



        return back()->with('success', 'Commentaire soumis avec succès.');
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
    }
}

public function edit($id)
{
    // Récupère l'utilisateur à partir de l'ID
    $user = User::findOrFail($id);

    // Retourne la vue d'édition avec les données de l'utilisateur
    return view('users.edit', compact('user'));
}
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Valider les données
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,user',
    ]);

    // Mettre à jour les informations de l'utilisateur
    $user->update($request->all());

    // Rediriger avec un message de succès
    return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
}

}
