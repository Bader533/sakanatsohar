<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LivingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaitingController;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/rooms', function () {
    return new VerifyEmail();
});

Route::middleware('guest:admin')->group(function () {
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('dashboard.login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('', [Controller::class, 'total'])->name('total');
    Route::prefix('dashboard')->group(function () {
        Route::resource('living', LivingController::class);
        Route::resource('room', RoomController::class);
        Route::resource('user', UserController::class);
        Route::get('admin/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('admin/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::resource('order', OrderController::class);
        Route::get('rooms/{id}', [Controller::class, 'getRoom'])->name('getlivingroom');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
