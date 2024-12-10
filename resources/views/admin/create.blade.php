@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Créer un Utilisateur</h1>

    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Question</label>
            <input type="text" id="question_text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="question_text" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
            <input type="file" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="image" accept="image/*">
        </div>

        <div id="answers">
            <div class="mb-4">
                <label for="answer_text_0" class="block text-gray-700 text-sm font-bold mb-2">Réponse 1</label>
                <input type="text" id="answer_text_0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="answers[0][text]" required>
                <div class="mt-2">
                    <input type="checkbox" name="answers[0][is_correct]" class="mr-2 leading-tight"> 
                    <span class="text-sm text-gray-600">Correcte</span>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Rôle</label>
            <div class="relative">
                <select id="role" name="role" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500" required>
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <input type="checkbox" id="is_active" name="is_active" class="mr-2 leading-tight" checked>
            <label for="is_active" class="text-sm text-gray-600">Activer la question</label>
        </div>

        <div class="flex items-center justify-between mb-4">
            <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded" id="add-answer">Ajouter une Réponse</button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer Question</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-answer').addEventListener('click', function() {
        const answersDiv = document.getElementById('answers');
        const index = answersDiv.children.length;
        const newAnswer = `
            <div class="mb-4">
                <label for="answer_text_${index}" class="block text-gray-700 text-sm font-bold mb-2">Réponse ${index + 1}</label>
                <input type="text" id="answer_text_${index}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="answers[${index}][text]" required>
                <div class="mt-2">
                    <input type="checkbox" name="answers[${index}][is_correct]" class="mr-2 leading-tight"> 
                    <span class="text-sm text-gray-600">Correcte</span>
                </div>
            </div>
        `;
        answersDiv.insertAdjacentHTML('beforeend', newAnswer);
    });
</script>
@endsection