<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenandatanganController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/pandatangan/store', [PenandatanganController::class, 'store'])->name('penantangan.store');

Route::get('/perusahaan', [HomeController::class, 'perusahaan'])->name('perusahaan');
Route::post('/perusahaan/store', [HomeController::class, 'store'])->name('perusahaan.store');