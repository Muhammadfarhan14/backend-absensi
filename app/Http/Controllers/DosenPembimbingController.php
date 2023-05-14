<?php

namespace App\Http\Controllers;

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

class DosenPembimbingController extends Controller
{
    public function index()
    {
        $dosen_pembimbing = User::with('dosen_pembimbing')->where('roles','dosen_pembimbing')->get();
        return view('Admin.pages.dosen-pembimbing.index', ['data' => $dosen_pembimbing]);
    }

    public function store(Request $request)
    {
        $user = new User();

        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->roles = "dosen_pembimbing";
        $user->save();

        $this->validate($request, [
            'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $foto = $request->file('gambar');
        $destinationPath = 'images/';
        $profileImage = Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
        $foto->move($destinationPath, $profileImage);

        $dosen_pembimbing = new DosenPembimbing();
        $dosen_pembimbing->nama = $request->nama;
        $dosen_pembimbing->user_id = $user->id;
        $dosen_pembimbing->gambar = $profileImage;
        $dosen_pembimbing->save();

        return redirect()->route('dosen-pembimbing.index');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();

        if ($request->gambar) {
            $file_path = public_path() . '/images/' . $dosen_pembimbing->gambar;
            unlink($file_path);

            $foto = $request->file('gambar');
            $destinationPath = 'images/';
            $profileImage = Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $profileImage);

            $user->update([
                'username' => $request->username,
                'password' => $request->password,
            ]);

            $dosen_pembimbing->update([
                'nama' => $request->nama,
                'gambar' => $profileImage
            ]);

        } else {
            $user->update([
                'username' => $request->username,
                'password' => $request->password,
            ]);
            $dosen_pembimbing->update([
                'nama' => $request->nama,
            ]);

        }
        return redirect()->route('dosen-pembimbing.index');
    }

    public function destroy($id)
    {
        $user = User::where('id',$id)->first();
        $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
        $file_path = public_path() . '/images/' . $dosen_pembimbing->gambar;
        unlink($file_path);
        $dosen_pembimbing->delete();
        $user->delete();

        return redirect()->route('dosen-pembimbing.index');
    }


    #api dosen pembimbing
    public function home()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $lokasi_ppl = Lokasi::get();

            return response()->json([
                "message" => "kamu berhasil mengirim data pembimbing lapangan dan lokasi PPL",
                "data" =>
                [
                  "dosen pembimbing" => $user
                ],
                [
                   "lokasi" => $lokasi_ppl
                ]
            ]);
        }

    }

    public function detail_lokasi_ppl()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id',$user->id)->first();
            $mahasiswa = Mahasiswa::with('datang','pulang')->where('dosen_pembimbing_id', $dosen_pembimbing->id)->get();
            $mhs = Mahasiswa::with('datang','pulang')->where('dosen_pembimbing_id', $dosen_pembimbing->id)->first();

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
    }
#end dosen pembimbing

}
