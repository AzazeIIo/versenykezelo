<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Round;
use App\Models\Competitor;
use App\Models\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competitor>
 */
class CompetitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $users =  User::pluck('id');
        $user = fake()->randomElement($users);
        $unavailableRounds = Competitor::where('user_id', '=', $user)->select('round_id')->get();
        $unavailableRoundIds = $unavailableRounds->pluck('round_id');
        $availableCompetitions = Round::whereNotIn('id', $unavailableRounds)->select('competition_id')->get();
        $competition = fake()->randomElement($availableCompetitions)['competition_id'];
        $rounds = Round::where('competition_id', '=', $competition)->select('id')->get();
        foreach($rounds as $round) {
            if(!in_array($round['id'], $unavailableRoundIds->toArray())) {
                $round = $round['id'];
                break;
            }
        }

        return [
            'user_id' => $user,
            'round_id' => $round,
        ];
    }
}
