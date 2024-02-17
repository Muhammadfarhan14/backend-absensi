<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// model
use App\Models\Komen;
use App\Models\Kendala;
use App\Models\Mahasiswa;
use App\Models\DosenPembimbing;

class KomenController extends Controller
{

    public function getByTanggal()
    {
        $today = Carbon::now()->format('Y-m-d');
        $data = Komen::where('tanggal',$today)->get();
        return response()->json([
            "message" => "kamu berhasil mengambil data komen hari ini",
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $today = Carbon::now()->format('Y-m-d');
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $kendala = Kendala::where('mahasiswa_id', $mahasiswa->id)->where('tanggal', $today)->first();

            $tanggal_komen =Komen::where('tanggal',$today)->get();
            if ($tanggal_komen->count() === 5) {
                return response()->json([
                    "message" => "maksimal 5 komentar tiap hari"
                ]);
            }else{
                $komen = Komen::create([
                    'kendala_id' => $kendala->id,
                    'author' => $user->nama,
                    'deskripsi' => $request->deskripsi,
                    'tanggal' => $today
                ]);

                return response()->json([
                    "message" => "kamu berhasil mengambil data kendala hari ini",
                    "data" => $komen
                ]);
            }

        } else if ($user->roles == 'dosen_pembimbing') {
            $today = Carbon::now()->format('Y-m-d');
            $kendala_id = $request->kendala_id;
            $kendala = Kendala::where('id', $kendala_id)->where('tanggal', $today)->first();
            $komen = Komen::create([
                'kendala_id' => $kendala->id,
                'author' => $user->nama,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $today
            ]);

            return response()->json([
                "message" => "kamu berhasil mengambil data kendala hari ini",
                "data" => $komen
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Komen  $komen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Komen $komen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Komen  $komen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Komen $komen)
    {
        //
    }

}
