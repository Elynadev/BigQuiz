<?php

namespace Database\Factories;

use App\Models\Result; // Assurez-vous que le bon modèle est importé
use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResultFactory extends Factory
{
    protected $model = Result::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'question_id' => Question::factory(),
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}