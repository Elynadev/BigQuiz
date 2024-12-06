@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-white text-center">Liste des Résultats</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Utilisateur</th>
                    <th class="py-3 px-6 border-r border-b border-gray-300 text-left">Score</th>
                    <th class="py-3 px-6 border-b border-gray-300 text-left">Date</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($results as $result)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $result->user->name }}</td>
                        <td class="py-3 px-6 border-r border-b border-gray-300">{{ $result->score }}</td>
                        <td class="py-3 px-6 border-b border-gray-300">{{ $result->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                @if($results->isEmpty())
                    <tr>
                        <td class="py-3 px-6 text-center" colspan="3">Aucun score enregistré.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
