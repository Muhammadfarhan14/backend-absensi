<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PembimbingLapanganController;
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

#Route Login
Route::post('login',[AuthController::class,'login_app'])->name('login.api');
#end login

#Route logout
Route::get('logout',[AuthController::class,'logout'])->middleware('auth:sanctum')->name('logout.api');
#end logout

#me
Route::get('me',[AuthController::class,'me'])->middleware('auth:sanctum')->name('me');
#end me


#mahasiswa
Route::middleware('auth:sanctum')->prefix('mahasiswa')->group(function () {
    Route::get('show', [MahasiswaController::class, 'show'])->name('mahasiswa.show');

    // datang
    Route::prefix('datang')->group(function () {
        Route::post('create', [MahasiswaController::class, 'datang_action'])->name('datang.create');
    });

    // kegiatan
    Route::prefix('kegiatan')->group(function () {
        Route::post('create', [MahasiswaController::class, 'kegiatan'])->name('kegiatan.create');
    });

    // kendala
    Route::prefix('kendala')->group(function () {
        Route::post('create', [MahasiswaController::class, 'kendala_action'])->name('kendala.create');
    });

    // pulang
    Route::prefix('pulang')->group(function () {
        Route::post('create', [MahasiswaController::class, 'pulang_action']);
    });
});
#end mahasiswa

#pembimbing lapangan
Route::middleware('auth:sanctum')->prefix('pembimbing-lapangan')->group(function(){
    Route::get('onboarding',[PembimbingLapanganController::class,'onboarding']);
    // datang
    Route::get('check_presensi_datang',[PembimbingLapanganController::class,'check_presensi_datang']);
    Route::get('check_mahasiswa_datang',[PembimbingLapanganController::class,'check_mahasiswa_datang']);
    Route::post('konfirmasi_presensi_datang',[PembimbingLapanganController::class,'konfirmasi_presensi_datang']);
    // pulang
    Route::get('check_presensi_pulang',[PembimbingLapanganController::class,'check_presensi_pulang']);
    Route::get('check_mahasiswa_pulang',[PembimbingLapanganController::class,'check_mahasiswa_pulang']);
    Route::post('konfirmasi_presensi_pulang',[PembimbingLapanganController::class,'konfirmasi_presensi_pulang']);

});
#end pembimbing lapangan

#dosen pembimbing
Route::middleware('auth:sanctum')->prefix('dosen-pembimbing')->group(function(){
    Route::get('home',[DosenPembimbingController::class,'home']);
    Route::get('detail_lokasi_ppl',[DosenPembimbingController::class,'detail_lokasi_ppl']);
    Route::get('detail_mahasiswa',[DosenPembimbingController::class,'detail_mahasiswa']);
    Route::get('update_kendala',[DosenPembimbingController::class,'update_kendala']);
});
#end dosen pembimbing
