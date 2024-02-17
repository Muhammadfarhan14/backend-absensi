<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\KomenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PembimbingLapanganController;
use App\Http\Controllers\TabelController;
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

    Route::get('check_hari_ke_45',[MahasiswaController::class,'check_hari_ke_45']);
    Route::get('kegiatanPDF',[TabelController::class,'kegiatanPDF']);

    // datang
    Route::prefix('datang')->group(function () {
        Route::post('create', [MahasiswaController::class, 'datang_action']);
        Route::post('update_gambar', [MahasiswaController::class, 'update_gambar']);
        Route::get('detail_datang_by_tanggal', [MahasiswaController::class, 'detail_datang_by_tanggal']);
    });

    // kegiatan
    Route::prefix('kegiatan')->group(function () {
        Route::post('create', [MahasiswaController::class, 'kegiatan']);
        Route::get('detail_kegiatan_by_tanggal', [MahasiswaController::class, 'detail_kegiatan_by_tanggal']);
    });

    // kendala
    Route::prefix('kendala')->group(function () {
        Route::post('create', [MahasiswaController::class, 'kendala_action'])->name('kendala.create');
        Route::get('detail_kendala_by_tanggal', [MahasiswaController::class, 'detail_kendala_by_tanggal']);
    });

    // pulang
    Route::prefix('pulang')->group(function () {
        Route::post('create', [MahasiswaController::class, 'pulang_action']);
        Route::get('detail_pulang_by_tanggal', [MahasiswaController::class, 'detail_pulang_by_tanggal']);
    });

    // komen
    Route::prefix('komen')->group(function () {
        Route::get('komen_by_tanggal',[KomenController::class,'getByTanggal']);
        Route::post('store', [KomenController::class, 'store']);
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

    // check hari ke 45
    Route::get('check_hari_ke_45',[PembimbingLapanganController::class,'check_hari_ke_45']);

    // select mahasiswa
    Route::get('select_mahasiswa_kriteria_penilaian',[PembimbingLapanganController::class,'select_mahasiswa_kriteria_penilaian']);

    // input kriteria penilaian
    Route::post('kriteria_penilaian',[PembimbingLapanganController::class,'kriteria_penilaian']);

});
#end pembimbing lapangan

#dosen pembimbing
Route::middleware('auth:sanctum')->prefix('dosen-pembimbing')->group(function(){
    Route::get('home_lokasi_ppl',[DosenPembimbingController::class,'home_lokasi_ppl']);
    Route::get('home_kendala',[DosenPembimbingController::class,'home_kendala']);
    Route::get('detail_lokasi_ppl',[DosenPembimbingController::class,'detail_lokasi_ppl']);
    Route::put('update_kendala/{id}',[DosenPembimbingController::class,'update_kendala']);

    Route::prefix('komen')->group(function(){
        Route::post('store', [KomenController::class, 'store']);
    });

    Route::get('home_komen',[DosenPembimbingController::class,'home_komen']);
    Route::get('home_kendala_true',[DosenPembimbingController::class,'home_kendala_true']);
    // check hari ke 45
    // Route::get('check_hari_ke_45',[DosenPembimbingController::class,'check_hari_ke_45']);
    // generate PDF
    Route::get('semuaKegianPDF',[TabelController::class,'semuaKegianPDF']);
});
#end dosen pembimbing
