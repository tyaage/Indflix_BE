<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardAdminController;

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

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
    Route::get('/register', 'indexRegister')->middleware('guest');
    Route::post('/register', 'register');

    Route::get('/akun', 'pengaturan')->name('akun');
    Route::post('/ubah-password', 'ubahPassword')->name('ubah-password-user');
    Route::post('/ubah-profile', 'ubahProfile')->name('ubah-profile-user');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::controller(AuthController::class)->group(function () {
        Route::get('/pengaturan', 'pengaturanAdmin')->name('admin.pengaturan');
        Route::post('/ubah-password', 'ubahPassword')->name('ubah-password-admin');
        Route::post('/ubah-profile', 'ubahProfile')->name('ubah-profile-admin');

        Route::get('/akun', 'pengaturan')->name('akun-admin');
        Route::post('/ubah-password', 'ubahPassword')->name('ubah-password');
        Route::post('/ubah-profile', 'ubahProfile')->name('ubah-profile');
    });

    Route::resource('/movie', MovieController::class);
    Route::resource('/genre', GenreController::class);
});

Route::get('/langganan-vip', [VipController::class, 'index']);
Route::post('/langganan-vip', [VipController::class, 'subscribeVIP'])->name('langganan.vip');

Route::get('/{movie}', [MovieController::class, 'show'])->middleware('auth');
Route::post('/{slug}/like', [MovieController::class, 'like']);
