<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembimbingLapanganRequest;
use App\Models\User;
use App\Models\Datang;
use App\Models\KriteriaPenilaian;
use App\Models\Pulang;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\PembimbingLapangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PembimbingLapanganController extends Controller
{
    public function index()
    {
        $pembimbing_lapangan = User::with('pembimbing_lapangan')->where('roles', 'pembimbing_lapangan')->get();
        return view('Admin.pages.pembimbing-lapangan.index', ['data' => $pembimbing_lapangan]);
    }

    public function store(PembimbingLapanganRequest $request)
    {
        $user = new User();

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->roles = "pembimbing_lapangan";
        $user->save();

        $pembimbing_lapangan = new PembimbingLapangan();
        $pembimbing_lapangan->nama = $user->nama;
        $pembimbing_lapangan->user_id = $user->id;
        $pembimbing_lapangan->save();

        return redirect()->route('pembimbing-lapangan.index');
    }

    public function update(PembimbingLapanganRequest $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password,
        ]);
        $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
        $pembimbing_lapangan->update([
            'nama' => $user->nama,
        ]);

        return redirect()->route('pembimbing-lapangan.index');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
        $pembimbing_lapangan->delete();
        $user->delete();

        return redirect()->route('pembimbing-lapangan.index');
    }

    #api pembimbing lapangan
    public function onboarding()
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with('datang', 'pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->get();

            return response()->json([
                "message" => "kamu berhasil mengirim data mahasiswa",
                "data" => [
                    "mahasiswa" => $mahasiswa,
                ],
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function check_presensi_datang(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first();
            if ($mahasiswa) {
                return response()->json([
                    "message" => "kamu berhasil presensi datang",
                    "data" => $mahasiswa
                ]);
            } else {
                return response()->json([
                    "message" => "nim kamu tidak terdaftar pada pembimbing lapangan ini"
                ]);
            }
        }

        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function check_mahasiswa_datang(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first();

            return response()->json([
                "message" => "kamu berhasil cek data mahasiswa",
                "data" => $mahasiswa
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function konfirmasi_presensi_datang(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with('datang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first();

            $datang = Datang::get();
            $today = Carbon::now()->format('Y-m-d');
            foreach ($datang as $item) {
                if ($item->tanggal == $today && $item->mahasiswa_id == $mahasiswa->id) {
                    return response()->json([
                        "message" => "data datang hari ini sudah ada",
                        "data" => null
                    ]);
                }
            }

            $checkDataPertama = Datang::where('mahasiswa_id',$mahasiswa->id)->first();
            if ($checkDataPertama == null) {
                Datang::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'hari_pertama' => true
                ]);
            }else{
                Datang::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'hari_pertama' => false
                ]);
            }

            return response()->json([
                "message" => "kamu berhasil membuat data datang",
                "data" => [
                    Mahasiswa::with('datang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first()
                ],
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function check_presensi_pulang(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first();
            if ($mahasiswa) {
                return response()->json([
                    "message" => "kamu berhasil presensi pulang",
                    "data" => $mahasiswa
                ]);
            } else {
                return response()->json([
                    "message" => "nim kamu tidak terdaftar pada pembimbing lapangan ini"
                ]);
            }
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function check_mahasiswa_pulang(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first();

            return response()->json([
                "message" => "kamu berhasil mengirim data mahasiswa",
                "data" => $mahasiswa
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function konfirmasi_presensi_pulang(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with('pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first();
            $pulang = Pulang::where('mahasiswa_id', $mahasiswa->id)->latest()->first();
            $pulang->update([
                "keterangan" => "hadir"
            ]);

            return response()->json([
                "message" => "kamu berhasil verifikasi data pulang",
                "data" => [
                    Mahasiswa::with('pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first()
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function check_hari_ke_45()
    {
        $user = Auth::user();
        if($user->roles == 'pembimbing_lapangan'){
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id',$pembimbing_lapangan->id)->first();

            $hariPertamaDatang = Datang::where('mahasiswa_id',$mahasiswa->id)->where('hari_pertama', true)->first();
            if($hariPertamaDatang){
            $tanggalHariPertamaDatang = Carbon::parse($hariPertamaDatang->tanggal);
            $hariTerakhirDatang = $tanggalHariPertamaDatang->addRealDays(44);
            }

            $hariPertamaPulang = Pulang::where('mahasiswa_id',$mahasiswa->id)->where('hari_pertama',true)->first();
            if($hariPertamaPulang){
                $tanggalHariPertamaPulang = Carbon::parse($hariPertamaPulang->tanggal);
                $hariTerakhirPulang = $tanggalHariPertamaPulang->addRealDays(44);
            }

            $today = Carbon::now()->format('Y-m-d');
            if ($hariTerakhirDatang <= $today && $hariTerakhirPulang <= $today){
                $muncul = true;
                return response()->json([
                    "message" => "hari ini sudah hari ke 45",
                    "data" => $muncul
                ]);
            }else{
                $muncul = false;
                return response()->json([
                    "message" => "hari ini belum mencapai hari ke 45",
                    "data" => $muncul
                ]);
            }

        }
    }
    #end api pembimbing lapangan
}
