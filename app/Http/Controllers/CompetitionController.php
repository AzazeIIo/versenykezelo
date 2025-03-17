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
        $competitions = Competition::with('rounds')->orderBy('year', 'desc')->get();
        
        return View::make('Competitions.index')->with([
            'competitions' => $competitions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect("competitions");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompetitionRequest $request)
    {
        $fields = $request->validated();
        $fields['name'] = strip_tags($fields['name']);
        $fields['year'] = strip_tags($fields['year']);
        $fields['languages'] = strip_tags($fields['languages']);
        $fields['right_ans'] = strip_tags($fields['right_ans']);
        $fields['wrong_ans'] = strip_tags($fields['wrong_ans']);
        $fields['empty_ans'] = strip_tags($fields['empty_ans']);
        $competition = Competition::create($fields);
        return response()->json([$competition]);
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
