<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Styles CSS ici */
        </style>
    @endif
</head>
<body>
    <div class="min-h-screen bg-gradient-to-r from-green-400 to-blue-800 font-roboto flex items-center justify-center text-black/50 dark:bg-gray-800 dark:text-white/50">
        <div class="bg-white p-6 rounded-lg shadow-md text-center max-w-xl w-full">
            <h2 class="text-2xl font-bold mb-4">Bienvenue sur BigGame!</h2>
            <h2 class="text-xl font-bold mb-4">Prêt à jouer ?</h2>
            <p class="mb-4">
                Inscrivez-vous ou connectez-vous dès maintenant pour débloquer des fonctionnalités exclusives et rejoindre notre communauté de quizzeurs passionnés.
            </p>
            <p class="mb-6">
                Que vous soyez ici pour vous amuser ou pour apprendre, nous sommes là pour vous accompagner à chaque étape.
            </p>

            @if (Route::has('login'))
                <nav class="flex flex-wrap justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md px-4 py-2 bg-gray-400 text-sm text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#20b8ff] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-4 py-2 bg-gray-400 text-sm text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md px-4 py-2 bg-gray-400 text-sm text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</body>
</html>
