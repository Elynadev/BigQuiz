<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultControler;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RoleController;
use App\Exports\UsersExport; // Ajout de l'export
use Maatwebsite\Excel\Facades\Excel; // Ajout de la facade Excel
use App\Mail\MyTestEmail;

use Illuminate\Support\Facades\Mail;

Route::get('/testroute', function() {
    $name = "Funny Coder";
    // The email sending is done using the to method on the Mail facade
    Mail::to('testreceiver@gmail.com')->send(new MyTestEmail($name));
});



Route::middleware(['auth'])->group(function () {
    Route::post('/roles/create', [RoleController::class, 'createRoles']);
    Route::post('/permissions/create', [RoleController::class, 'createPermissions']);
    Route::post('/users/{userId}/assign-role', [RoleController::class, 'assignRoleToUser']);
    Route::post('/roles/{roleId}/assign-permission', [RoleController::class, 'assignPermissionToRole']);
});

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
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.profil')->middleware('auth');    
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/export', [ProfileController::class, 'exportResults'])->name('profile.export');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // Route pour le formulaire
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Route pour enregistrer l'utilisateur
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    

    // Route pour exporter les utilisateurs
    Route::get('/users/export', function () {
        return Excel::download(new UsersExport, 'utilisateurs.xlsx');
    })->name('users.export'); // Route d'exportation
    
      // Route pour afficher le formulaire d'importation
      Route::get('/users/import', function () {
        return view('admin.import-users'); // Vue pour le formulaire d'importation
    })->name('users.import.view');

    //Route pour importer les utilisateurs 
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');

    // Routes pour la gestion des questions
    Route::prefix('admin')->group(function () {
        Route::get('/questions', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/questions/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/questions/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/questions/edit/{question}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/questions/update/{question}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/questions/{question}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::patch('admin/questions/{question}/toggle', [AdminController::class, 'toggle'])->name('admin.toggle');
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

Route::get('/answer', [AnswerController::class, 'index']);
Route::post('/results', [ResultControler::class, 'store'])->name('results.store');