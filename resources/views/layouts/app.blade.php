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
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script src="anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="js/jquery.balloon.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Styles pour le texte multicolore -->
    <style>
        .multicolor-text {
            background: linear-gradient(90deg, #21daff, #33FF57, #E0FF20,#ebb016,#FF5C1A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-600 border-b border-blue-700 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex-shrink-0">
                        <h1 class="multicolor-text text-4xl font-bold">BigGame</h1>
                    </div>
                    <div class="hidden sm:block">
                        <div class="flex space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Dashboard</a>
                            <a href="{{ route('admin.index') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Questions</a>
                            <a href="{{ route('admin.results') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Résultats</a>
                            <a href="{{ route('profile.profil') }}" class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-xl font-bold">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:bg-red-500 px-3 py-2 rounded-md text-xl bg-green-600 font-medium">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-semibold text-gray-100">{{ $header }}</h2>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content') <!-- Utilisation de pour le contenu -->
            </div>
        </main>
    </div>

    <script src="{{ asset('js/gsap-animations.js') }}"></script>
</body>
</html>