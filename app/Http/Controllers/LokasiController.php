<?php

namespace App\Http\Controllers;

use App\Http\Requests\LokasiRequest;
use App\Http\Requests\UpdateLokasiRequest;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::get();
        return view('Admin.pages.lokasi.index',['lokasi' => $lokasi]);
    }

    public function store(LokasiRequest $request)
    {

        $foto = $request->file('gambar');
        $destinationPath = 'images/';
        $profileImage = Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
        $foto->move($destinationPath, $profileImage);

        Lokasi::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'gambar' => $profileImage
        ]);

        return redirect()->route('lokasi.index');
    }

    public function update(UpdateLokasiRequest $request,$id)
    {
        $lokasi = Lokasi::where('id',$id)->first();

        if($request->gambar){
            $file_path = public_path().'/images/'.$lokasi->gambar;
            unlink($file_path);

            $lokasi->nama = $request->nama;
            $lokasi->alamat = $request->alamat;
            $foto = $request->file('gambar');
            $destinationPath = 'images/';
            $profileImage = Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $profileImage);
            $lokasi->gambar = $profileImage;
            $lokasi->update();
        }else{
            $lokasi->nama = $request->nama;
            $lokasi->alamat = $request->alamat;
            $lokasi->update();
        }

        return redirect()->route('lokasi.index');
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::where('id',$id)->first();
        $file_path = public_path().'/images/'.$lokasi->gambar;
        unlink($file_path);
        $lokasi->delete();
        return redirect()->route('lokasi.index');

    }
}
