<?php

use App\Http\Controllers\AuthLoginGoogleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google/url', [AuthLoginGoogleController::class, 'getGoogleAuthUtl']);
Route::get('/auth/google/callback', [AuthLoginGoogleController::class, 'getGoogleAuthCallback']); // callback para o retorno do google via front
Route::post('/auth/google/callback', [AuthLoginGoogleController::class, 'getGoogleAuthCallback']); // callback para o retorno do google via back

Route::get('/users', [UserController::class, 'index']);
Route::get('/user', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);

