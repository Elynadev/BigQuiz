<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $score;
    public $totalQuestions;

    public function __construct($score, $totalQuestions)
    {
        $this->score = $score;
        $this->totalQuestions = $totalQuestions;
    }

    public function build()
    {
        return $this
            ->subject('Résultats de votre Quiz')
            ->view('emails.quiz_result'); // Assurez-vous que cette vue existe
    }
}