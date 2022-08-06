<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\AvatarController;
use App\Http\Controllers\Api\v1\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->prefix('v1')->group(function() {
    Route::post('/auth/create', [AuthController::class, 'create']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function() {
    Route::get('/auth/user', [AuthController::class, 'auth_user']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/user/avatar', [AvatarController::class, 'update']);
    Route::post('/user/profile', [ProfileController::class, 'update']);
});
