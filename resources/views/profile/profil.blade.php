@extends('layouts.app')

@section('content')
<div class="container mx-auto w-[500px] h-auto p-6 mt-20 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-center mb-6">Bienvenue sur votre profil, {{ $user->name }}</h1>
    
    <ul class="list-disc pl-5">
        <li class="text-lg">Email: <span class="font-medium">{{ $user->email }}</span></li>
        <li class="text-lg">Créé le: <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span></li>
        <li class="text-lg">Mis à jour le: <span class="font-medium">{{ $user->updated_at->format('d/m/Y') }}</span></li>
    </ul>

    <h2 class="text-2xl font-semibold mt-6 mb-4">Vos scores</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Score</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($results as $result)
                    <tr class="border-b border-gray-300 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $result->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-6">{{ $result->score }}</td>
                    </tr>
                @endforeach
                
                @if($results->isEmpty())
                    <tr>
                        <td class="py-3 px-6 text-center" colspan="2">Aucun score enregistré.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if($bestScore)
        <h2 class="text-lg font-semibold mt-6">Meilleur Score: <span class="font-medium text-green-600">{{ $bestScore }}</span></h2>
    @endif
</div>
@endsection