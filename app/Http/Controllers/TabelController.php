<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class TabelController extends Controller
{
    public function tabel_kegiatan()
    {
        $kegiatan = Kegiatan::orderBy('tanggal','asc')->get();
        return view('Admin.pages.tabke.kegiatan', ['data' => $kegiatan]);
    }
}
