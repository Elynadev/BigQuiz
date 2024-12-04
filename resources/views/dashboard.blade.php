@extends('layouts.app')
@section('content')
<div class="relative h-screen bg-cover bg-center" style="background-image: url('images/hopscotch-concept-illustration_114360-8387.jpg');">
    <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Overlay for better text visibility -->
    
    <div class="flex flex-col items-center justify-center h-full">
        <!-- Animated Letters -->
        <div id="animated-letters" class="text-center text-6xl font-extrabold text-green-600 mb-8"></div>

        <div class="bg-white bg-opacity-80 w-full max-w-md mx-auto shadow-lg rounded-lg transition transform hover:scale-105 duration-300 ease-in-out p-6 mb-8">
            <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-4">Commençons le quiz !</h1>
            <p class="text-center text-slate-800 font-bold mb-2">Bienvenue sur votre site de quiz</p>
            <p class="text-center text-slate-800 font-bold mb-2">Ici, vous pouvez mettre à l'épreuve votre savoir sur une variété de sujets captivants</p>
            <p class="text-center text-slate-800 font-bold mb-6">Défiez-vous avec des quiz interactifs et amusez-vous tout en apprenant !</p>
        </div>

        <a href="/answer" id="start-button"
           class="mt-4 inline-block w-full max-w-xs bg-blue-600 text-white px-6 py-3 text-center rounded-lg 
                 text-3xl shadow-md font-bold transition duration-300 ease-in-out transform hover:bg-blue-500 hover:shadow-lg hover:scale-105">
                  Commencer le jeu
        </a>
    </div>

    <!-- Balloons -->
    <div id="balloons" class="absolute top-0 left-0 w-full h-full pointer-events-none"></div>
</div>

<!-- Including the libraries -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/balloon-css/dist/balloon.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script>
    // Animate letters
    const letters = "Bienvenue sur Genius !".split('');
    const animatedLetters = document.getElementById('animated-letters');
    letters.forEach(letter => {
        const span = document.createElement('span');
        span.innerText = letter;
        animatedLetters.appendChild(span);
    });

    anime({
        targets: '#animated-letters span',
        translateY: [-50, 0],
        opacity: [0, 1],
        duration: 500,
        easing: 'easeOutExpo',
        delay: anime.stagger(100) // delay between each letter
    });

    // Balloons animation
    function createBalloon() {
        const balloon = document.createElement('div');
        balloon.className = 'balloon';
        balloon.style.position = 'absolute';
        balloon.style.left = Math.random() * window.innerWidth + 'px';
        balloon.style.bottom = '-100px';
        balloon.style.transition = 'bottom 5s linear';
        balloon.innerHTML = '✨✨'; // Balloon emoji
        document.getElementById('balloons').appendChild(balloon);
        setTimeout(() => {
            balloon.style.bottom = window.innerHeight + 'px';
        }, 100);
        setTimeout(() => {
            balloon.remove();
        }, 6000);
    }

    setInterval(createBalloon, 800); // Create a balloon every 800ms

    document.getElementById('start-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link
        // Start the confetti animation
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
        // Redirect to the answer page after a short delay
        setTimeout(() => {
            window.location.href = '/answer';
        }, 1000); // Redirect after 1 second
    });
</script>

<style>
    .balloon {
        font-size: 3rem;
        opacity: 0.7;
        animation: float 5s ease-in forwards;
    }

    @keyframes float {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-100vh);
        }
    }
</style>
@endsection