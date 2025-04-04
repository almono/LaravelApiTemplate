<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function () {
    Route::middleware('guest')->group(function () {        
        Route::post('login', [AuthController::class, 'login'])->name('login');

        Route::get('/user', function (Request $request) {
            return response()->json([
                'user' => $request->user(),
                'token' => $request->bearerToken()
            ]);
            //return $request->user();
        })->middleware('auth:sanctum');
    });

    Route::post('register', [AuthController::class, 'register']);
    Route::post('/email/verify', [VerificationController::class, 'verify']);
    Route::post('/email/resend', [VerificationController::class, 'resend']);

    Route::group(['middleware' => 'auth:sanctum', 'verified'], function() {
    // Since I needed to exclude some endpoints I had to split apiResource
    //Route::apiResource('users', UserController::class); 

        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});