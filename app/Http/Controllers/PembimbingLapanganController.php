<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Datang;
use App\Models\Lokasi;
use App\Models\Pulang;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\PembimbingLapangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PembimbingLapanganController extends Controller
{
    public function index()
    {
        $pembimbing_lapangan = User::with('pembimbing_lapangan')->where('roles', 'pembimbing_lapangan')->get();
        return view('Admin.pages.pembimbing-lapangan.index', ['data' => $pembimbing_lapangan]);
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
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
            $pembimbing_lapangan = PembimbingLapangan::where('user_id',$user->id)->first();
            $mahasiswa = Mahasiswa::with('datang','pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->get();
            $mhs = Mahasiswa::with('datang','pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->first();

            return response()->json([
                "message" => "kamu berhasil mengirim data mahasiswa",
                "data" =>[
                   "mahasiswa" => $mahasiswa,
                ],
                [
                    "lokasi" =>  $mhs->lokasi,
                ],
                [
                    "pembimbing lapangan" =>  $mhs->pembimbing_lapangan->nama,
                ],
                [
                    "dosen pembimbing" =>   $mhs->dosen_pembimbing->nama,
                ]
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
            $mahasiswa = Mahasiswa::with('datang')->where('nim', $request->nim)->first();
            return response()->json([
                "message" => "kamu berhasil mengirim detail data mahasiswa",
                "data" => $mahasiswa
            ]);
        }

        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);

    }

    public function check_mahasiswa_datang()
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id',$user->id)->first();
            $mahasiswa = Mahasiswa::with('datang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->first();

            return response()->json([
                "message" => "kamu berhasil mengirim data mahasiswa",
                "data" => $mahasiswa
            ]);

        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function konfirmasi_presensi_datang()
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id',$user->id)->first();
            $mahasiswa = Mahasiswa::with('datang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->first();
            $hadir = Datang::where('mahasiswa_id', $mahasiswa->id)->first();
            $hadir->update([
                "keterangan" => "hadir"
            ]);

            return response()->json([
                "message" => "kamu berhasil mengirim data presensi datang",
                "data" => [
                    $mahasiswa
                ]
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
            $mahasiswa = Mahasiswa::with('pulang')->where('nim', $request->nim)->first();
            return response()->json([
                "message" => "kamu berhasil mengirim detail data mahasiswa",
                "data" => $mahasiswa
            ]);
        }

        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function check_mahasiswa_pulang()
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id',$user->id)->first();
            $mahasiswa = Mahasiswa::with('pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->first();

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
            $pembimbing_lapangan = PembimbingLapangan::where('user_id',$user->id)->first();
            $mahasiswa = Mahasiswa::with('pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->first();
            $hadir = Pulang::where('mahasiswa_id', $mahasiswa->id)->first();
            $hadir->update([
                "keterangan" => "hadir"
            ]);

            return response()->json([
                "message" => "kamu berhasil mengirim data presensi pulang",
                "data" => [
                    $mahasiswa
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }
#end api pembimbing lapangan
}
