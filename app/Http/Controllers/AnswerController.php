<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
class AnswerController extends Controller
{
     public function index(): View
    {

        $questions = [
            [
                'question' => 'What is the capital of France?',
                'options' => ['Berlin', 'Madrid', 'Paris', 'Rome'],
                'answer' => 2,
                'image' => 'https://placehold.co/300x200?text=Eiffel+Tower&bg=gray'
            ],
            [
                'question' => 'What is the largest planet in our solar system?',
                'options' => ['Earth', 'Mars', 'Jupiter', 'Saturn'],
                'answer' => 2,
                'image' => 'https://placehold.co/300x200?text=Jupiter&bg=gray'
            ],
            [
                'question' => 'Who wrote "To Kill a Mockingbird"?',
                'options' => ['Harper Lee', 'J.K. Rowling', 'Ernest Hemingway', 'Mark Twain'],
                'answer' => 0,
                'image' => 'https://placehold.co/300x200?text=Harper+Lee&bg=gray'
            ]
        ];

        return view('answer',  ['questions' => $questions]);
    }
}