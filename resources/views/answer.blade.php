@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-green-400 to-blue-800 font-roboto min-h-screen flex items-center justify-center">
        <div class="container mx-auto p-4 max-w-screen-lg"> <!-- Augmente la largeur maximale -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h1 class="text-4xl font-bold mb-6 text-center text-gray-800">Jeu de Quiz</h1>
                <div id="quiz-container" class="fade-in transition-opacity duration-500">
                    <div id="question-container"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire caché pour soumettre le score -->
    <form id="score-form" action="{{ route('results.store') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="score" id="final-score" value="">
    </form>

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

        button {
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            transform: scale(1.05);
        }

        .question-text {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .answer-button {
            background-color: #4f83cc;
            color: white;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: background-color 0.3s, color 0.3s;
        }

        .answer-button.correct {
            background-color: #38a169;
            /* Vert pour la bonne réponse */
        }

        .answer-button.wrong {
            background-color: #e53e3e;
            /* Rouge pour la mauvaise réponse */
        }

        .answer-button:hover {
            background-color: #3182ce;
            /* Couleur au survol */
        }

        .result-card {
            background-color: #f9fafb;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin: 8px;
            /* Espacement entre les cartes */
            flex: 1 1 calc(25% - 16px);
            /* 4 cartes par rangée avec un espacement */
            box-sizing: border-box;
            /* Inclut le padding et la bordure dans la largeur totale */
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* Quatre colonnes */
            gap: 16px;
            /* Espacement entre les cartes */
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questions = @json($questions);
            let currentQuestionIndex = 0;
            let correctAnswers = 0;

            function loadQuestion() {
                const questionContainer = document.getElementById('question-container');
                const questionData = questions[currentQuestionIndex];
                const answers = JSON.parse(questionData.reponses || '[]');
                const filteredAnswers = answers.filter(answer => answer.response !== null && answer.response
                .trim() !== '');

                questionContainer.innerHTML = `
                <h2 class="question-text fade-in">${questionData.question_text}</h2>
                <img src="${questionData.image}" alt="Image liée à la question" class="mb-4 w-full h-48 object-cover rounded-lg fade-in shadow-md">
                <ul class="list-none p-0">
                    ${filteredAnswers.map(answer => `
                                                <li class="mb-2 fade-in">
                                                    <button 
                                                        class="answer-button" 
                                                        data-index="${answer.is_correct ? 'correct' : 'wrong'}" 
                                                        data-correct="${answers.find(a => a.is_correct).response}">
                                                        ${answer.response}
                                                    </button>
                                                </li>
                                            `).join('')}
                </ul>
            `;
            }

            function showResults() {
                const resultsContainer = document.getElementById('quiz-container');
                const resultCards = questions.map((question, index) => {
                    const answers = JSON.parse(question.reponses || '[]');
                    const correctAnswersList = answers.filter(a => a.is_correct && a.response !== null);
                    if (correctAnswersList.length === 0) return '';

                    const correctAnswer = correctAnswersList[0].response;
                    return `
                    <div class="result-card fade-in">
                        <h3 class="font-semibold">Question ${index + 1}:</h3>
                        <p class="question-text">${question.question_text}</p>
                        <p class="text-green-700">Réponse correcte: <strong>${correctAnswer}</strong></p>
                        <p class="text-red-700">Votre réponse: <strong> d</strong></p>
                        </div>
                `;
                }).join('');

                resultsContainer.innerHTML = `
                <h2 class="text-lg text-center font-semibold mb-2 fade-in">Quiz Terminé !</h2>
                <p class="text-lg font-semibold text-center mb-4 fade-in">Votre Score : ${correctAnswers} / ${questions.length}</p>
                <div class="result-grid">${resultCards}</div>
                <div class="flex justify-center space-x-4">
    <button class="bg-green-500 text-white p-3 rounded hover:bg-green-600 transition duration-300 ease-in-out" id="submit-score-button">Soumettre le resultat</button>
    <button class="bg-blue-500 text-white p-3 rounded hover:bg-blue-600 transition duration-300 ease-in-out" id="restart-button">Recommencer</button>
</div>

<!-- Afficher le formulaire de soumission de texte ici -->
<div class="mt-8 p-6 bg-white rounded-lg shadow-md">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Laissez un commentaire :</h3>
    <form action="{{ route('results.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="score" id="final-score" value=""> <!-- Assurez-vous que le score est défini ici -->

        <textarea 
            name="text" 
            required 
            placeholder="Votre message ici..." 
            class="w-full h-24 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>

        <label for="recipient_email" class="block text-gray-700">Choisissez un destinataire :</label>
        <select 
            name="recipient_email" 
            id="recipient_email" 
            required 
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            <option value="">Sélectionnez un utilisateur</option>
            @foreach ($users as $user)
                <option value="{{ $user->email }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>

        <button 
            type="submit" 
            class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition duration-200"
        >
            Soumettre le texte
        </button>
    </form>
</div>
            `;

                document.getElementById('final-score').value = correctAnswers;

                document.getElementById('submit-score-button').onclick = function() {
                    document.getElementById('score-form').submit();
                };

                document.getElementById('restart-button').onclick = function() {
                    location.reload();
                };
            }

            document.getElementById('quiz-container').addEventListener('click', function(event) {
                if (event.target.tagName === 'BUTTON') {
                    const selected = event.target.dataset.index;
                    if (selected === 'correct') {
                        correctAnswers++;
                        event.target.classList.add('correct');
                    } else {
                        event.target.classList.add('wrong');
                    }

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

            loadQuestion();
        });
    </script>
@endsection
