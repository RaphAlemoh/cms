<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)
    ->group(function () {
        Route::post('/login', 'login');
        Route::post('/user', 'user');
    });

Route::resource('countries', CountryController::class);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(UserController::class)
        ->group(function () {
            Route::post('/logout', 'logout');
            Route::get('/user', 'user');
        });
    Route::resource('companies', CompanyController::class);
    Route::resource('services', ServiceController::class);
});
