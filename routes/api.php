<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/active-polls', function () {
    return DB::table('polls')->where('status', 'active')->get();
});

Route::get('/poll-options/{id}', function ($id) {
    return DB::table('poll_options')->where('poll_id', $id)->get();
});

Route::get('/poll-results/{id}', function ($id) {
    return DB::table('votes')
        ->select('option_id', DB::raw('count(*) as total'))
        ->where('poll_id', $id)
        ->groupBy('option_id')
        ->get();
});
