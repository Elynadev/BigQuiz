<?php
namespace App\Http\Controllers;

use App\Models\Result;
use App\Mail\QuizResultMail; // N'oubliez pas d'importer le Mailable
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ResultatController extends Controller
{

    
    public function store(Request $request)
    {
        // Récupérer le score depuis la requête
        $score = $request->input('score');

        // Valider le score (optionnel)
        $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        // Enregistrer le score dans la base de données
        Result::create([
            'user_id' => Auth::id(), // Assurez-vous que l'utilisateur est authentifié
            'score' => $score,
        ]);

        // Envoyer le résultat par email
        $totalQuestions = // Récupérer le nombre total de questions (vous devez définir comment le récupérer)
        Mail::to(Auth::user()->email)->send(new QuizResultMail($score, $totalQuestions));

        // Rediriger ou retourner une réponse
        return redirect()->back()->with('success', 'Score enregistré avec succès et résultats envoyés par email !');
    }
}