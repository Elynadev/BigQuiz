@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Créer une Question</h1>

    <form action="{{ route('admin.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Question</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="question_text" required>
        </div>

        <div id="answers">
            <div class="mb-4">
                <label for="answer_text" class="block text-gray-700 text-sm font-bold mb-2">Réponse 1</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="answers[0][text]" required>
                <div class="mt-2">
                    <input type="checkbox" name="answers[0][is_correct]" class="mr-2 leading-tight"> 
                    <span class="text-sm text-gray-600">Correcte</span>
                </div>
            </div>
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
                <label for="answer_text" class="block text-gray-700 text-sm font-bold mb-2">Réponse ${index + 1}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="answers[${index}][text]" required>
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