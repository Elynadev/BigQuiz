@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-blue-400 to-purple-500 font-roboto min-h-screen flex items-center justify-center">
    <div class="container mx-auto p-4 max-w-md">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">Quiz Game</h1>
            <div id="quiz-container">
                <div id="question-container"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questions = [
            {
                question: "What is the capital of France?",
                options: ["Berlin", "Madrid", "Paris", "Rome"],
                answer: 2,
                image: "https://placehold.co/300x200?text=Eiffel+Tower&bg=gray"
            },
            {
                question: "What is the largest planet in our solar system?",
                options: ["Earth", "Mars", "Jupiter", "Saturn"],
                answer: 2,
                image: "https://placehold.co/300x200?text=Jupiter&bg=gray"
            },
            {
                question: "Who wrote 'To Kill a Mockingbird'?",
                options: ["Harper Lee", "J.K. Rowling", "Ernest Hemingway", "Mark Twain"],
                answer: 0,
                image: "https://placehold.co/300x200?text=Harper+Lee&bg=gray"
            },
            {
                question: "What is the chemical symbol for water?",
                options: ["H2O", "CO2", "O2", "NaCl"],
                answer: 0,
                image: "https://placehold.co/300x200?text=Water+Molecule&bg=gray"
            },
            {
                question: "What is the speed of light?",
                options: ["300,000 km/s", "150,000 km/s", "450,000 km/s", "600,000 km/s"],
                answer: 0,
                image: "https://placehold.co/300x200?text=Speed+of+Light&bg=gray"
            }
        ];

        let currentQuestionIndex = 0;
        let correctAnswers = 0;

        function loadQuestion() {
            const questionContainer = document.getElementById('question-container');
            const questionData = questions[currentQuestionIndex];
            questionContainer.innerHTML = `
                <h2 class="text-lg font-semibold mb-2 fade-in">${questionData.question}</h2>
                <img src="${questionData.image}" alt="Image related to the question: ${questionData.question}" class="mb-4 w-full h-48 object-cover rounded-lg fade-in">
                <ul>
                    ${questionData.options.map((option, index) => `
                        <li class="mb-2 fade-in">
                            <button class="w-full text-left bg-gray-200 p-2 rounded hover:bg-gray-300 transition duration-300 ease-in-out transform hover:scale-105" data-index="${index}">${option}</button>
                        </li>
                    `).join('')}
                </ul>
            `;
        }

        function showResults() {
            const resultsContainer = document.getElementById('quiz-container');
            resultsContainer.innerHTML = `
                <h2 class="text-lg font-semibold mb-2 fade-in">Quiz Completed!</h2>
                <p class="text-lg font-semibold mb-4 fade-in">Your Score: ${correctAnswers} / ${questions.length}</p>
            `;
            questions.forEach((question, index) => {
                resultsContainer.innerHTML += `
                    <div class="mb-4">
                        <h3 class="text-md font-semibold">${index + 1}. ${question.question}</h3>
                        <p class="text-green-500">Correct Answer: ${question.options[question.answer]}</p>
                    </div>
                `;
            });
        }

        document.getElementById('quiz-container').addEventListener('click', function (event) {
            if (event.target.tagName === 'BUTTON' && event.target.dataset.index !== undefined) {
                const selectedOption = parseInt(event.target.dataset.index);
                const correctAnswer = questions[currentQuestionIndex].answer;

                const buttons = event.target.parentElement.parentElement.querySelectorAll('button');
                buttons.forEach((button, index) => {
                    if (index === correctAnswer) {
                        button.classList.add('bg-green-500', 'text-white');
                    } else {
                        button.classList.add('bg-red-500', 'text-white');
                    }
                    button.disabled = true;
                });

                if (selectedOption === correctAnswer) {
                    correctAnswers++;
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