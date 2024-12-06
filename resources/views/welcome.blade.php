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
<body class="font-sans antialiased bg-gradient-to-r
 from-green-400 to-blue-800 font-roboto dark:bg-gray-800 dark:text-white/50">
    <div class="min-h-screen bg-gradient-to-r
 from-green-400 to-blue-800 font-roboto grid place-items-center text-black/50 dark:bg-gray-800 dark:text-white/50">
        <div class="relative flex flex-col items-center justify-center selection:bg-[#209bff] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 ml-60 lg:grid-cols-3 ">
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-md px-3  bg-gray-400 py-2 text-2xl text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#20b8ff] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-md px-3 py-2  bg-gray-400 mr-6 text-2xl text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-md px-3 bg-gray-400 text-2xl py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <!-- Contenu principal ici -->
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    <!-- Footer ici -->
                </footer>
            </div>
        </div>
    </div>
</body>
</html>