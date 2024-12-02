@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Liste des Questions</h1>
    <a href="{{ route('admin.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Ajouter une Question</a>

    @if(session('success'))
        <div class="bg-green-200 border border-green-600 text-green-600 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-2 px-4 border-b border-gray-300">Question</th>
                    <th class="py-2 px-4 border-b border-gray-300">Actif</th>
                    <th class="py-2 px-4 border-b border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-300">{{ $question->question_text }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $question->is_active ? 'Oui' : 'Non' }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <a href="{{ route('admin.edit', $question) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Modifier</a>
                            <form action="{{ route('admin.destroy', $question) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection