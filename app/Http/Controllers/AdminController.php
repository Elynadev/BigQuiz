<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;

class AdminController extends Controller {
    public function index() {
        $questions = Question::with('answers')->get();
        return view('admin.index', compact('questions'));
    }

    public function create() {
        return view('admin.create');
    }

    public function store(Request $request) {
        $question = Question::create($request->only('question_text', 'is_active'));
        foreach ($request->answers as $answer) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answer['text'],
                'is_correct' => $answer['is_correct'] ?? false,
            ]);
        }
        return redirect()->route('admin.index')->with('success', 'Question créée avec succès.');
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

    public function results() {
        // Récupérer tous les résultats ou selon ta logique
        $results = Result::with('user')->get(); // Assure-toi que tu as une relation 'user' définie dans le modèle Result
        return view('admin.results', compact('results'));
    }
}
