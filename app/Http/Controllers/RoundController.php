<?php

namespace App\Http\Controllers;

use App\Models\Round;
use App\Models\Competition;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoundRequest;
use View;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($competition_id)
    {
        $competition = Competition::find($competition_id);
        
        if(isset($competition)) {
            $rounds = $competition->rounds()->get();
            return View::make('Rounds.index')->with([
                'competition' => $competition,
                'rounds' => $rounds
            ]);
        }
        return redirect('/competitions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($competition_id)
    {
        return redirect("competitions/" . $competition_id . "/rounds");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($competition_id, StoreRoundRequest $request)
    {
        $fields = $request->validated();
        $fields['competition_id'] = $competition_id;
        $fields['round_number'] = strip_tags($fields['round_number']);
        $fields['date'] = strip_tags($fields['date']);
        $round = Round::create($fields);
        return response()->json([$round]);
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
    public function edit(Round $round)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Round $round)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Round $round)
    {
        //
    }
}
