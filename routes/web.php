<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::resource('competitions', 'App\Http\Controllers\CompetitionController');
Route::resource('/', 'App\Http\Controllers\CompetitionController');
Route::resource('competitions.rounds', 'App\Http\Controllers\RoundController');
