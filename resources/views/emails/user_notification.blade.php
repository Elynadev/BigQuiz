<!DOCTYPE html>
<html>
<head>
    <title>Notification</title>
</head>
<body>
    {{-- <h1>Bonjour {{ $user->name }}</h1> --}}
    <p>Vous avez soumis le texte suivant :</p>
    <p>{{ $submittedText }}</p>

    <h2>Résultats du Quiz</h2>
    <p>Votre Score : {{ $result->score }} / {{ $questions->count() }}</p>

    <h3>Questions et Réponses :</h3>
    <ul>
        @foreach ($questions as $question)
            <li>
                <strong>Question :</strong> {{ $question->question_text }}<br>
                <strong>Réponse :</strong> {{ $question->reponse_correcte }}
            </li>
        @endforeach
    </ul>
</body>
</html>