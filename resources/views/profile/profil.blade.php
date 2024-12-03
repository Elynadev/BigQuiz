@extends('layouts.app')

@section('content')
<div class="container mx-auto w-full max-w-md h-auto p-6 mt-20 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-center mb-6">Bienvenue sur votre profil, {{ $user->name }}</h1>
    
    <ul class="list-disc pl-5 mb-6">
        <li class="text-lg">Email: <span class="font-medium">{{ $user->email }}</span></li>
        <li class="text-lg">Créé le: <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span></li>
        <li class="text-lg">Mis à jour le: <span class="font-medium">{{ $user->updated_at->format('d/m/Y') }}</span></li>
    </ul>

    <h2 class="text-2xl font-semibold mb-4">Vos scores</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Score</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="border-b border-gray-300 hover:bg-gray-100">
                    <td class="py-3 px-6">1</td>
                    <td class="py-3 px-6">2</td>
                </tr>
                <!-- Ajoutez d'autres lignes de scores ici -->
            </tbody>
        </table>
    </div>
</div>
@endsection