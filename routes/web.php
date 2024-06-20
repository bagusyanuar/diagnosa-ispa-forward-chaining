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

Route::match(['post', 'get'], '/example', [\App\Http\Controllers\ExampleController::class, 'index'])->name('example');
Route::match(['post', 'get'], '/', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::match(['post', 'get'], '/register', [\App\Http\Controllers\RegisterController::class, 'register'])->name('register');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['prefix' => 'gejala'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\GejalaController::class, 'index'])->name('admin.gejala');
        Route::match(['post', 'get'],'/add', [\App\Http\Controllers\Admin\GejalaController::class, 'add'])->name('admin.gejala.add');
        Route::match(['post', 'get'],'/{id}/edit', [\App\Http\Controllers\Admin\GejalaController::class, 'edit'])->name('admin.gejala.edit');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\GejalaController::class, 'delete'])->name('admin.gejala.delete');
    });

    Route::group(['prefix' => 'penyakit'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\PenyakitController::class, 'index'])->name('admin.penyakit');
        Route::match(['post', 'get'],'/add', [\App\Http\Controllers\Admin\PenyakitController::class, 'add'])->name('admin.penyakit.add');
        Route::match(['post', 'get'],'/{id}/edit', [\App\Http\Controllers\Admin\PenyakitController::class, 'edit'])->name('admin.penyakit.edit');
        Route::post('/{id}/delete', [\App\Http\Controllers\Admin\PenyakitController::class, 'delete'])->name('admin.penyakit.delete');
    });

    Route::group(['prefix' => 'aturan-diagnosa'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\AturanController::class, 'index'])->name('admin.aturan');
        Route::match(['post', 'get'],'/{id}', [\App\Http\Controllers\Admin\AturanController::class, 'setRule'])->name('admin.aturan.edit');
    });
});

Route::group(['prefix' => 'pasien'], function () {

    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Pasien\KonsultasiController::class, 'index'])->name('pasien.konsultasi');

});
