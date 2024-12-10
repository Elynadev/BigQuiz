<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuizResultMail;

class ResultController extends Controller
{
    public function store(Request $request)
    {
        // Valider la requête
        $request->validate([
            'score' => 'required|integer|min:0',
            'email' => 'required|email',
        ]);

        // Récupérer le score depuis la requête
        $score = $request->input('score');

        // Enregistrer le score dans la base de données
        Result::create([
            'user_id' => Auth::id(), // Assurez-vous que l'utilisateur est authentifié
            'score' => $score,
        ]);

        // Envoyer l'email avec les résultats
        Mail::to($request->email)->send(new QuizResultMail($score));

        // Rediriger ou retourner une réponse
        return redirect()->back()->with('success', 'Score enregistré avec succès !');
    }
}