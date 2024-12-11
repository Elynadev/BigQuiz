<?php

namespace App\Http\Controllers;

use App\Mail\QuizResultEmail;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class ResultControler extends Controller
{
    //
    // public function index()
    // {
    //     // Récupérer tous les résultats
    //     $results = Result::with('user')->orderBy('created_at', 'desc')->get();

    //     // Récupérer le nombre total de questions
    //     $totalQuestions = Question::count(); // Compte le nombre total de questions

    //     // Passer les résultats et le nombre total de questions à la vue
    //     return view('results.index', compact('results', 'totalQuestions'));
    // }public function store(Request $request)
    public function store(Request $request)
    {
        // Récupérer le score depuis la requête
        $score = $request->input('score');
    
        // Valider le score
        $request->validate([
            'score' => 'required|integer|min:0',
            'recipient_email' => 'required|email', // Validation pour l'email
            'text' => 'required|string', // Validation pour le texte soumis
        ]);
    
        // Enregistrer le score dans la base de données
        $result = Result::create([
            'user_id' => Auth::id(), // Assurez-vous que l'utilisateur est authentifié
            'score' => $score,
        ]);
    
        // Récupérer les questions pour l'utilisateur
        $questions = Question::where('is_active', true)->get();
    
        // Récupérer l'email du destinataire et le texte soumis
        $recipientEmail = $request->input('recipient_email');
        $submittedText = $request->input('text');
    
        // Envoyer l'email
        \Mail::to($recipientEmail)->send(new QuizResultEmail($result, $questions, $submittedText));
    
        // Rediriger ou retourner une réponse
        return redirect()->back()->with('success', 'Score enregistré avec succès !');
    }

//     public function showResults()public function showAnswer()
// public function showResults()
// {
//     $results = Result::with('user')->get(); // Exemple de récupération des résultats
//     return view('quiz.result', compact('results')); // Assurez-vous que le chemin est correct
// }

}
