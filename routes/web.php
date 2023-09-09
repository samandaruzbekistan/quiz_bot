<?php

use App\Http\Controllers\AdminController;
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
Route::prefix('bot')->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::post('/auth', [AdminController::class, 'auth'])->name('bot_auth');


    Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
        Route::get('/home', [AdminController::class, 'home'])->name('home');
        Route::post('/add-block', [AdminController::class, 'add'])->name('add');
        Route::get('/export/{id?}', [AdminController::class, 'export'])->name('export');
    });
});

