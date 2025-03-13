<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Round;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompetitionRequest;
use View;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitions = Competition::with('rounds')->get()->reverse();
        
        return View::make('Competitions.index')->with([
            'competitions' => $competitions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompetitionRequest $request)
    {
        $fields = $request->validated();
        $fields['name'] = strip_tags($fields['name']);
        $fields['year'] = strip_tags($fields['year']);
        $competition = Competition::create($fields);
        return response()->json([$competition]);
        //return redirect('/home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect("competitions/" . $id . "/rounds");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competition $competition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competition $competition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competition $competition)
    {
        //
    }
}
