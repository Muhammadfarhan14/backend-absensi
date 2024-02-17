<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Datang;
use App\Models\Pulang;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use App\Models\DosenPembimbing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TabelController extends Controller
{
    public function tabel_kegiatan($id)
    {
        $mahasiswa = Mahasiswa::where('id', $id)->where('keterangan', true)->first();
        $kegiatan = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->orderBy('tanggal', 'asc')->get();
        return view('Admin.pages.table.kegiatan', ['mahasiswa' => $mahasiswa, 'data' => $kegiatan]);
    }

    public function kegiatanPDF()
    {
        $user = Auth::user();
        if ($user->roles == 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->where('keterangan', true)->first();
            $hariPertama = Pulang::where('mahasiswa_id', $mahasiswa->id)->oldest()->first();
            $hariTerakhir = Pulang::where('mahasiswa_id', $mahasiswa->id)->latest()->first();
            $kegiatan = Kegiatan::where('mahasiswa_id', $mahasiswa->id)->orderBy('tanggal', 'asc')->get();

            $nama = Str::slug($mahasiswa->nama, '_'); // Mengganti spasi dengan tanda -
            $fileName = "tabel_kegiatan_ppl_{$nama}.pdf";
            $baseURL = url('/') . '/pdf/' . $fileName;
            if ($mahasiswa->kriteria_penilaian) {
                if ($mahasiswa->where('pdf', null)) {
                    $mahasiswa->update([
                        'pdf' => $baseURL
                    ]);
                }
            } else {
                return response()->json([
                    "message" => "url file kegiatan pdf mahasiswa masih kosong",
                    "data" => ""
                ]);
            }
            $pdf = PDF::loadView('Admin.pages.table.kegiatan', ['mahasiswa' => $mahasiswa, 'data' => $kegiatan, 'hariPertama' => $hariPertama, 'hariTerakhir' => $hariTerakhir]);
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

    public function semuaKegianPDF()
    {
        $user = Auth::user();
        if ($user->roles == 'dosen_pembimbing') {
            $dosen_pembimbing = DosenPembimbing::where('user_id', $user->id)->first();
            $seluruhMahasiswa = Mahasiswa::where('dosen_pembimbing_id', $dosen_pembimbing->id)->count();
            $mahasiswa = Mahasiswa::with('pulang')->where('dosen_pembimbing_id', $dosen_pembimbing->id)->whereNotNull('pdf')->get();

            if ($seluruhMahasiswa === $mahasiswa->count()) {
                $nama = Str::slug($dosen_pembimbing->nama, '_'); // Mengganti spasi dengan tanda -
                $fileName = "tabel_kegiatan_ppl_dosen_{$nama}.pdf";
                $baseURL = url('/') . '/pdf/' . $fileName;

                if ($dosen_pembimbing->where('pdf', null)) {
                    $dosen_pembimbing->update([
                        'pdf' => $baseURL
                    ]);

                    $pdf = PDF::loadView('Admin.pages.table.seluruh-kegiatan-mahasiswa', ['mahasiswa' => $mahasiswa]);
                    $pdf->setPaper('A4', 'portrait');
                    $filePath = public_path('pdf/' . $fileName);
                    $pdf->save($filePath);
                    $pdf->download("{$fileName}");

                    return response()->json([
                        "message" => "url file kegiatan pdf mahasiswa pada dosen pembimbing",
                        "data" => $dosen_pembimbing->pdf
                    ]);
                } else {
                    return response()->json([
                        "message" => "file sudah tersedia",
                        "data" => $dosen_pembimbing->pdf
                    ]);
                }
            } else {
                return response()->json([
                    "message" => "masih ada mahasiswa yang belum generate file kegiatan ppl",
                    "data" => ""
                ]);
            }
        }
    }

    public function kegiatan_harian()
    {
        $mahasiswa = Mahasiswa::get();
        $datang = Datang::get();

        return view('Admin.pages.table.kegiatan-per-hari', compact('mahasiswa', 'datang'));
    }

    public function search(Request $request)
    {

        $mahasiswa = Mahasiswa::get();
        $datang = Datang::get();

        if ($request->nama && $request->nim && $request->tanggal) {
            $searchMahasiswa = Mahasiswa::with('datang')
                ->where('nama', 'like', "%$request->nama%")
                ->where('nim', 'like', "%$request->nim%")
                ->first();

            // Check if the name and nim match, otherwise redirect
            if (!$searchMahasiswa) {
                return redirect()->route('tabel-kegiatan'); // Replace 'redirect-route' with your actual route name
            }

            return view('Admin.pages.table.search-kegiatan', compact('mahasiswa', 'datang', 'searchMahasiswa'));
        }elseif ($request->nama && $request->nim) {
            // Jika nama dan nim diisi, cari berdasarkan keduanya
            $searchMahasiswa = Mahasiswa::with('datang')
                ->where('nama', 'like', "%$request->nama%")
                ->where('nim', 'like', "%$request->nim%")
                ->first();

            // Check if the name and nim match, otherwise redirect
            if (!$searchMahasiswa) {
                return redirect()->route('tabel-kegiatan'); // Replace 'redirect-route' with your actual route name
            }

            return view('Admin.pages.table.search-kegiatan', compact('mahasiswa', 'datang', 'searchMahasiswa'));
        } elseif ($request->nama) {
            // Jika hanya nama diisi, cari berdasarkan nama
            $searchMahasiswa = Mahasiswa::with('datang')
                ->where('nama', 'like', "%$request->nama%")
                ->first();

            return view('Admin.pages.table.search-kegiatan', compact('mahasiswa', 'datang', 'searchMahasiswa'));
        } elseif ($request->nim) {
            // Jika hanya nim diisi, cari berdasarkan nim
            $searchMahasiswa = Mahasiswa::with('datang')
                ->where('nim', 'like', "%$request->nim%")
                ->first();

            return view('Admin.pages.table.search-kegiatan', compact('mahasiswa', 'datang', 'searchMahasiswa'));
        } elseif ($request->tanggal) {
            // Jika hanya tanggal diisi, cari berdasarkan tanggal di Datang
            $selectDatang = Datang::where('tanggal', 'like', "%$request->tanggal%")->get();
            $mahasiswaIds = $selectDatang->pluck('mahasiswa_id')->toArray();

            $searchMahasiswa = Mahasiswa::with('datang')
            ->whereIn('id', $mahasiswaIds)
            ->get();
            // dd($searchMahasiswa);


            return view('Admin.pages.table.search-kegiatan-tanggal', compact('mahasiswa', 'datang', 'searchMahasiswa', 'selectDatang'));
        } else {
            // Jika tidak ada parameter yang diisi, redirect ke tabel-kegiatan
            return redirect()->route('tabel-kegiatan');
        }
    }
}
