<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['post', 'get'], '/', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::match(['post', 'get'], '/register', [\App\Http\Controllers\RegisterController::class, 'register'])->name('register');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['prefix' => 'gejala'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\GejalaController::class, 'index'])->name('admin.gejala');
    });
});
