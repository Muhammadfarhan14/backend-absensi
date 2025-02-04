<?php

namespace App\Http\Controllers;

use App\Http\Requests\LokasiRequest;
use App\Http\Requests\UpdateLokasiRequest;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use Carbon\Carbon;


class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::get();
        return view('Admin.pages.lokasi.index', ['lokasi' => $lokasi]);
    }

    public function store(LokasiRequest $request)
    {

        // $foto = $request->file('gambar');
        // $destinationPath = 'images/';
        // $baseURL = url('/');
        // $profileImage = $baseURL . '/images/' . Str::slug($request->nama) . '-' . Carbon::now()->format('YmdHis')  . "." . $foto->getClientOriginalExtension();
        // $foto->move($destinationPath, $profileImage);

        Lokasi::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            // 'gambar' => $profileImage
        ]);

        return redirect()->route('lokasi.index');
    }

    public function update(UpdateLokasiRequest $request, $id)
    {
        $lokasi = Lokasi::where('id', $id)->first();

        if ($request->gambar) {
            $baseURL = url('/');
            $file_path = Str::replace($baseURL . '/images/', '', public_path() . '/images/' . $lokasi->gambar);
            unlink($file_path);

            $lokasi->nama = $request->nama;
            $lokasi->alamat = $request->alamat;
            $foto = $request->file('gambar');
            $destinationPath = 'images/';
            $profileImage = $baseURL . '/images/' . Str::slug($request->nama) . '-' . Carbon::now()->format('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $profileImage);
            $lokasi->gambar = $profileImage;
            $lokasi->update();
        } else {
            $lokasi->nama = $request->nama;
            $lokasi->alamat = $request->alamat;
            $lokasi->update();
        }

        return redirect()->route('lokasi.index');
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::where('id', $id)->first();
        // $baseURL = url('/');
        // $file_path = Str::replace($baseURL . '/images/', '', public_path() . '/images/' . $lokasi->gambar);
        // unlink($file_path);
        $lokasi->delete();
        return redirect()->route('lokasi.index');
    }
}
