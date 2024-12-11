<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats du Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8; /* Couleur de fond doux */
        }
        .card {
            background-color: #ffffff; /* Couleur de fond blanche pour la carte */
            border-radius: 0.75rem; /* Arrondi des coins */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée */
        }
        .card-header {
            background-color: #38b2ac; /* Couleur bleu-vert */
            color: #ffffff; /* Texte blanc */
        }
        .good-answer {
            color: #f6e05e; /* Jaune clair */
        }
        .wrong-answer {
            color: #e53e3e; /* Rouge vif */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="card p-6 max-w-md w-full transition-transform transform hover:scale-105 text-center">
        <h1 class="text-3xl font-bold mb-4 card-header p-4 rounded-t">🎉 Résultats du Quiz 🎉</h1>
        
        <p class="text-3xl font-semibold text-blue-600 mb-2">Votre Score : <span class="font-extrabold">{{ $result->score }}</span> / {{ $questions->count() }}</p>
        
        <div class="border-t border-gray-300 mt-4 pt-4">
            <p class="text-lg text-blue-700">Vous avez obtenu :</p>
            <p class="text-lg font-semibold good-answer">🌟 Bonnes réponses : <span class="font-extrabold">{{ $result->score }}</span></p>
            <p class="text-lg font-semibold wrong-answer">❌ Mauvaises réponses : <span class="font-extrabold">{{ $questions->count() - $result->score }}</span></p>
        </div>

        <h3 class="text-xl font-semibold mt-6">Vos Commentaires :</h3>
        <p class="text-gray-600">{{ $submittedText }}</p>
    </div>
</body>
</html>