<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->controller(AuthenticationController::class)->group(function () {
    Route::prefix('avc')->middleware('avc.key')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::prefix('azanypay')->middleware('azanypay.key')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
});
