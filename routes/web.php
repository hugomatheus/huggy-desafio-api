<?php

use App\Http\Controllers\HuggyControlller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/auth/huggy/redirect', [HuggyControlller::class, 'redirect']);
Route::get('/auth/huggy/callback', [HuggyControlller::class, 'callback']);

// ngrok http http://localhost:8888
// https://0667-192-140-116-228.ngrok-free.app/huggy/webhooks
Route::post('/huggy/webhooks', [HuggyControlller::class, 'validateWebHooks']);

Route::get('/auth/user', function() {
    return [
        'guards' => array_keys(config('auth.guards')),
        'current_guard' => Auth::getDefaultDriver(),
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
    ];
})->middleware('auth');
