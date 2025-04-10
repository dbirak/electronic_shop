<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/auth/register/manager', [AuthController::class, 'registerManager']);
Route::post('/auth/register/moderator', [AuthController::class, 'registerModerator']);
Route::post('/auth/register/seller', [AuthController::class, 'registerSeller']);
Route::post('/auth/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
