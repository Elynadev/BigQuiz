<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        // Récupérer uniquement les questions actives avec pagination
        $questions = Question::with('answers')
            ->paginate(10); // Remplace 10 par le nombre d'éléments que tu souhaites par page

        return view('admin.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        try {
            $formatted_data = [];
    
            // Ajout de la réponse correcte si elle existe
            if ($request->answers) {
                foreach ($request->answers as $answer) {
                    if (empty($answer['text'])) {
                        continue; // Ignorer les réponses vides
                    }
                    array_push($formatted_data, [
                        "response" => $answer['text'],
                        "is_correct" => isset($answer['is_correct']) ? true : false
                    ]);
                }
            }
    
            // Validation des données
            $validate = $request->validate([
                'question_text' => 'required|string|max:255',
                'image' => 'nullable|image|max:2048',
            ]);
    
            // Stockage de l'image
            $url = null;
            if ($request->hasFile('image')) {
                $file = $request->image->store('public/images');
                $url = Storage::url($file);
            }
    
            // Création de la question avec les réponses formatées
            $newQuestion = Question::create([
                "question_text" => $request->question_text,
                "image" => $url,
                "reponses" => json_encode($formatted_data),
                "is_active" => $request->has('is_active') // Active ou désactive la question
            ]);
    
            return redirect()->route('admin.index')->with('success', 'Question créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
            return redirect()->back()->withErrors('Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function edit(Question $question) {
        return view('admin.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $question->update($request->only('question_text', 'is_active'));

        // Mettre à jour les réponses
        foreach ($request->answers as $answer) {
            $existingAnswer = Answer::find($answer['id']);
            if ($existingAnswer) {
                $existingAnswer->update([
                    'answer_text' => $answer['text'],
                    'is_correct' => $answer['is_correct'] ?? false,
                ]);
            } else {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answer['text'],
                    'is_correct' => $answer['is_correct'] ?? false,
                ]);
            }
        }
        return redirect()->route('admin.index')->with('success', 'Question mise à jour avec succès.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.index')->with('success', 'Question supprimée avec succès.');
    }

    public function results(Request $request)
    {
        // Supposons que tu as un modèle Result qui stocke les résultats des quiz
        $results = Result::with('user')->get(); // Récupérer tous les résultats avec les utilisateurs associés

        return view('admin.results', compact('results')); // Passer les résultats à la vue
    }

    public function toggle(Question $question)
{
    $question->is_active = !$question->is_active; // Inverse l'état d'activation
    $question->save();

    return redirect()->route('admin.index')->with('success', 'Statut de la question mis à jour avec succès.');
}
}