<?php

use App\Http\Controllers\DosenPembimbingLapanganController;
use App\Http\Controllers\MahasiswaController;
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

Route::get('/', function () {
    return view('Login.login');
});


Route::prefix('admin')->group( function(){
    Route::get('/dashboard', function () {
        return view('Admin.pages.dashboard.index');
    })->name('dashboard');
    Route::resource('mahasiswa',MahasiswaController::class)->except('create','edit','show');
    Route::resource('dosen-pembimbing-lapangan',DosenPembimbingLapanganController::class)->except('create','edit','show');
});
