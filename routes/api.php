<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GeneralController;

Route::prefix('auth')
    ->group(function () {
        Route::middleware('auth.key')
            ->controller(AuthenticationController::class)
            ->group(function () {
                Route::post('/register', 'register');
                Route::post('/login', 'login');
                Route::post('/verify-code', 'verifyCode');
                Route::patch('/update-account', 'updateAccount');
                Route::delete('/delete-account', 'deleteUserAccount');
            });

        // Run basic command
        Route::controller(GeneralController::class)
            ->group(function () {
                Route::get('/clear-cache', 'clearCache');
                Route::post('/run-migration', 'runMigration');
                Route::post('/seed-run', 'seedRun');
            });
    });
