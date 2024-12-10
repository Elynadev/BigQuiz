@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-green-400 to-blue-800 font-roboto min-h-screen flex items-center justify-center">
    <div class="container mx-auto p-4 max-w-lg">
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
    <input type="hidden" name="email" id="email" value="{{ auth()->user()->email }}">
</form>

<!-- Toast Notification -->
<div id="toast" class="hidden fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-all duration-500">
    Score envoyé avec succès !
</div>

<!-- Modal pour email -->
<div id="email-modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 id="modal-title" class="text-lg font-bold mb-4">Recevoir les résultats par email ?</h2>
          
        <p>Souhaitez-vous recevoir vos résultats de quiz à l'adresse email associée à votre compte ?</p>
        <div class="mt-4">
           <button id="confirm-email" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" aria-label="Confirmer l'envoi de l'email">Oui</button>

            <button id="cancel-email" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Non</button>
        </div>
    </div>
</div>

<!-- Modal pour le statut d'envoi d'email -->
<div id="status-modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 id="status-title" class="text-lg font-bold mb-4"></h2>
        <p id="status-message"></p>
        <button id="close-status-modal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">Fermer</button>
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
        background-color: #38a169; /* Vert pour la bonne réponse */
    }

    .answer-button.wrong {
        background-color: #e53e3e; /* Rouge pour la mauvaise réponse */
    }

    .answer-button:hover {
        background-color: #3182ce; /* Couleur au survol */
    }

    .result-card {
        background-color: #f9fafb;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;

        margin: 8px; /* Espacement entre les cartes */
        flex: 1 1 calc(25% - 16px); /* 4 cartes par rangée avec un espacement */
        box-sizing: border-box; /* Inclut le padding et la bordure dans la largeur totale */
    }

    .result-grid {
        display: flex;
        flex-wrap: wrap; /* Permet aux cartes de passer à la ligne suivante */
        justify-content: space-between; /* Espace entre les cartes */
    }

    #toast {
        opacity: 0;
    }

    #toast.show {
        opacity: 1;
    }

    #email-modal {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #email-modal.show {
        opacity: 1;
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

            // Parser les réponses (clé `reponses` est une chaîne JSON)
            const answers = JSON.parse(questionData.reponses || '[]');

            // Filtrer les réponses pour exclure les champs vides ou null
            const filteredAnswers = answers.filter(answer => answer.response !== null && answer.response.trim() !== '');

            // Générer le HTML de la question et des réponses
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

        // Fonction pour afficher les résultats
        function showResults() {
            const resultsContainer = document.getElementById('quiz-container');
            const resultCards = questions.map((question, index) => {
                const answers = JSON.parse(question.reponses || '[]');
                const correctAnswersList = answers.filter(a => a.is_correct && a.response !== null);

                // Si aucune réponse correcte n'est trouvée, ne pas afficher la carte
                if (correctAnswersList.length === 0) return '';

                const correctAnswer = correctAnswersList[0].response; // Prendre la première réponse correcte
                return `
                    <div class="result-card fade-in">
                        <h3 class="font-semibold">Question ${index + 1}:</h3>
                        <p class="question-text">${question.question_text}</p>
                        <p class="text-gray-700">Réponse correcte: <strong>${correctAnswer}</strong></p>
                    </div>
                `;
            }).join('');

            resultsContainer.innerHTML = `
                <h2 class="text-lg font-semibold mb-2 fade-in">Quiz Terminé !</h2>
                <p class="text-lg font-semibold mb-4 fade-in">Votre Score : ${correctAnswers} / ${questions.length}</p>
                <div class="result-grid">${resultCards}</div>
                <button class="bg-green-500 text-white p-3 rounded hover:bg-green-600 transition duration-300 ease-in-out" id="submit-score-button">Soumettre le Score</button>
                <button class="bg-blue-500 text-white p-3 rounded hover:bg-blue-600 transition duration-300 ease-in-out" id="restart-button">Recommencer</button>
            `;

            // Remplir le champ caché du score
            document.getElementById('final-score').value = correctAnswers;

            // Écouteur pour soumettre le score
            document.getElementById('submit-score-button').onclick = function() {
                // Afficher le toast
                const toast = document.getElementById('toast');
                toast.classList.remove('hidden');
                toast.classList.add('show');

                // Masquer le toast après 1 seconde et afficher le modal
                setTimeout(() => {
                    toast.classList.remove('show');
                    toast.classList.add('hidden');

                    // Afficher le modal pour demander l'email
                    const emailModal = document.getElementById('email-modal');
                    emailModal.classList.remove('hidden');
                    emailModal.classList.add('show');
                }, 1000);
            };

            // Gestion des clics sur les boutons du modal
          document.getElementById('confirm-email').onclick = function() {
    const formData = new FormData(document.getElementById('score-form'));

    fetch('{{ route("results.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('status-title').innerText = data.status === 'succès' ? 'Succès' : 'Erreur';
        document.getElementById('status-message').innerText = data.message;

        const statusModal = document.getElementById('status-modal');
        statusModal.classList.remove('hidden');
    })
    .catch(error => {
        console.error('Erreur dans l\'envoi des données : ', error);
    });
};

            document.getElementById('cancel-email').onclick = function() {
                // Fermer le modal sans envoyer d'email
                const emailModal = document.getElementById('email-modal');
                emailModal.classList.remove('show');
                emailModal.classList.add('hidden');
                
                // Soumettre le formulaire sans l'option email
                document.getElementById('score-form').submit();
            };

            // Écouteur pour recommencer le quiz
            document.getElementById('restart-button').onclick = function() {
                location.reload();
            };
        }

        // Écouteur d'événements pour les clics sur les réponses
        document.getElementById('quiz-container').addEventListener('click', function(event) {
            if (event.target.tagName === 'BUTTON') {
                const selected = event.target.dataset.index;

                // Vérifiez si la réponse est correcte
                if (selected === 'correct') {
                    correctAnswers++;
                    event.target.classList.add('correct');
                } else {
                    event.target.classList.add('wrong');
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