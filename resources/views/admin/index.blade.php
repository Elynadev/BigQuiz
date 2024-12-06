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
                        <img src="{{ asset($question->image) }}" alt="Image de la question" class="w-full h-32 object-cover rounded mb-2">
                    @endif
                    <p class="text-orange-700 text-center bg-lime-300 text-xl mb-2 font-extrabold"> Question : {{ $question->is_active ? 'Actif' : 'Inactif' }}</p>

                    <div class="mb-4">
                        <h3 class="text-md font-semibold mb-2">Réponses :</h3>
                        @php
                            $answers = json_decode($question->reponses, true);
                        @endphp

                        <ul class="list-disc pl-5">
                            @forelse($answers as $answer)
                                @if(!empty($answer['response']))
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

                    <div class="flex justify-between mb-2">
                        <a href="{{ route('admin.edit', $question) }}" class="bg-yellow-300 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.destroy', $question) }}" method="POST" style="display:inline;" id="delete-form-{{ $question->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" type="button" onclick="confirmDelete('{{ $question->id }}')">
                                <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.755,20.283,4,8H20L18.245,20.283A2,2,0,0,1,16.265,22H7.735A2,2,0,0,1,5.755,20.283ZM21,4H16V3a1,1,0,0,0-1-1H9A1,1,0,0,0,8,3V4H3A1,1,0,0,0,3,6H21a1,1,0,0,0,0-2Z"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="flex justify-between">
                        <form action="{{ route('admin.toggle', $question) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" type="submit">
                                {{ $question->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Liens de pagination -->
        <div class="mt-4 text-center">
            {{ $questions->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>

<script>
    function confirmDelete(questionId) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action ne peut pas être annulée !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + questionId).submit();
            }
        });
    }
</script>
@endsection