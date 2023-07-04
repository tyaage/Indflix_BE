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

Route::get('/', [DashboardController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/ubah-password', [AuthController::class, 'ubahPassword']);

// Route::prefix('admin')->group(function () {
//     Route::resource('/movie', MovieController::class);
//     Route::resource('/genre', GenreController::class);
// });
Route::get('/{movie}', [MovieController::class, 'show'])->middleware('auth');


Route::post('/ubah-password', [AuthController::class, 'ubahPassword']);

Route::post('/ubah-password', [AuthController::class, 'ubahPassword']);



