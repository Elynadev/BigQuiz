<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
      // Afficher la liste des questions
      public function index()
      {
          $questions = Question::with('answers')->get();
          return view('admin.index', compact('questions'));
      }
  
      // Afficher le formulaire pour créer une nouvelle question
      public function create()
      {
          return view('admin.create');
      }
  
      // Stocker une nouvelle question
     public function store(Request $request)
{
    $request->validate([
        'question_text' => 'required|string|max:255',
        'answers.*.text' => 'required|string|max:255',
        'answers.*.is_correct' => 'boolean'
    ]);

    // Créer la question
    $question = Question::create([
        'question_text' => $request->input('question_text'),
        'is_active' => true, // ou gère cela selon tes besoins
    ]);

    // Ajouter les réponses
    foreach ($request->input('answers') as $answer) {
        $question->answers()->create([
            'answer_text' => $answer['text'],
            'is_correct' => isset($answer['is_correct']) ? 1 : 0, // Convertir 'on' en 1 et rien en 0
        ]);
    }

    return redirect()->route('questions.index')->with('success', 'Question créée avec succès.');
}
  
      // Afficher les détails d'une question
      public function show(Question $question)
      {
          return view('admin.show', compact('question'));
      }
  
      // Afficher le formulaire pour éditer une question
      public function edit(Question $question)
      {
          return view('admin.edit', compact('question'));
      }
  
      // Mettre à jour une question
      public function update(Request $request, Question $question)
      {
          $request->validate([
              'question_text' => 'required|string|max:255',
              'answers.*.text' => 'required|string|max:255',
              'answers.*.is_correct' => 'boolean'
          ]);
  
          $question->update([
              'question_text' => $request->input('question_text'),
          ]);
  
          // Mettre à jour les réponses
          foreach ($request->input('answers') as $answer) {
              $existingAnswer = $question->answers()->find($answer['id']);
              if ($existingAnswer) {
                  $existingAnswer->update([
                      'answer_text' => $answer['text'],
                      'is_correct' => isset($answer['is_correct']),
                  ]);
              }
          }
  
          return redirect()->route('admin.index')->with('success', 'Question mise à jour avec succès.');
      }
  
      // Supprimer une question
      public function destroy(Question $question)
      {
          $question->delete();
          return redirect()->route('admin.index')->with('success', 'Question supprimée avec succès.');
      }


      public function showQuiz($id)
{
    $question = Question::with('answers')->findOrFail($id);
    return view('quiz.show', compact('question'));
}

public function submitQuiz(Request $request, $id)
{
    $request->validate([
        'answers' => 'required|array',
    ]);

    $question = Question::findOrFail($id);
    $correctAnswersCount = 0;

    // Vérifier les réponses
    foreach ($request->input('answers') as $answerId) {
        $answer = $question->answers()->find($answerId);
        if ($answer && $answer->is_correct) {
            $correctAnswersCount++;
        }
    }

    return redirect()->route('quiz.results', ['score' => $correctAnswersCount]);
}
}
