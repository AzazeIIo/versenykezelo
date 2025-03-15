<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competition>
 */
class CompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'year' => fake()->year(),
            'languages' => implode(", ", [fake()->languageCode(),fake()->languageCode(),fake()->languageCode()]),
            'right_ans' => fake()->numberBetween(1, 10),
            'wrong_ans' => fake()->numberBetween(-10, 0),
            'empty_ans' => fake()->numberBetween(-10, 10),
        ];
    }
}
