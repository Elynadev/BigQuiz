@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Liste des Résultats</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-2 px-4 border-b border-gray-300">Utilisateur</th>
                    <th class="py-2 px-4 border-b border-gray-300">Score</th>
                    <th class="py-2 px-4 border-b border-gray-300">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-300">{{ $result->user->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $result->score }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $result->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection