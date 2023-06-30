<?php

namespace App\Http\Controllers;

use App\Http\Requests\DosenPembimbingRequest;
use App\Http\Requests\UpdateDosenPembimbingRequest;
use App\Models\Kegiatan;
use App\Models\Kendala;
use App\Models\User;
use App\Models\Datang;
use App\Models\Lokasi;
use App\Models\Pulang;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DosenPembimbing;
use App\Models\PembimbingLapangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DosenPembimbingController extends Controller
{
    public function index()
    {
        $dosen_pembimbing = User::with('dosen_pembimbing')->where('roles', 'dosen_pembimbing')->get();
        return view('Admin.pages.dosen-pembimbing.index', ['data' => $dosen_pembimbing]);
    }

    public function store(DosenPembimbingRequest $request)
    {
        $user = new User();

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->roles = "dosen_pembimbing";
        $user->save();

        $foto = $request->file('gambar');
        $destinationPath = 'images/';
        $baseURL = url('/');
        $profileImage = $baseURL . '/images/' . Str::slug($request->nama) . '-' . Carbon::now()->format('YmdHis')  . "." . $foto->getClientOriginalExtension();
        $foto->move($destinationPath, $profileImage);

        $dosen_pembimbing = new DosenPembimbing();
        $dosen_pembimbing->nama = $user->nama;
        $dosen_pembimbing->user_id = $user->id;
        $dosen_pembimbing->gambar = $profileImage;
        $dosen_pembimbing->save();

        return redirect()->route('dosen-pembimbing.index');
    }

    public function update(UpdateDosenPembimbingRequest $request, $id)
    {
        $user = User::where('id', $id)->first();
        $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();

        if ($request->gambar) {
            $baseURL = url('/');
            $file_path = Str::replace($baseURL . '/images/', '', public_path() . '/images/' . $dosen_pembimbing->gambar);
            unlink($file_path);

            $foto = $request->file('gambar');
            $destinationPath = 'images/';
            $profileImage = $baseURL . '/images/' . Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $profileImage);

            $user->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => $request->password,
            ]);

            $dosen_pembimbing->update([
                'nama' => $user->nama,
                'gambar' => $profileImage
            ]);
        } else {
            $user->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => $request->password,
            ]);
            $dosen_pembimbing->update([
                'nama' => $user->nama,
            ]);
        }
        return redirect()->route('dosen-pembimbing.index');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
        $baseURL = url('/');
        $file_path = Str::replace($baseURL . '/images/', '', public_path() . '/images/' . $dosen_pembimbing->gambar);
        unlink($file_path);
        $dosen_pembimbing->delete();
        $user->delete();

        return redirect()->route('dosen-pembimbing.index');
    }


    #api dosen pembimbing
    public function home_lokasi_ppl()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->get();

            $lokasi_tampil = array(); // Array untuk menyimpan lokasi yang telah ditampilkan
            $pembimbing_lapangan_tampil = array(); // Array untuk menyimpan lokasi yang telah ditampilkan

            foreach ($mahasiswa as $key => $value) {
                $lokasi = Lokasi::where('id', $value->lokasi_id)->first();
                $pembimbing_lapangan = PembimbingLapangan::where('id', $value->pembimbing_lapangan_id)->first();

                // persentasi kehadiran
                $jumlahMahasiswaPadaLokasiPPL = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->where('lokasi_id', $lokasi->id)->get();
                $mahasiswaDatang = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->where('pembimbing_lapangan_id', $pembimbing_lapangan->id)->where('lokasi_id', $lokasi->id)
                    ->whereHas('datang', function ($query) {
                        $today = Carbon::now()->format('Y-m-d');
                        $query->where('keterangan', 'hadir')->where('tanggal', $today);
                    })->get();
                if ($mahasiswaDatang != null) {
                    $persentasiKehadiran = ($mahasiswaDatang->count() / $jumlahMahasiswaPadaLokasiPPL->count()) * 100;
                } else {
                    $persentasiKehadiran = 0;
                }

                // Periksa apakah lokasi sudah ditampilkan sebelumnya
                if (!in_array($lokasi->nama, $lokasi_tampil) || !in_array($pembimbing_lapangan->nama, $pembimbing_lapangan_tampil)) {
                    $lokasi_ppl[] = [
                        'id' => $lokasi->id,
                        'nama' => $lokasi->nama,
                        'gambar' => $lokasi->gambar,
                        'alamat' => $lokasi->alamat,
                        'pembimbing_lapangan' => $pembimbing_lapangan->nama,
                        'dosen_pembimbing' => $dosen_pembimbing->nama,
                        "pesentasi_kehadiran" => $persentasiKehadiran
                    ];
                    $lokasi_tampil[] = $lokasi->nama; // Tambahkan lokasi ke array lokasi_tampil
                    $pembimbing_lapangan_tampil[] = $pembimbing_lapangan->nama; // Tambahkan lokasi ke array lokasi_tampil
                }
            }

            return response()->json([
                "message" => "kamu berhasil mengirim data lokasi PPL",
                "data" => $lokasi_ppl,
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function home_kendala()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->get();
            $today = Carbon::now()->format('Y-m-d');
            $kendala = [];

            foreach ($mahasiswa as $key => $item) {
                $lokasi = Lokasi::where('id', $item->lokasi_id)->select('nama', 'alamat')->first();
                $kendalaData = Kendala::where('mahasiswa_id', $item->id)
                    ->where('tanggal', $today)
                    ->where('status', 0)
                    ->select('id', 'deskripsi', 'status', 'tanggal')
                    ->first();

                // Cek apakah tanggal kendala sama dengan tanggal hari ini
                if ($kendalaData && $kendalaData->tanggal == $today) {
                    $kendala[] = [
                        'nama' => $lokasi->nama,
                        'alamat' => $lokasi->alamat,
                        'kendala' => $kendalaData
                    ];
                }
            }
            return response()->json([
                "message" => "Kamu berhasil mengirim data kendala menurut tanggal hari ini",
                "data" => $kendala
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function detail_lokasi_ppl(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $today = $request->tanggal;
            $lokasi_id = $request->lokasi_id;
            $mahasiswa = Mahasiswa::with(['kegiatan' => function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            }, 'datang' => function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            }, 'pulang' => function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            }])
                ->where('dosen_pembimbing_id', $dosen_pembimbing->id)
                ->where('lokasi_id',$lokasi_id)->get();

            foreach($mahasiswa as $mhs){
                $lokasi = Lokasi::where('id',$mhs->lokasi_id)->first();
            }

            $mahasiswa->makeHidden([
                'user_id',
                'lokasi_id',
                'pembimbing_lapangan_id',
                'dosen_pembimbing_id',
                'created_at',
                'updated_at',
            ]);

            $mahasiswa->each(function ($mahasiswa) {

                $mahasiswa->gambar = $mahasiswa->gambar ?? "";
                $mahasiswa->pdf = $mahasiswa->pdf ?? "";
                $mahasiswa->kegiatan->makeHidden([
                    'tanggal',
                    'hari_pertama',
                    'jam_selesai',
                    'created_at',
                    'updated_at',

                ]);

                $mahasiswa->datang->each(function ($datang) {
                    $datang->tanggal = $datang->tanggal ?? "";
                    $datang->hari_pertama = $datang->hari_pertama ?? "";
                    $datang->keterangan = $datang->keterangan ?? "";
                    $datang->gambar = $datang->gambar ?? "";
                    $datang->jam_datang = $datang->created_at ? $datang->created_at->format('H:i') : "";
                    $datang->updated_at = $datang->updated_at ?? "";
                });
                $mahasiswa->datang->makeHidden([
                    'hari_pertama',
                    'created_at',
                    'updated_at',
                ]);

                $mahasiswa->pulang->each(function ($pulang) {
                    $pulang->tanggal = $pulang->tanggal ?? "";
                    $pulang->hari_pertama = $pulang->hari_pertama ?? "";
                    $pulang->keterangan = $pulang->keterangan ?? "";
                    $pulang->gambar = $pulang->gambar ?? "";
                    $pulang->jam_pulang = $pulang->created_at ? $pulang->created_at->format('H:i') : "";
                    $pulang->updated_at = $pulang->updated_at ?? "";
                });
                $mahasiswa->pulang->makeHidden([
                    'tanggal',
                    'hari_pertama',
                    'created_at',
                    'updated_at',
                ]);
            });

            return response()->json([
                "message" => "kamu berhasil mengirim data mahasiswa",
                "data" => $mahasiswa
            ]);
        }

        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function update_kendala($id)
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            Mahasiswa::with('kendala')->where('dosen_pembimbing_id', $dosen_pembimbing->id)->first();
            $kendala = Kendala::where('id', $id)->where('status', false)->select('id', 'deskripsi', 'status', 'tanggal')->first();

            if ($kendala) {
                $kendala->update([
                    'status' => true
                ]);

                return response()->json([
                    "message" => "kamu memperbarui data kendala",
                ]);
            } else {
                return response()->json([
                    "message" => "Kendala dengan ID ini sudah terupdate",
                ], 404);
            }
        }
    }

    public function check_hari_ke_45()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with(['pulang' => function ($query) {
                $query->where('hari_pertama', true);
            }])->where('dosen_pembimbing_id', $dosen_pembimbing->id)->get();

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
    }

    #end dosen pembimbing

}
