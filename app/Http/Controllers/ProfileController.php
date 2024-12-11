<?php

namespace App\Http\Controllers;

use App\Exports\ResultsExport;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Result;
use Maatwebsite\Excel\Facades\Excel;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function show()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Récupérer les résultats associés à l'utilisateur
        $results = Result::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    
        // Calculer le meilleur score
        $bestScore = $results->max('score'); // Meilleur score
    
        // Récupérer le nombre total de questions actives
        $totalQuestions = Question::where('is_active', true)->count(); // Compte uniquement les questions actives
    
        // Passer l'utilisateur, les résultats, le meilleur score et le nombre total de questions à la vue
        return view('profile.profil', compact('user', 'results', 'bestScore', 'totalQuestions'));
    }
    public function exportResults()
{
    $user = Auth::user();
    return Excel::download(new ResultsExport($user), 'resultats_' . $user->id . '.xlsx');
}
}
