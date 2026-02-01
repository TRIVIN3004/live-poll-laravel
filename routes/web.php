<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\AdminController;

Route::get('/', [PollController::class, 'index']);
Route::get('/poll/{id}', [PollController::class, 'show']);
Route::post('/vote', [PollController::class, 'vote']);

Route::get('/admin/poll/{id}', [AdminController::class, 'showPoll']);
Route::post('/admin/release-ip', [AdminController::class, 'releaseIp']);
