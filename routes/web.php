<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BunnyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', [BunnyController::class, 'showPage']);
Route::get('/bunnies/{id}', [BunnyController::class, 'showBunny']);
