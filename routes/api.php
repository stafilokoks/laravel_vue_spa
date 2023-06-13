<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CountriesController;
use App\Http\Controllers\API\AuthController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::apiResource('countries', CountriesController::class)->middleware('auth:sanctum');
