<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'text' => $this->faker->sentence(),
            'is_correct' => $this->faker->boolean(), // Valeur booléenne aléatoire
            'question_id' => \App\Models\Question::factory(), // Crée une question associée
        ];
    }
}