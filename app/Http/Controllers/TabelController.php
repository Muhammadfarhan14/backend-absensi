<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Kegiatan;
use App\Models\Kendala;
use Illuminate\Http\Request;

class TabelController extends Controller
{
    public function tabel_kegiatan()
    {
        $kegiatan = Kegiatan::orderBy('tanggal','asc')->get();

        return view('Admin.pages.table.kegiatan', ['data' => $kegiatan]);
    }

    public function tabel_kendala(){
        $kendala = Kendala::orderBy('tanggal','asc')->get();
        return view('Admin.pages.tabke.kendala', ['kendala' => $kendala]);
    }

    public function kegiantanPDF()
    {
        $kegiatan = Kegiatan::orderBy('tanggal','asc')->get();
        $pdf = PDF::loadView('Admin.pages.table.kegiatan',['data' => $kegiatan]);
        $pdf->setPaper('A4','potrait');
        $today = Carbon::now()->format('YmdHis');
        return $pdf->stream("tabel_kegiatan_{$today}.pdf");
    }
    public function kendalaPDF()
    {
        $kendala = Kendala::orderBy('tanggal','asc')->get();
        $pdf = PDF::loadView('Admin.pages.tabke.kendala',['kendala' => $kendala]);

        $today = Carbon::now()->format('YmdHis');
        return $pdf->download("tabel_kendala_{$today}.pdf");
    }
}
