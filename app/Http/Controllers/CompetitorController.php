<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\Competition;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompetitorRequest;
use View;
use DB;

class CompetitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($competition_id, $round_id)
    {
        $competition = Competition::find($competition_id);
        $round = Round::where("competition_id", $competition_id)->where("id", $round_id)->get();

        if(isset($round[0])) {
            //$users = $round[0]->users()->get();
            $competitors = User::join('competitors', 'users.id', '=', 'competitors.user_id')
                    ->where('round_id', '=', $round_id)
                    ->get();
            $users = User::paginate(10);
            return View::make('Competitors.index')->with([
                'competition' => $competition,
                'round' => $round[0],
                'competitors' => $competitors,
                'users' => $users
            ]);
        }
        return redirect('/competitions/' . $competition_id . "/rounds");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($competition_id, $round_id)
    {
        return redirect("competitions/" . $competition_id . "/rounds/" . $round_id . "/competitors");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($competition_id, $round_id, StoreCompetitorRequest $request)
    {
        $fields = $request->validated();
        $fields['user_id'] = strip_tags($fields['user_id']);
        $fields['round_id'] = strip_tags($fields['round_id']);
        $competitor = Competitor::create($fields);
        $user = User::find($fields['user_id']);
        return response()->json([$competitor, $user,
            route('competitions.rounds.competitors.destroy',
            [$competition_id, $round_id, $competitor['id']])]);
    }

    /**
     * Display the specified resource.
     */
    public function show($competition_id, $round_id)
    {
        return redirect("competitions/" . $competition_id . "/rounds/" . $round_id . "/competitors");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competitor $competitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competitor $competitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($competition_id, $round_id, $competitor_id)
    {
        $competitor = Competitor::find($competitor_id);
        $competitor->delete($competitor);
    }
}
