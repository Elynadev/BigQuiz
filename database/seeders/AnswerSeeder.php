<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crée 30 réponses fictives, chacune liée à une question
        Question::all()->each(function ($question) {
            Answer::factory()->count(3)->create(['question_id' => $question->id]);
        });
    }
}
