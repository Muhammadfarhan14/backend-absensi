<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbing;
use PDF;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;

class TabelController extends Controller
{
    public function tabel_kegiatan($id)
    {
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        $kegiatan = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->orderBy('tanggal', 'asc')->get();
        return view('Admin.pages.table.kegiatan', ['mahasiswa' => $mahasiswa, 'data' => $kegiatan]);
    }

    public function kegiantanPDF($id)
    {
        $mahasiswa = Mahasiswa::where('id', $id)->first();
        $kegiatan = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->orderBy('tanggal', 'asc')->get();
        $pdf = PDF::loadView('Admin.pages.table.kegiatan', ['mahasiswa' => $mahasiswa, 'data' => $kegiatan]);
        $pdf->setPaper('A4', 'portrait');
        $baseURL = url('/');
        $nama = Str::replace($mahasiswa->nama,'-');
        $fileName = "tabel_kegiatan_ppl_{$mahasiswa->nama}.pdf";
        $filePath = public_path('pdf/' . $fileName);

        if ($mahasiswa->where('pdf', null)) {
            $pdf->save($filePath);
            $mahasiswa->update([
                'pdf' => $baseURL . '/pdf/' . $fileName
            ]);
        }

        return redirect($mahasiswa->pdf);
    }

    public function semuaKegianPDF($id)
    {
        $dosen_pembimbing = DosenPembimbing::where('id', $id)->first();
        $mahasiswa = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->whereNotNull('pdf')->get();
        $pdf = PDF::loadView('Admin.pages.table.seluruh-kegiatan-mahasiswa',['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('A4', 'portrait');
        $fileName = "tabel_kegiatan_ppl_dosen_{$dosen_pembimbing->nama}.pdf";

        return $pdf->stream($fileName);
    }
}
