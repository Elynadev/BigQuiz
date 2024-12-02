@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Détails de la Question</h1>

    <h3 class="text-xl font-semibold mb-2">{{ $question->question_text }}</h3>
    <p class="text-gray-700 mb-4">Statut : <span class="{{ $question->is_active ? 'text-green-600' : 'text-red-600' }}">{{ $question->is_active ? 'Actif' : 'Inactif' }}</span></p>

    <h4 class="text-lg font-semibold mb-2">Réponses :</h4>
    <ul class="list-disc list-inside mb-4">
        @foreach($question->answers as $answer)
            <li class="mb-1">
                {{ $answer->answer_text }} - <span class="{{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">{{ $answer->is_correct ? 'Correcte' : 'Incorrecte' }}</span>
            </li>
        @endforeach
    </ul>

    <div class="flex space-x-4">
        <a href="{{ route('admin.edit', $question) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Modifier</a>
        <form action="{{ route('admin.destroy', $question) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">Supprimer</button>
        </form>
    </div>
</div>
@endsection