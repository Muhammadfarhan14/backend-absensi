<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\PembimbingLapanganController;
use App\Http\Controllers\TabelController;

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
})->name('login.web');
Route::post('/', [AuthController::class,'login'])->name('login');

Route::get('tabel-kegiatan',[TabelController::class,'tabel_kegiatan']);
Route::get('tabel-kendala',[TabelController::class,'tabel_kendala']);
Route::get('tabel-kegiatan-pdf',[TabelController::class,'kegiantanPDF']);
Route::get('tabel-kendala-pdf',[TabelController::class,'kendalaPDF']);


Route::prefix('admin')->middleware('auth')->group( function(){
    Route::get('/dashboard', function () {
        return view('Admin.pages.dashboard.index');
    })->name('dashboard');
    Route::resource('mahasiswa',MahasiswaController::class)->except('create','edit','show');
    Route::resource('pembimbing-lapangan',PembimbingLapanganController::class)->except('create','edit','show');
    Route::resource('dosen-pembimbing',DosenPembimbingController::class)->except('create','edit','show');
    Route::resource('lokasi',LokasiController::class)->except('create','edit','show');
    Route::get('logout',[AuthController::class,'logout_web'])->name('logout.web');

});
