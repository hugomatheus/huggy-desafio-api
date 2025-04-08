<?php

use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('contacts/charts', [ContactController::class, 'charts']);
    Route::apiResource('contacts', ContactController::class);
});
