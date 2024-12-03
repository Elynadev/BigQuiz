@extends('layouts.app')

@section('content')
<div class="container mx-auto  w-[500px]  h-[700px] p-6 mt-20 bg-white rounded-lg shadow-md">
    <ul class="list-disc mt-[250px] pl-5">
    <h1 class="text-3xl font-bold  text-center mb-6">Bienvenue sur votre profil, {{ $user->name }}</h1>
       <li class="text-lg ml-20 ">Email: <span class="font-medium">{{ $user->email }}</span></li>
        <li class="text-lg ml-20">Créé le: <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span></li>
        <li class="text-lg ml-20">Mis à jour le: <span class="font-medium">{{ $user->updated_at->format('d/m/Y') }}</span></li>
    </ul>


<h2 class="text-2xl font-semibold mb-4">Vos scores</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Score</th>
                    <!-- <th class="py-3 px-6 text-left">Commentaire</th> -->
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                
                <tr class="border-b border-gray-300 hover:bg-gray-100">
                    <td class="py-3 px-6">1</td>
                    <td class="py-3 px-6">2</td>
                    <td class="py-3 px-6">5</td>
                </tr>
        
            </tbody>
        </table>
    </div>
    </div>
@endsection