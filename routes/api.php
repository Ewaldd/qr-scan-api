<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrScanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::apiResource('qr-scan', QrScanController::class, ['middleware' => 'auth:sanctum']);
