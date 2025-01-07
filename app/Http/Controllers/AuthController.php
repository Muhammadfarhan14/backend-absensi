<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AuthToken;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\DosenPembimbing;
use App\Models\PembimbingLapangan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $token = AuthToken::where('tanggal', $today)->where('name', '!=', 'admin')->get();
        return view('Admin.pages.authentication.index', compact('token'));
    }

    public function destroy($id)
    {
        $token = AuthToken::find($id);
        $token->delete();

        return redirect()->back();
    }

    #logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Token Berhasil Dihapus"
        ]);
    }

    public function logout_web()
    {
        $user = Auth::user();
        $token = AuthToken::where('name', $user->username)->get();
        foreach ($token as $item) {
            $item->delete();
        }

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
                    "id_PPL" => $mahasiswa->id_PPL,
                    "nama" => $mahasiswa->nama,
                    "nim" => $mahasiswa->nim,
                    "gambar" => $mahasiswa->gambar,
                    "roles" => $user->roles,
                    "keterangan" => $mahasiswa->keterangan,
                    "dosen_pembimbing" => $mahasiswa->dosen_pembimbing->nama,
                    "pembimbing_lapangan" => $mahasiswa->pembimbing_lapangan->nama,
                    "lokasi" => $mahasiswa->lokasi->nama,
                ],
            ]);
        }

        if ($user->roles == 'pembimbing_lapangan') {
            $mhs = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->get();
            Log::debug($mhs);
            foreach ($mhs as $item) {
                $item->lokasi;

                return response()->json([
                    "message" => "data user yang login",
                    "data" => [
                        "nama_pembimbing_lapangan" => $pembimbing_lapangan->nama,
                        "keterangan_pembimbing_lapangan" => $pembimbing_lapangan->keterangan,
                        "nama_dosen_pembimbing" => $item->dosen_pembimbing->nama,
                        "roles" => $user->roles,
                        "lokasi" => $item->lokasi
                    ],
                ]);
            }
        }

        if ($user->roles == 'dosen_pembimbing') {
            return response()->json([
                "message" => "data user yang login",
                "data" => [
                    "nama" => $dosen_pembimbing->nama,
                    "gambar" => $dosen_pembimbing->gambar,
                    "roles" => $user->roles,
                ],
            ]);
        }
    }
}
