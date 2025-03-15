<?php

namespace Database\Factories;

use App\Models\Round;
use App\Models\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Round>
 */
class RoundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $competitions =  Competition::select(['id', 'year'])->get();
        $randomCompetition = fake()->randomElement($competitions);
        $competitionId = $randomCompetition['id'];
        $competitionYear = $randomCompetition['year'];
        $rounds = Round::where('competition_id', '=', $competitionId)->orderBy('round_number', 'desc')->select(['round_number', 'date'])->get();
        $roundNumber = 0;
        $date = fake()->dateTimeBetween($competitionYear. '-01-01', $competitionYear. '-12-31');

        if(count($rounds) != 0) {
            $lastRound = $rounds[0];
            $roundNumber = $lastRound['round_number'] + 1;
            $date = fake()->dateTimeBetween($lastRound['date'], $competitionYear. '-12-31');
        }

        return [
            'competition_id' => $competitionId,
            'round_number' => $roundNumber,
            'date' => $date
        ];
    }
}
