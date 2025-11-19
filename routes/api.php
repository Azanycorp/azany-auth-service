<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\B2CController;
use App\Http\Controllers\GeneralController;


Route::prefix('auth')
    ->group(function () {
        // Run basic command
        Route::controller(GeneralController::class)
            ->group(function () {
                Route::get('/clear-cache', 'clearCache');
                Route::post('/run-migration', 'runMigration');
                Route::post('/seed-run', 'seedRun');
            });
        
        // ShopAzany APIs here
        Route::prefix('shopazany')
            ->controller(B2CController::class)
            ->group(function () {
                Route::prefix('b2c')
                    ->group(function () {
                        Route::post('/customer/signup', 'customerSignUp');
                    });
            });
    });
