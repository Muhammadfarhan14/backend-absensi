<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::get();
        return view('Admin.pages.lokasi.index',['lokasi' => $lokasi]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $lokasi = new Lokasi();
        $lokasi->nama = $request->nama;
        $lokasi->alamat = $request->alamat;

        $foto = $request->file('gambar');
        $destinationPath = 'images/';
        $profileImage = Str::slug($request->nama) . "." . $foto->getClientOriginalExtension();
        $foto->move($destinationPath, $profileImage);

        $lokasi->gambar = $profileImage;

        $lokasi->save();
        return redirect()->route('lokasi.index');
    }

    public function update(Request $request,$id)
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
