<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResultsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $score;

    /**
     * Crée une nouvelle instance de Mailable.
     *
     * @param int $score
     */
    public function __construct($score)
    {
        $this->score = $score;
    }

    /**
     * Construire le message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre résultat au quiz')
                    ->view('email.resultat')
                    ->with([
                        'score' => $this->score,
                    ]);
    }
}
