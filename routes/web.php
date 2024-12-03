<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes protégées par l'authentification
Route::middleware('auth')->group(function () {
    // Route pour le profil de l'utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour la gestion des questions
    Route::prefix('admin')->group(function () {
        Route::get('/questions', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/questions/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/questions/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/questions/edit/{question}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/questions/update/{question}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/questions/{question}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('/questions/{question}', [AdminController::class, 'show'])->name('admin.show'); // Afficher les détails d'une question
    });

    // Routes pour le quiz utilisateur
    Route::get('/quiz/{id}', [QuizController::class, 'showQuiz'])->name('quiz.show');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submitQuiz'])->name('quiz.submit');

    // Routes pour l'index des quiz
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');

    // Routes pour les résultats
    Route::get('/admin/results', [AdminController::class, 'results'])->name('admin.results'); // Liste des résultats
    // Ajoute d'autres routes pour le traitement des résultats si nécessaire
    Route::get('/photo', [PhotoController::class, 'create']);
    Route::post('/photo', [PhotoController::class, 'store']);
});

// Authentification
require __DIR__.'/auth.php';