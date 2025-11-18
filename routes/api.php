<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AVCAuthenticationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('avc')->group(function () {
    Route::controller(AVCAuthenticationController::class)->prefix('auth')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
});
