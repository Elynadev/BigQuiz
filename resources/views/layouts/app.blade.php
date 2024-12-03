<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        <!-- Mobile menu button -->
                    </div>
                    <div class="flex-1 flex items-center  justify-center sm:items-stretch sm:justify-start">
                        <div class="hidden sm:block sm:ml-6">
                            <div class="flex space-x-4">
                                <a href="{{ route('dashboard') }}" class="text-gray-900 hover:text-gray-700">Dashboard</a>
                                <a href="{{ route('admin.index') }}" class="text-gray-900 hover:text-gray-700">Questions</a>
                                <a href="{{ route('admin.results') }}" class="text-gray-900 hover:text-gray-700">Résultats</a>
                                <a href="{{ route('profile.edit') }}" class="text-gray-900 hover:text-gray-700">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-gray-900 hover:text-gray-700">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @yield('content') <!-- Utilisation de pour le contenu -->
        </main>
    </div>
</body>
</html>