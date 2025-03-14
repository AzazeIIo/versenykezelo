<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use App\Models\Competition;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;
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
            $users = User::join('competitors', 'users.id', '=', 'competitors.user_id')
                    ->where('round_id', '=', $round_id)
                    ->get();
            //dd($users);
            return View::make('Competitors.index')->with([
                'competition' => $competition,
                'round' => $round[0],
                'users' => $users
            ]);
        }
        return redirect('/competitions/' . $competition_id . "/rounds");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Competitor $competitor)
    {
        //
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
    public function destroy(Competitor $competitor)
    {
        //
    }
}
