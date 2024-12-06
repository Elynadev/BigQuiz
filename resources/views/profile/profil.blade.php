@extends('layouts.app')

@section('content')
<div class="container mx-auto w-full max-w-md p-6 mt-20 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center mb-6 text-white bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg p-4">Bienvenue sur votre profil, {{ $user->name }}</h1>
    
    <ul class="list-disc pl-5 mb-6 text-gray-800">
        <li class="text-lg">Email: <span class="font-medium">{{ $user->email }}</span></li>
        <li class="text-lg">Créé le: <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span></li>
        <li class="text-lg">Mis à jour le: <span class="font-medium">{{ $user->updated_at->format('d/m/Y') }}</span></li>
    </ul>

    <h2 class="text-2xl font-semibold mt-6 mb-4 text-gray-800">Vos scores</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300 bg-gray-50 rounded-lg shadow-md">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-3 px-6 border-r border-gray-300 text-left">Utilisateur</th>
                    <th class="py-3 px-6 border-r border-gray-300 text-left">Score</th>
                    <th class="py-3 px-6 border-r border-gray-300 text-left">Date</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($results as $result)
                    <tr class="hover:bg-gray-100 transition duration-150 ease-in-out">
                        <td class="py-3 px-6 border-r border-gray-300 text-center">{{ $user->name }}</td>
                        <td class="py-3 px-6 border-r border-gray-300 text-center">{{ $result->score }}</td>
                        <td class="py-3 px-6 border-r border-gray-300 text-center">{{ $result->created_at->format('d/m/Y') }}</td>
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

    @if($bestScore)
        <h2 class="text-lg font-semibold mt-6 text-gray-800">Meilleur Score: <span class="font-medium text-green-600">{{ $bestScore }}</span></h2>
    @endif
</div>
@endsection
