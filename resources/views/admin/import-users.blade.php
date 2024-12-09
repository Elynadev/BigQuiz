<!-- resources/views/admin/import-users.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-gradient-to-r from-blue-500 to-teal-500 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-white text-center">Importer des Utilisateurs</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-6">
            <label for="file" class="block text-gray-700 text-2xl text-center font-bold mb-2">Choisissez un fichier Excel :</label>
            <input type="file" name="file" id="file" class="border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 mt-1 block w-full" required>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-green-600 transition duration-300">Importer</button>
        </div>
    </form>
</div>
</div>
@endsection