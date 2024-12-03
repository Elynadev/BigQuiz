<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'question_text' => $this->faker->sentence(),
            'image' => $this->faker->imageUrl(640, 480, 'abstract'), // URL d'une image générée aléatoirement
            'is_active' => $this->faker->boolean(), // Valeur booléenne aléatoire
        ];
    }
}