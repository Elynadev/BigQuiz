<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller {
    public function index()
{
    // Récupérer uniquement les questions actives avec pagination
    $questions = Question::with('answers')
        ->where('is_active', true)
        ->paginate(10); // Remplace 10 par le nombre d'éléments que tu souhaites par page

    return view('admin.index', compact('questions'));
}

    public function create() {
        return view('admin.create');
    }

    public function store(Request $request)
    {
    
        try {
            // Validation des données
            dd($request);
            $request->validate([
                'questions' => 'required|array',
                'questions.*.question_text' => 'required|string|max:255',
                'questions.*.image' => 'nullable|image|max:2048',
                'questions.*.answers' => 'required|array',
                'questions.*.answers.*.text' => 'required|string|max:255',
                'questions.*.answers.*.is_correct' => 'boolean',
            ]);
    
            // Boucle à travers les questions
            foreach ($request->input('questions') as $questionData) {
                // Préparation des données de la question
                $question = [
                    'question_text' => $questionData['question_text'],
                    'is_active' => true,
                ];
    
                // Gestion de l'image
                if (isset($questionData['image']) && $request->hasFile($questionData['image'])) {
                    $question['image'] = $questionData['image']->store('images', 'public');
                }
    
                // Enregistrement de la question
                $newQuestion = Question::create($question);
    
                // Enregistrement des réponses
                foreach ($questionData['answers'] as $answer) {
                    $newQuestion->answers()->create([
                        'text' => $answer['text'],
                        'is_correct' => isset($answer['is_correct']) ? $answer['is_correct'] : false,
                    ]);
                }
            }
    
            return redirect()->route('admin.index')->with('success', 'Questions créées avec succès.');
    
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
            return redirect()->back()->withErrors('Une erreur est survenue : ' . $e->getMessage());
        }
    }


    // public function store(Request $request) {
    //     // Validation des données
    //     $request->validate([
    //         'question_text' => 'required|string|max:255',
    //         'is_active' => 'boolean',
    //         'answers' => 'required|array',
    //         'answers.*.text' => 'required|string|max:255',
    //         'answers.*.is_correct' => 'sometimes|boolean', // Assurez-vous que c'est un booléen
    //     ]);
    
    //     // Création de la question
    //     $question = Question::create($request->only('question_text', 'is_active'));
    
    //     // Insertion des réponses
    //     foreach ($request->answers as $answer) {
    //         Answer::create([
    //             'question_id' => $question->id,
    //             'answer_text' => $answer['text'],
    //             'is_correct' => isset($answer['is_correct']) && $answer['is_correct'] === '1', // Convertir en booléen
    //         ]);
    //     }
    
    //     return redirect()->route('admin.index')->with('success', 'Question créée avec succès.');
    // }

    public function edit(Question $question) {
        return view('admin.edit', compact('question'));
    }

    public function update(Request $request, Question $question) {
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

    public function destroy(Question $question) {
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
