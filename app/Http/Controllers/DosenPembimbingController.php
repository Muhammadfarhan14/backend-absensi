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

            foreach ($mahasiswa as $key => $value) {
                $lokasi = Lokasi::where('id', $value->lokasi_id)->first();

            // persentasi kehadiran
            $jumlahMahasiswaPadaLokasiPPL = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->where('lokasi_id', $lokasi->id)->get();
            $mahasiswaDatang = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->where('lokasi_id', $lokasi->id)
                ->whereHas('datang', function ($query) {
                    $today = Carbon::now()->format('Y-m-d');
                    $query->where('keterangan', 'hadir')->where('tanggal', $today);
                })->get();
                if($mahasiswaDatang != null){
                    $persentasiKehadiran = ($mahasiswaDatang->count()/$jumlahMahasiswaPadaLokasiPPL->count()) * 100;
                }else{
                    $persentasiKehadiran = 0;

                }

                // Periksa apakah lokasi sudah ditampilkan sebelumnya
                if (!in_array($lokasi->nama, $lokasi_tampil)) {
                    $lokasi_ppl[] = [
                        'id' => $lokasi->id,
                        'nama' => $lokasi->nama,
                        'gambar' => $lokasi->gambar,
                        'alamat' => $lokasi->alamat,
                        "pesentasi_kehadiran" => $persentasiKehadiran
                    ];
                    $lokasi_tampil[] = $lokasi->nama; // Tambahkan lokasi ke array lokasi_tampil
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
            foreach ($mahasiswa as $key => $item) {
                $kendala[$key] = Kendala::where('mahasiswa_id', $item->id)->where('tanggal', $today)->where('status', 0)->first();
            }

            return response()->json([
                "message" => "kamu berhasil mengirim data kendala menurut tanggal hari ini",
                "data" =>
                [
                    "kendala" => $kendala
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function detail_lokasi_ppl()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with('datang', 'pulang')->where('dosen_pembimbing_id', $dosen_pembimbing->id)->get();
            $mhs = Mahasiswa::with('datang', 'pulang')->where('dosen_pembimbing_id', $dosen_pembimbing->id)->first();

            return response()->json([
                "message" => "kamu berhasil mengirim data mahasiswa",
                "data" => [
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

    public function detail_mahasiswa()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->first();
            $jam_mulai = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->first();
            $jam_selesai = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->latest()->first();

            return response()->json([
                "message" => "kamu berhasil mengirim data mahasiswa",
                "data" => [
                    "mahasiswa" => $mahasiswa,
                ],
                [
                    "waktu kegiatan" =>
                    $jam_mulai->jam_mulai,
                    $jam_selesai->jam_selesai,
                ]
            ]);
        }
        return response()->json([
            "message" => "kamu gagal mengirim data"
        ]);
    }

    public function update_kendala()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $mahasiswa = Mahasiswa::with('kendala')->where('dosen_pembimbing_id', $dosen_pembimbing->id)->first();
            $kendala = Kendala::where('status', false)->first();
            $kendala->update([
                'status' => true
            ]);

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

    public function table_kegiatan()
    {
    }

    #end dosen pembimbing

}
