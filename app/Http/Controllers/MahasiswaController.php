<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('Admin.pages.mahasiswa.index', ['mhs' => $mhs]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $mhs = new Mahasiswa();
        $mhs->nama = $request->nama;
        $mhs->nim = $request->nim;
        $mhs->password = Hash::make($request->password);
        $mhs->tempat_ppl = $request->tempat_ppl;
        $mhs->dosen_pembimbing = $request->dosen_pembimbing;


        $foto = $request->file('gambar');
        $destinationPath = 'images/';
        $profileImage = Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
        $foto->move($destinationPath, $profileImage);

        $mhs->foto = $profileImage;

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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $mhs = Mahasiswa::where('id', $id)->first();
        $mhs->nama = $request->nama;
        $mhs->nim = $request->nim;
        $mhs->password = Hash::make($request->password);
        $mhs->tempat_ppl = $request->tempat_ppl;
        $mhs->dosen_pembimbing = $request->dosen_pembimbing;

        if ($request->gambar) {
            $file_path = public_path() . '/images/' . $mhs->gambar;
            unlink($file_path);

            $foto = $request->file('gambar');
            $destinationPath = 'images/';
            $profileImage = Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $profileImage);

            $mhs->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'password' => $request->password,
                'tempat_ppl' => $request->tempat_ppl,
                'dosen_pembimbing' => $request->dosen_pembimbing,
                'gambar' => $profileImage,
            ]);
        } else {
            $mhs->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'password' => $request->password,
                'tempat_ppl' => $request->tempat_ppl,
                'dosen_pembimbing' => $request->dosen_pembimbing,
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
        $mhs->delete();
        return redirect()->route('mahasiswa.index');
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        return response()->json([
            "message" => "kamu berhasil mengambil data",
            "data" => [
                $mahasiswa
            ]
        ]);
    }
}
