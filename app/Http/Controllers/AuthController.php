<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DosenPembimbing;
use App\Models\PembimbingLapangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    #logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Token Berhasil Dihapus"
        ]);
    }

    public function logout_web(Request $request)
    {
        $request->session()->flush();
        Auth::user()->tokens()->delete();
        Auth::logout();
        return redirect()->route('login.web');
    }
    #endlogout

    #auth admin web
    public function login(Request $request)
    {
        $krendensil = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        $user->createToken($user->username)->plainTextToken;
        Auth::attempt($krendensil);
        Auth::user();
        return redirect()->route('dashboard');
    }
    #end auth admin web


    #auth app SiMor
    public function login_app(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Kredensial yang diberikan salah'],
            ]);
        }

        return $user->createToken($user->username)->plainTextToken;
    }
    #end auth app SiMor

    public function me()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
        $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
        if ($user->roles == 'mahasiswa') {
            return response()->json([
                "message" => "data user yang login",
                "data" => [
                    "nama" => $mahasiswa->nama,
                    "nim" => $mahasiswa->nim,
                    "gambar" => $mahasiswa->gambar,
                    "roles" => $user->roles,
                    "dosen_pembimbing" => $mahasiswa->dosen_pembimbing->nama,
                    "pembimbing_lapangan" => $mahasiswa->pembimbing_lapangan->nama,
                    "lokasi" => $mahasiswa->lokasi->nama,
                    "datang" => $mahasiswa->datang,
                    "pulang" => $mahasiswa->pulang,
                    "kegiatan" => $mahasiswa->kegiatan,
                    "kendala" => $mahasiswa->kendala
                ],
            ]);
        }

        if ($user->roles == 'pembimbing_lapangan') {
            return response()->json([
                "message" => "data user yang login",
                "data" => [
                    "nama" => $pembimbing_lapangan->nama,
                    "roles" => $user->roles,
                ],
            ]);
        }

        if ($user->roles == 'dosen_pembimbing') {
            return response()->json([
                "message" => "data user yang login",
                "data" => [
                    "nama" => $dosen_pembimbing->nama,
                    "roles" => $user->roles,
                ],
            ]);
        }

    }
}
