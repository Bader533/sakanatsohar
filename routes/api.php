<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LivingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RoomController;
// use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'loginPersonal']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

// Route::middleware('auth:user-api')->group(function () {

//living
Route::get('living', [LivingController::class, 'index']);
Route::get('living/{id}', [LivingController::class, 'show']);

//order
Route::get('order', [OrderController::class, 'index']);
Route::get('order/{id}', [OrderController::class, 'show']);
Route::post('order', [OrderController::class, 'store']);

//rooms
Route::get('rooms/{id}', [RoomController::class, 'index']);
//user
Route::get('user', [UserController::class, 'update']);
// });

Route::prefix('auth')->middleware('auth:user-api')->group(function () {
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::get('logout', [AuthController::class, 'logout']);
});
