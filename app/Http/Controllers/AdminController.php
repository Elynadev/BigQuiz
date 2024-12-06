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
            ->where('is_active', true)
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
            
            $foramted_data = [];

            array_push($foramted_data, ["response" => $request->answer_text, "is_correct" => true]);

            if ($request->answers) {
                
                foreach ($request->answers as $false_answer) {

                  // Ignorer les réponses vides
                  if (empty($false_answer['text'])) {
                    continue;
}

                    array_push($foramted_data, [
                        "response" => $false_answer['text'] ?? 'Aucune réponse fournie',
                        "is_correct" => isset($false_answer['is_correct']) && $false_answer['is_correct'] == "on" ? true : false
                    ]);
            // dd($foramted_data); // Vérifie que les réponses sont bien formatées

                }
            }

            // Validation des données
            $validate = $request->validate([
                'questions.*.question_text' => 'required|string|max:255',
                'questions.*.image' => 'nullable|image|max:2048',
            ]);

            // Stockage de l'image
            $file = $request->image->store('public/images');
            $url = Storage::url($file);

            // Création de la question avec les réponses formatées
            $newQuestion = Question::create([
                "question_text" => $request->question_text,
                "image" => $url,
                "reponses" => json_encode($foramted_data)
            ]);

            return redirect()->route('admin.index')->with('success', 'Questions créées avec succès.');
        } catch (\Exception $e) {
            dd($e);
            Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
            return redirect()->back()->withErrors('Une erreur est survenue : ' . $e->getMessage());
        }
    }


    public function edit(Question $question)
    {
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
}