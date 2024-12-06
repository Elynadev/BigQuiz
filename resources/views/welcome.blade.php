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
<body >
    <div class="min-h-screen bg-gradient-to-r
 from-green-400 to-blue-800 font-roboto grid place-items-center text-black/50 dark:bg-gray-800 dark:text-white/50">
        

 <div class="relative  ml-[500px] px-6 lg:max-w-9xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 ml-60 lg:grid-cols-3 ">
              
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
    <h2 class="text-2xl font-bold mb-4">Prêt à commencer ?</h2>
    <p class="mb-4">
        Inscrivez-vous ou connectez-vous dès maintenant pour débloquer des fonctionnalités exclusives et rejoindre notre communauté de quizzeurs passionnés.
    </p>
    <p>
        Que vous soyez ici pour vous amuser ou pour apprendre, nous sommes là pour vous accompagner à chaque étape.
    </p>
                @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-md px-3  mt-6 mr-32 bg-gray-400 py-2 text-1xl text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#20b8ff] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-md px-3 py-2  bg-gray-400 mr-32 text-1xl text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-md px-3 bg-gray-400  mr-6 text-1xl py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
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