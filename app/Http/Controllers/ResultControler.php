<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;

use Illuminate\Support\Facades\Auth;

class ResultControler extends Controller
{
    //

    public function store(Request $request)
    {
        // Récupérer le score depuis la requête
        $score = $request->input('score');

        // Valider le score
        $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        // Enregistrer le score dans la base de données
        Result::create([
            'user_id' => Auth::id(), // Assurez-vous que l'utilisateur est authentifié
            'score' => $score,
        ]);

        // Rediriger ou retourner une réponse
        return redirect()->back()->with('success', 'Score enregistré avec succès !');
    }

}
