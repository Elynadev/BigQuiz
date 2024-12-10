<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuizResultsMail;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;

class ResultControler extends Controller
{
    public function store(Request $request)
    {
        // Valider les données d'entrée
        $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour enregistrer votre score.');
        }

        // Récupérer le score et l'utilisateur authentifié
        $score = $request->input('score');
        $userId = Auth::id();

        // Enregistrer le score dans la base de données
        Result::create([
            'user_id' => $userId,
            'score' => $score,
        ]);

        // Envoyer un e-mail de confirmation
        Mail::to(Auth::user()->email)->send(new QuizResultsMail($score));

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Score enregistré avec succès et e-mail envoyé !');
    }
}
