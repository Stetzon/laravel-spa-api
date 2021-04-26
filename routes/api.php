<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/auth', fn() => ['data' => Auth::check()])->name('auth.check');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', fn(Request $request) => ['data' => $request->user()])->name('user.show');
});
