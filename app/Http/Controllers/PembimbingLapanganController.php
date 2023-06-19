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
            $tanggalHariIni = Carbon::now()->toDateString();
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

            $checkDataPertama = Datang::where('mahasiswa_id', $mahasiswa->id)->first();
            if ($checkDataPertama == null) {
                Datang::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'hari_pertama' => true,
                    'tanggal' => $today
                ]);
            } else {
                Datang::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'hari_pertama' => false,
                    'tanggal' => $today
                ]);
            }

            return response()->json([
                "message" => "kamu berhasil membuat data datang",
                "data" => [
                    Mahasiswa::with(['datang' => function ($query) use ($tanggalHariIni) {
                        $query->whereDate('tanggal', $tanggalHariIni);
                    }])->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first()
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
                    }])->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('nim', $request->nim)->first()
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
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with(['pulang' => function ($query) {
                $query->where('hari_pertama', true);
            }])->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->get();

            $mahasiswa->makeHidden([
                'user_id',
                'lokasi_id',
                'gambar',
                'pembimbing_lapangan_id',
                'dosen_pembimbing_id',
                'created_at',
                'updated_at',
            ]);

            foreach ($mahasiswa as $mhs) {
                $jumlahMahasiswa = $mhs->count();
                foreach ($mhs->pulang as $pulang) {
                    $tanggalHariPertama = Carbon::parse($pulang->tanggal);
                    $tanggal45HariKedepan = $tanggalHariPertama->addDays(45)->format('Y-m-d');
                    $pulang->tanggal_hari_pertama = $pulang->tanggal;
                    $pulang->tanggal_45_hari_kedepan = $tanggal45HariKedepan;

                    $pulang->makeHidden([
                        'id',
                        'mahasiswa_id',
                        'gambar',
                        'keterangan',
                        'tanggal',
                        'hari_pertama',
                        'created_at',
                        'updated_at',
                    ]);

                    $today = Carbon::now()->format('Y-m-d');
                    $pulang->check45Hari = false;
                    $checkHadirPadaHariKe45 = $pulang->where('tanggal', 'LIKE', '%' . $tanggal45HariKedepan . '%')->where('keterangan', 'hadir')->count();
                    if ($checkHadirPadaHariKe45 == $jumlahMahasiswa && $today == $pulang->tanggal_45_hari_kedepan) {
                        $pulang->check45Hari = true;
                    } else
                    if ($today > $pulang->tanggal_45_hari_kedepan) {
                        $pulang->check45Hari = true;
                    }
                }
            }
            return response()->json([
                "message" => "hari ini adalah hari ke 45",
                "data" => $pulang
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function select_mahasiswa_kriteria_penilaian()
    {
        $user = Auth::user();
        if ($user->roles == 'pembimbing_lapangan') {
            $pembimbing_lapangan = PembimbingLapangan::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with('kriteria_penilaian')
                ->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)
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
