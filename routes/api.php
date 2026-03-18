<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BunnyController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/bunnies', [BunnyController::class, 'index']);
Route::post('/bunnies', [BunnyController::class, 'store']);
Route::get('/bunnies/{bunny}', [BunnyController::class, 'show']);
Route::delete('/bunnies/{bunny}', [BunnyController::class, 'destroy']);
Route::put('/bunnies/{bunny}', [BunnyController::class, 'update']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);