@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-bold mb-6 text-blue-700 text-center">Liste des Questions</h1>
    <a href="{{ route('admin.create') }}" class="bg-gradient-to-r from-green-400 to-green-600 text-white font-bold py-2 
    px-6 rounded-lg mb-4 inline-block transition duration-300 hover:from-green-500 hover:to-green-700 shadow-md">Ajouter une Question</a>

    @if(session('success'))
        <div class="bg-green-300 border border-green-600 text-green-800 p-4 rounded-lg mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-center">
        <div class="overflow-x-auto rounded-lg shadow-lg w-full max-w-4xl">
            <table class="min-w-full bg-white border border-gray-800 rounded-lg shadow-md">
                <thead class="bg-blue-200 text-gray-800">
                    <tr>
                        <th class="py-3 px-4 border-b border-gray-300 text-left">Question</th>
                        <th class="py-3 px-4 border-b border-gray-300 text-left">Actif</th>
                        <th class="py-3 px-4 border-b border-gray-300 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                        <tr class="hover:bg-blue-50 transition duration-200">
                            <td class="py-3 px-4 border-b border-gray-300">{{ $question->question_text }}</td>
                            <td class="py-3 px-4 border-b border-gray-300">{{ $question->is_active ? 'Oui' : 'Non' }}</td>
                            <td class="py-3 px-4 border-b border-gray-300 flex space-x-2">
                                <a href="{{ route('admin.edit', $question) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded-lg transition duration-300 shadow">Modifier</a>
                                <form action="{{ route('admin.destroy', $question) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-400 hover:bg-red-500 text-white font-bold py-1 px-3 rounded-lg transition duration-300 shadow" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection