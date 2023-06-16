<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use App\Models\DosenPembimbing;
use Illuminate\Support\Facades\Auth;

class TabelController extends Controller
{
    public function tabel_kegiatan($id)
    {
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        $kegiatan = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->orderBy('tanggal', 'asc')->get();
        return view('Admin.pages.table.kegiatan', ['mahasiswa' => $mahasiswa, 'data' => $kegiatan]);
    }

    public function kegiatanPDF()
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $kegiatan = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->orderBy('tanggal', 'asc')->get();
            $nama = Str::slug($mahasiswa->nama, '_'); // Mengganti spasi dengan tanda -
            $fileName = "tabel_kegiatan_ppl_{$nama}.pdf";
            $baseURL = url('/'). '/pdf/' . $fileName;
            if ($mahasiswa->where('pdf', null)) {
                $mahasiswa->update([
                    'pdf' => $baseURL
                ]);
            }
            $pdf = PDF::loadView('Admin.pages.table.kegiatan', ['mahasiswa' => $mahasiswa, 'data' => $kegiatan]);
            $pdf->setPaper('A4', 'portrait');
            $filePath = public_path('pdf/' . $fileName);
            if ($mahasiswa->where('pdf', null)) {
                $pdf->save($filePath);
                $pdf->download("{$fileName}");
            }
            return response()->json([
                "message" => "url file kegiatan pdf mahasiswa",
                "data" => $mahasiswa->pdf
            ]);
        }
        return response()->json([
            "message" => "kamu tidak login sebagai mahasiswa"
        ]);
    }

    public function semuaKegianPDF($id)
    {
        $dosen_pembimbing = DosenPembimbing::where('id', $id)->first();
        $mahasiswa = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->whereNotNull('pdf')->get();
        $pdf = PDF::loadView('Admin.pages.table.seluruh-kegiatan-mahasiswa', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('A4', 'portrait');
        $fileName = "tabel_kegiatan_ppl_dosen_{$dosen_pembimbing->nama}.pdf";

        return $pdf->stream($fileName);
    }
}
