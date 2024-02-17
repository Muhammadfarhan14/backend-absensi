<?php

namespace App\Http\Controllers;

use App\Http\Requests\MahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\User;
use App\Models\Datang;
use App\Models\Lokasi;
use App\Models\Pulang;
use App\Models\Kendala;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DosenPembimbing;
use App\Models\PembimbingLapangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;



class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mhs = Mahasiswa::get();
        $lokasi = Lokasi::get();
        $dosen_pembimbing = DosenPembimbing::get();
        $pembimbing_lapangan = PembimbingLapangan::get();
        return view('Admin.pages.mahasiswa.index', ['mhs' => $mhs, 'lokasi' => $lokasi, 'dosen_pembimbing' => $dosen_pembimbing, 'pembimbing_lapangan' => $pembimbing_lapangan]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MahasiswaRequest $request)
    {

        $mhs = new Mahasiswa();
        $mhs->nama = $request->nama;
        $mhs->nim = $request->nim;
        $mhs->id_PPL = mt_rand(10000, 99999);
        $mhs->lokasi_id = $request->lokasi_id;
        $mhs->dosen_pembimbing_id = $request->dosen_pembimbing_id;
        $mhs->pembimbing_lapangan_id = $request->pembimbing_lapangan_id;

        $foto = $request->file('gambar');
        $destinationPath = 'images/';
        $baseURL = url('/');
        $profileImage = $baseURL . "/images/" . Str::slug($request->nama) . '-' . Carbon::now()->format('YmdHis') . "." . $foto->getClientOriginalExtension();
        $foto->move($destinationPath, $profileImage);
        $mhs->gambar = $profileImage;
        $mhs->save();

        $user = new User();
        $user->username = $mhs->nim;
        $user->nama = $mhs->nama;
        $user->password = Hash::make($request->password);
        $user->roles = "mahasiswa";
        $user->save();

        $mhs->user_id = $user->id;
        $mhs->save();

        return redirect()->route('mahasiswa.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMahasiswaRequest $request, $id)
    {
        $mhs = Mahasiswa::where('id', $id)->first();
        $user = User::where('id', $mhs->user_id)->where('roles', 'mahasiswa')->first();

        if ($request->gambar) {
            $baseURL = url('/');
            $file_path = Str::replace($baseURL . '/images/', '', public_path() . '/images/' . $mhs->gambar);
            unlink($file_path);

            $foto = $request->file('gambar');
            $destinationPath = 'images/';
            $profileImage = $baseURL . "/images/" . Str::slug($request->nama) . '-' . Carbon::now()->format('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $profileImage);

            $mhs->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'lokasi_id' => $request->lokasi_id,
                'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                'pembimbing_lapangan_id' => $request->pembimbing_lapangan_id,
                'gambar' => $profileImage,
            ]);
            $user->update([
                'nama' => $mhs->nama,
                'username' => $mhs->nim,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $mhs->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'lokasi_id' => $request->lokasi_id,
                'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                'pembimbing_lapangan_id' => $request->pembimbing_lapangan_id,
            ]);
            $user->update([
                'nama' => $mhs->nama,
                'username' => $mhs->nim,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mhs = Mahasiswa::where('id', $id)->first();
        $user = User::where('id', $mhs->user_id)->first();
        $baseURL = url('/');
        $file_path = Str::replace($baseURL . '/images/', '', public_path() . '/images/' . $mhs->gambar);
        unlink($file_path);
        $mhs->delete();
        $user->delete();
        return redirect()->route('mahasiswa.index');
    }

    ##api##

    // datang
    // public function datang_action(Request $request)
    // {
    //     $user = Auth::user();
    //     if ($user->roles == 'mahasiswa') {

    //         $this->validate($request, [
    //             'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //         ]);

    //         $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
    //         $datang = Datang::where('mahasiswa_id', $mahasiswa->id)->latest()->first();
    //         if ($request->gambar) {
    //             $foto = $request->file('gambar');
    //             $destinationPath = 'images/';
    //             $baseURL = url('/');
    //             $profileImage = $baseURL . '/images/' . Str::slug($mahasiswa->nama) . "-datang" . '-' . Carbon::now()->format('YmdHis') . "." . $foto->getClientOriginalExtension();
    //             $foto->move($destinationPath, $profileImage);

    //             $datang->update([
    //                 "keterangan" => "hadir",
    //                 'gambar' => $profileImage
    //             ]);
    //         }

    //         return response()->json([
    //             "messagge" => "kamu berhasil tambah gambar datang",
    //             "data" => [
    //                 Datang::where('mahasiswa_id', $mahasiswa->id)->latest()->first()
    //             ]
    //         ]);
    //     }
    //     return response()->json([
    //         "message" => "kamu gagal mengirim data"
    //     ]);
    // }

    public function update_gambar(Request $request)
    {
        $user = Auth::user();

        if ($user->roles == 'mahasiswa') {


            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

            if ($request->hasFile('gambar')) {
                $foto = $request->file('gambar');
                $destinationPath = 'images/';
                $baseURL = url('/');
                $profileImage = $baseURL . '/images/' . Str::slug($mahasiswa->nama) . "-datang" . '-' . Carbon::now()->format('YmdHis') . "." . $foto->getClientOriginalExtension();
                $foto->move($destinationPath, $profileImage);
                $datang = Datang::where('mahasiswa_id',$mahasiswa->id)->latest()->first();
                $datang->update([
                    'gambar' => $profileImage
                ]);
                return response()->json([
                    "message" => "Kamu berhasil menambahkan gambar datang",
                    "data" => $datang
                ]);
            }else{
                return response()->json([
                    "message" => "File gambar tidak ditemukan."
                ]);
            }
        }else{
            return response()->json([
                "message" => "ini bukan akun mahasiswa"
            ]);
        }
    }

    public function detail_datang_by_tanggal()
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $today = Carbon::now()->format('Y-m-d');
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $datang = Datang::where('mahasiswa_id', $mahasiswa->id)->where('tanggal', $today)->latest()->first();

            $datang->each(function ($datang) {
                if ($datang->gambar === null) {
                    $datang->gambar = ""; // Mengganti nilai null dengan string kosong
                }
            });

            return response()->json([
                "message" => "kamu berhasil mengambil data datang hari ini",
                "data" => [
                    $datang
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    // kendala
    public function kendala_action(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $kendala = Kendala::get();
            $today = Carbon::now()->format('Y-m-d');
            foreach ($kendala as $item) {
                if ($item->tanggal == $today && $item->mahasiswa_id == $mahasiswa->id) {
                    return response()->json([
                        "message" => "data kendala hari ini sudah ada",
                        "data" => ""
                    ]);
                }
            }

            Kendala::create([
                'deskripsi' => $request->deskripsi,
                'tanggal' => $today,
                'mahasiswa_id' => $mahasiswa->id
            ]);

            $tanggalHariIni = Carbon::now()->toDateString();
            return response()->json([
                "message" => "kamu berhasil membuat deskripsi kendala",
                "data" => [
                    Kendala::where('mahasiswa_id', $mahasiswa->id)->where('tanggal', $tanggalHariIni)->latest()->first()
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function detail_kendala_by_tanggal()
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $today = Carbon::now()->format('Y-m-d');
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $kendala = Kendala::where('mahasiswa_id', $mahasiswa->id)->where('tanggal', $today)->latest()->first();

            return response()->json([
                "message" => "kamu berhasil mengambil data kendala hari ini",
                "data" => [
                    $kendala
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    // pulang
    public function pulang_action(Request $request)
    {
        $user = Auth::user();

        if ($user->roles == 'mahasiswa') {
            // Validasi gambar
            $this->validate($request, [
                'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

            // Periksa apakah ada file gambar di-upload
            if ($request->hasFile('gambar')) {
                $foto = $request->file('gambar');
                $destinationPath = 'images/';
                $baseURL = url('/');
                $profileImage = $baseURL . '/images/' . Str::slug($mahasiswa->nama) . "-pulang" . '-' . Carbon::now()->format('YmdHis') . "." . $foto->getClientOriginalExtension();
                $foto->move($destinationPath, $profileImage);

                $tanggalHariIni = Carbon::now()->toDateString();

                // Simpan ke database
                $pulang = Pulang::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'gambar' => $profileImage,
                    'tanggal' => $tanggalHariIni,
                ]);

                return response()->json([
                    "message" => "Kamu berhasil menambahkan gambar pulang",
                    "data" => $pulang
                ]);
            } else {
                return response()->json([
                    "message" => "File gambar tidak ditemukan."
                ]);
            }
        }

        return response()->json([
            "message" => "Kamu gagal mengirim data."
        ]);
    }

    public function detail_pulang_by_tanggal()
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $today = Carbon::now()->format('Y-m-d');
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $pulang = Pulang::where('mahasiswa_id', $mahasiswa->id)->where('tanggal', $today)->latest()->first();

            return response()->json([
                "message" => "kamu berhasil mengambil data pulang hari ini",
                "data" => [
                    $pulang
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    // kegiatan
    public function kegiatan(Request $request)
    {

        $user = Auth::user();

        if ($user->roles == 'mahasiswa') {

            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $today = Carbon::now()->format('Y-m-d');

            $kegiatan = new Kegiatan;
            $kegiatan->deskripsi = $request->deskripsi;
            $kegiatan->jam_mulai = $request->jam_mulai;
            $kegiatan->jam_selesai = $request->jam_selesai;
            $kegiatan->tanggal = $today;
            $kegiatan->mahasiswa_id = $mahasiswa->id;
            $kegiatan->save();

            $tanggalHariIni = Carbon::now()->toDateString();

            return response()->json([
                "message" => "Kamu menambahkan kegiatan",
                "data" => Kegiatan::where('mahasiswa_id', $mahasiswa->id)->where('tanggal', $tanggalHariIni)->get()
            ]);
        }

        return response()->json([
            "message" => "Kamu gagal mengirim data"
        ]);
    }

    public function detail_kegiatan_by_tanggal()
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $today = Carbon::now()->format('Y-m-d');
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $kegiatan = kegiatan::where('mahasiswa_id', $mahasiswa->id)->where('tanggal', $today)->get();

            return response()->json([
                "message" => "kamu berhasil mengambil data kegiatan hari ini",
                "data" => [
                    $kegiatan
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function updateStatus(Request $request)
    {
        $mahasiswa = Mahasiswa::find($request->mahasiswaId);
        $isChecked = $request->input('isChecked');
        $mahasiswa->keterangan = $isChecked;
        $mahasiswa->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
}
