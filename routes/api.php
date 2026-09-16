<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\AdminControllerApi;

Route::group(['prefix' => 'auth'], function ()
{
    Route::post('login', [AuthController::class, 'login']); 
    
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });
});

Route::get('/admin', AdminControllerApi::class)
    ->middleware(['auth:api', 'role:Admin']);

