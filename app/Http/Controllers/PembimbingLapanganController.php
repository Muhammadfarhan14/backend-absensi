<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Datang;
use App\Models\Lokasi;
use App\Models\Pulang;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\KriteriaPenilaian;
use App\Models\PembimbingLapangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PembimbingLapanganRequest;

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

            $tanggalHariIni = Carbon::now()->toDateString();
            $mahasiswa = Mahasiswa::with(['datang' => function ($query) use ($tanggalHariIni) {
                $query->whereDate('tanggal', $tanggalHariIni);
            }, 'pulang' => function ($query) use ($tanggalHariIni) {
                $query->whereDate('tanggal', $tanggalHariIni);
            }])
                ->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)
                ->get();
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
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('id_PPL', $request->id_PPL)->first();
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
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('id_PPL', $request->id_PPL)->first();

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
            $mahasiswa = Mahasiswa::with('datang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('id_PPL', $request->id_PPL)->first();
            $today = Carbon::now()->format('Y-m-d');
            $data = Datang::create([
                'mahasiswa_id' => $mahasiswa->id,
                'keterangan' => 'hadir',
                'tanggal' => $today,
            ]);

            return response()->json([
                "message" => "kamu berhasil membuat data datang",
                "data" => $data,
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
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('id_PPL', $request->id_PPL)->first();
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
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('id_PPL', $request->id_PPL)->first();

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
            $mahasiswa = Mahasiswa::with('pulang')->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('id_PPL', $request->id_PPL)->first();
            $tanggalHariIni = Carbon::now()->toDateString();
            $pulang = Pulang::where('mahasiswa_id', $mahasiswa->id)->latest()->first();
            $pulang->update([
                "keterangan" => "hadir"
            ]);

            return response()->json([
                "message" => "kamu berhasil verifikasi data pulang",
                "data" => [
                    Mahasiswa::with(['pulang' => function ($query) use ($tanggalHariIni) {
                        $query->whereDate('tanggal', $tanggalHariIni);
                    }])->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('id_PPL', $request->id_PPL)->first()
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function updateStatus(Request $request)
    {
        $pembimbing_lapangan = PembimbingLapangan::find($request->pembimbingLapanganId);
        $isChecked = $request->input('isChecked');
        $pembimbing_lapangan->keterangan = $isChecked;
        $pembimbing_lapangan->save();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function select_mahasiswa_kriteria_penilaian()
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->where('keterangan', true)->first();
            $mahasiswa = Mahasiswa::with('kriteria_penilaian')
                ->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)
                ->where('keterangan',true)
                ->select('id', 'nama', 'nim', 'gambar', 'lokasi_id')
                ->get();

            foreach ($mahasiswa as $mhs) {
                $lokasi = Lokasi::where('id', $mhs->lokasi_id)->first();
                $mhs->lokasi = $lokasi;

                $mhs->lokasi->makeHidden([
                    'created_at',
                    'updated_at',
                ]);

                $mhs->makeHidden('lokasi_id');
            }

            $mahasiswa->each(function ($mahasiswa) {
                $status = $mahasiswa->kriteria_penilaian ? 1 : 0;
                $mahasiswa->status = $status;
                $mahasiswa->makeHidden('kriteria_penilaian');

                if ($mahasiswa->gambar === null) {
                    $mahasiswa->gambar = ""; // Mengganti nilai null dengan string kosong
                }
            });

            return response()->json([
                "message" => "kamu berhasil mengirim data",
                "data" => $mahasiswa
            ]);
        }

        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function kriteria_penilaian(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('pembimbing_lapangan_id',$pembimbing_lapangan->id)->where('id',$request->id)->first();
            KriteriaPenilaian::create([
                'mahasiswa_id' => $mahasiswa->id,
                'inovasi' => $request->inovasi,
                'kerja_sama' => $request->kerja_sama,
                'disiplin' => $request->disiplin,
                'inisiatif' => $request->inisiatif,
                'kerajinan' => $request->kerajinan,
                'sikap' => $request->sikap,
            ]);

            return response()->json([
                "message" => "kamu berhasil menambahkan kriteria penilaian"
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }
    #end api pembimbing lapangan
}
