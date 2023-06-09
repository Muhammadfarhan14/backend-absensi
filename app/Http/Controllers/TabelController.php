<?php

namespace App\Http\Controllers;

use PDF;
// use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use App\Models\Kegiatan;
use App\Models\Kendala;
use Illuminate\Http\Request;

class TabelController extends Controller
{
    public function tabel_kegiatan()
    {
        $kegiatan = Kegiatan::orderBy('tanggal','asc')->get();

        return view('Admin.pages.tabke.kegiatan', ['data' => $kegiatan]);
    }

    public function tabel_kendala(){
        $kendala = Kendala::orderBy('tanggal','asc')->get();
        return view('Admin.pages.tabke.kendala', ['kendala' => $kendala]);
    }

    public function kegiantanPDF()
    {
        $kegiatan = Kegiatan::orderBy('tanggal','asc')->get();
        $pdf = PDF::loadView('Admin.pages.tabke.kegiatan',['data' => $kegiatan]);

        $today = Carbon::now()->format('YmdHis');
        return $pdf->download("tabel_kegiatan_{$today}.pdf");
    }
    public function kendalaPDF()
    {
        $kendala = Kendala::orderBy('tanggal','asc')->get();
        $pdf = PDF::loadView('Admin.pages.tabke.kendala',['kendala' => $kendala]);

        $today = Carbon::now()->format('YmdHis');
        return $pdf->download("tabel_kendala_{$today}.pdf");
    }
}
