<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {
        Route::middleware('auth.key')
            ->controller(AuthenticationController::class)
            ->group(function () {
                Route::post('/register', 'register');
                Route::post('/login', 'login');
                Route::post('/verify-code', 'verifyCode');
                Route::patch('/update-account', 'updateAccount');
                Route::post('/delete-account', 'deleteAccount');
                Route::post('/delete-accounts', 'bulkDeleteAccounts');
            });

        // Run basic command
        Route::controller(GeneralController::class)
            ->group(function () {
                Route::get('/clear-cache', 'clearCache');
                Route::post('/run-migration', 'runMigration');
                Route::post('/seed-run', 'seedRun');
            });
    });
