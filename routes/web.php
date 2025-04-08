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
// http://127.0.0.1:4040
// https://0667-192-140-116-228.ngrok-free.app/huggy/webhooks
Route::post('/huggy/webhooks', [HuggyControlller::class, 'webhooks']);

