@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-green-400 to-blue-500 font-roboto min-h-screen flex items-center justify-center">
        <div class="container mx-auto p-4 max-w-md">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-4 text-center text-gray-800">Jeu de Quiz</h1>
                <div id="quiz-container">
                    <div id="question-container"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclus les fichiers CSS nécessaires -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questions = @json($questions); // Passer les questions de PHP à JavaScript

            let currentQuestionIndex = 0;
            let correctAnswers = 0;

            // Fonction pour charger une question
            function loadQuestion() {
                const questionContainer = document.getElementById('question-container');
                const questionData = questions[currentQuestionIndex];

                questionContainer.innerHTML = `
                <h2 class="text-lg font-semibold mb-2 fade-in">${questionData.question_text}</h2>
                <ul class="list-none p-0">
                    ${questionData.answers.map(answer => `
                                <li class="mb-2 fade-in">
                                    <button class="w-full text-left bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300 ease-in-out" data-index="${answer.is_correct ? 'correct' : 'wrong'}">${answer.answer_text}</button>
                                </li>
                            `).join('')}
                </ul>
            `;
            }

            // Fonction pour afficher les résultats
            function showResults() {
                const resultsContainer = document.getElementById('quiz-container');
                resultsContainer.innerHTML = `
                <h2 class="text-lg font-semibold mb-2 fade-in">Quiz Terminé !</h2>
                <p class="text-lg font-semibold mb-4 fade-in">Votre Score : ${correctAnswers} / ${questions.length}</p>
               
              
                <br> </br>
                <button class="bg-green-500 text-white p-2 rounded hover:bg-green-600 transition duration-
                300 ease-in-out" id="share-button">Voir les répones </button>
                <button class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-
                300 ease-in-out" id="restart-button">Recommencer</button>
               
                
                <br> </br>
                <button class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600 transition duration-
                300 ease-in-out" id="stats-button">Statistiques</button>
               
                <button class="bg-purple-500 text-white p-2 rounded hover:bg-purple-600 transition duration-
                300 ease-in-out" id="leaderboard-button">Leaderboard</button>
                 <button class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition duration-
                300 ease-in-out" id="quit-button">Quitter</button>
                 `;

            }

            // Écouteur d'événements pour les clics sur les réponses
            document.getElementById('quiz-container').addEventListener('click', function(event) {
                if (event.target.tagName === 'BUTTON') {
                    const selected = event.target.dataset.index;

                    // Vérifiez si la réponse est correcte
                    if (selected === 'correct') {
                        correctAnswers++;
                        event.target.classList.add('bg-green-500', 'text-white');
                    } else {
                        event.target.classList.add('bg-red-500', 'text-white');
                    }

                    // Chargez la question suivante après un délai
                    setTimeout(() => {
                        currentQuestionIndex++;
                        if (currentQuestionIndex < questions.length) {
                            loadQuestion();
                        } else {
                            showResults();
                        }
                    }, 1000);
                }
            });

            // Charger la première question
            loadQuestion();
        });
    </script>
@endsection
