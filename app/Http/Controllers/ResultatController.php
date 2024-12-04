
<?php

namespace App\Http\Controllers;

use App\Models\Question;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Rediriger ou retourner une réponse
        return redirect()->back()->with('success', 'Score enregistré avec succès !');
    }
}