@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Liste des Questions Actives</h1>
    <a href="{{ route('admin.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Ajouter une Question</a>

    @if(session('success'))
        <div class="bg-green-200 border border-green-600 text-green-600 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($questions->isEmpty())
        <div class="bg-yellow-200 border border-yellow-600 text-yellow-600 p-3 rounded mb-4">
            Aucune question active trouvée.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($questions as $question)
                <div class="bg-white border border-gray-300 rounded-lg p-4 shadow-md">
                    <h2 class="text-lg font-bold mb-2">Question : {{ $question->question_text }}</h2>
                    @if($question->image)
                        <img src="{{ asset( $question->image) }}" alt="Image de la question" class="w-full h-32 object-cover rounded mb-2">
                    @endif
                    <p class="text-gray-700 mb-2">{{ $question->is_active ? 'Actif' : 'Inactif' }}</p>

                    <div class="mb-4">
                        <h3 class="text-md font-semibold mb-2">Réponses :</h3>
                       
                        {{-- <p>{{ json_decode($question->reponses)[0]->response  }}</p> --}}
                        @php
    // Décoder le JSON en tableau PHP
    $answers = json_decode($question->reponses, true);
@endphp

<ul class="list-disc pl-5">
    @forelse($answers as $answer)
        @if(!empty($answer['response'])) <!-- Vérification que la réponse n'est pas vide -->
            <li class="text-gray-600">
                {{ $answer['response'] }}
                @if($answer['is_correct'])
                    <span class="text-green-500 font-bold">(Correcte)</span>
                @endif
            </li>
        @endif
    @empty
        <li class="text-gray-600">Aucune réponse disponible.</li>
    @endforelse
</ul>

                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('admin.edit', $question) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Modifier</a>
                        <form action="{{ route('admin.destroy', $question) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" type="submit">Supprimer</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Liens de pagination -->
        <div class="mt-4">
            {{ $questions->links('vendor.pagination.tailwind') }} <!-- Utilise le style Tailwind pour les liens de pagination -->
        </div>
    @endif
</div>
@endsection