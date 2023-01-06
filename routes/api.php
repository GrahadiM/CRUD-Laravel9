<?php

use Illuminate\Http\Request;
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

Route::middleware(['cors', 'json.response', 'auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [App\Http\Controllers\Auth\ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register',[App\Http\Controllers\Auth\ApiAuthController::class, 'register'])->name('register.api');
    Route::post('/logout', [App\Http\Controllers\Auth\ApiAuthController::class, 'logout'])->name('logout.api');
});

Route::apiResource('/users', App\Http\Controllers\Api\UserController::class);
