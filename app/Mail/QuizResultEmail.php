<?php

namespace App\Mail;

use App\Models\Result;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuizResultEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $result;
    public $questions;
    public $submittedText;
    


    public function __construct($result, $questions, $submittedText)
    {
        $this->result = $result;
        $this->questions = $questions;
        $this->submittedText = $submittedText;
       
    }

    public function build()
    {
        return $this->view('result') // Assurez-vous que ce chemin est correct
                    ->with([
                        'result' => $this->result,
                        'questions' => $this->questions,
                        'submittedText' => $this->submittedText,
                       
                    ]);
    }

    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quiz Result Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
