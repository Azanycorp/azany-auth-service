<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

use App\Http\Controllers\B2CController;
use App\Http\Controllers\GeneralController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')
    ->group(function () {
        Route::controller(AuthenticationController::class)
            ->group(function () {

                Route::prefix('avc')->middleware('avc.key')->group(function () {
                    Route::post('/register', 'register');
                    Route::post('/login', 'login');
                });

                Route::prefix('azanypay')->middleware('azanypay.key')->group(function () {
                    Route::post('/register', 'register');
                    Route::post('/login', 'login');
                });
            });

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
