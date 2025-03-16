<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::resource('competitions', 'App\Http\Controllers\CompetitionController');
Route::redirect('/', 'competitions');
Route::resource('competitions.rounds', 'App\Http\Controllers\RoundController');
Route::resource('competitions.rounds.competitors', 'App\Http\Controllers\CompetitorController');
