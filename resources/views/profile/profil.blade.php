@extends('layouts.app')

@section('content')
<div class="container mx-auto w-full max-w-md p-6 mt-20 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center mb-6 text-white bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg p-4">
        Bienvenue sur votre profil, {{ $user->name }}
    </h1>
    
    <ul class="list-disc pl-5 mb-6 text-gray-800">
        <li class="text-lg">Email: <span class="font-medium">{{ $user->email }}</span></li>
        <li class="text-lg">Créé le: 
            <span class="font-medium">
                {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Non disponible' }}
            </span>
        </li>
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
                        <td class="py-3 px-6 border-r border-gray-300 text-center">{{ $result->score }} / {{ $totalQuestions }}</td> <!-- Affiche le score et le nombre total de questions -->
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

    <div class="text-center">
        <a href="{{ route('profile.export') }}" class="mt-4 inline-flex items-center gap-2 bg-blue-600 text-white px-1 py-1 rounded-full hover:bg-green-500">
            <span class="font-medium text-xl">Exporter les résultats</span>
            <div class="svg-container">
                <svg width="20px" height="20px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <path d="M768 810.7c-23.6 0-42.7-19.1-42.7-42.7s19.1-42.7 42.7-42.7c94.1 0 170.7-76.6 170.7-170.7 0-89.6-70.1-164.3-159.5-170.1L754 383l-10.7-22.7c-42.2-89.3-133-147-231.3-147s-189.1 57.7-231.3 147L270 383l-25.1 1.6c-89.5 5.8-159.5 80.5-159.5 170.1 0 94.1 76.6 170.7 170.7 170.7 23.6 0 42.7 19.1 42.7 42.7s-19.1 42.7-42.7 42.7c-141.2 0-256-114.8-256-256 0-126.1 92.5-232.5 214.7-252.4C274.8 195.7 388.9 128 512 128s237.2 67.7 297.3 174.2C931.5 322.1 1024 428.6 1024 554.7c0 141.1-114.8 256-256 256z" fill="#74ec8d" />
                    <path d="M512 938.7c-10.9 0-21.8-4.2-30.2-12.5l-128-128c-16.7-16.7-16.7-43.7 0-60.3 16.6-16.7 43.7-16.7 60.3 0l97.8 97.8 97.8-97.8c16.6-16.7 43.7-16.7 60.3 0 16.7 16.7 16.7 43.7 0 60.3l-128 128c-8.2 8.3-19.1 12.5-30 12.5z" fill="#74ec8d" />
                    <path d="M512 938.7c-23.6 0-42.7-19.1-42.7-42.7V597.3c0-23.6 19.1-42.7 42.7-42.7s42.7 19.1 42.7 42.7V896c0 23.6-19.1 42.7-42.7 42.7z" fill="#74ec8d" />
                </svg>
            </div>
        </a>
    </div>

    @if($bestScore)
        <h2 class="text-lg font-semibold mt-6 text-gray-800">Meilleur Score: <span class="font-medium text-green-600">{{ $bestScore }}</span></h2>
    @endif
</div>
@endsection