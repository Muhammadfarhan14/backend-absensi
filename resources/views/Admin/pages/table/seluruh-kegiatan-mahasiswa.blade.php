<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>seluruh tabel kegiatan mahasiswa</title>
</head>

<style>
    #top-line {
        border-collapse: collapse;
        margin: 0 auto;
        width: 100%;
    }

    #top-line tr {
        border-top: 2px solid #000;
    }

    .text-top {
        font-size: 14px;
        text-align: center;
    }

    #tabel-head {
        width: 100%;
        margin: 0 auto;
    }

    #tabel-mahasiswa {
        border-collapse: collapse;
        margin: 0 auto;
        margin-top: 10px;
        width: 50%;
    }

    #tabel-mahasiswa th,
    #tabel-mahasiswa td {
        padding: 8px;
        text-align: center;
        border: 1px solid #000;
    }

    #tabel-mahasiswa th {
        background-color: #f2f2f2;
        border: 1px solid #000;
    }

    #tabel-mahasiswa tr:hover {
        background-color: #f5f5f5;
    }

    #tabel-kegiatan {
        border-collapse: collapse;
        width: 100%;
    }

    #tabel-kegiatan th,
    #tabel-kegiatan td {
        padding: 8px;
        text-align: center;
        border: 1px solid #000;
    }

    #tabel-kegiatan th {
        background-color: #f2f2f2;
        border: 1px solid #000;
    }

    #tabel-kegiatan tr:hover {
        background-color: #f5f5f5;
    }

    .tanda-tangan {
        float: right;
    }

    .kriteria-penilaian .no {
        text-align: right;
    }

    .kriteria-penilaian td {
        padding: 5px 5px;
    }

    .page-break {
        page-break-after: always;
    }
</style>

<body>
    @php
        use Carbon\Carbon;
        use App\Models\Kegiatan;
    @endphp
    @foreach ($mahasiswa as $item)
        @php
            $kegiatan = Kegiatan::where('mahasiswa_id', $item->id)->get();
        @endphp
        <div class="page-1">
            <table style="margin: 0 auto; width:100%;text-align: center;">
                <tr>
                    <td width="20%"> <img
                            src="{{ url('https://rekreartive.com/wp-content/uploads/2019/03/Logo-UIN-Alauddin-Makassar-Warna.jpg') }}"
                            width="70%" alt="">
                    </td>
                    <td>
                        <table style="margin: 0 auto; width:100%;text-align: center;">
                            <tr>
                                <td><b>KEMENTERIAN AGAMA R.I.</b></td>
                            </tr>
                            <tr>
                                <td><b>UNIVERSITAS ISLAM NEGERI (UIN) ALAUDDIN MAKASSAR</b></td>
                            </tr>
                            <tr>
                                <td><b>FAKULTAS SAINS & TEKNOLOGI</b></td>
                            </tr>
                            <tr>
                                <td>Jl. Sultan Alauddin No. 36. Romangpolong, Samata, Gowa Telp. (0411) 8221400</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table id="top-line">
                <tr>
                    <td></td>
                </tr>
            </table>

            <div class="text-top">
                <h3>LEMBAR PENILAIAN PRAKTEK PENGALAMAN LAPANGAN</h3>
            </div>

            <table id="tabel-head">
                <tr>
                    <td><b class="text-top"></b></td>
                </tr>
                <tr>
                    <td>Berdasarkan Praktek Pengalaman Lapangan yang dilakukan oleh :</td>
                </tr>
                <tr>
                    <td>
                        <table id="tabel-mahasiswa">
                            <tr>
                                <th>No</th>
                                <th>Nim</th>
                                <th>Nama Mahasiswa</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->nama }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li style="margin-bottom:10px;">Tempat Praktek Pengalaman Lapangan : <br>
                                {{ $item->lokasi->nama }} </li>
                            @php
                                $text = 'Kisaran Penilaian : 100 <= A>= 80 , 80 < B>= 60 , C < 60 ';
                            @endphp
                            <li>{{ $text }}</li>
                        </ul>
                    </td>
                </tr>
            </table>

            <div>
                <div>
                    <h4 style="margin: 0 auto;">Kriteria Penilaian</h4>
                </div>

                @php
                $nilaiMap = [
                    4 => 'A',
                    3 => 'B',
                    2 => 'C',
                    1 => 'D',
                ];

                $inovasi = '';
                $kerja_sama = '';
                $disiplin = '';
                $inisiatif = '';
                $kerajinan = '';
                $sikap = '';

                if ($item->kriteria_penilaian) {
                    $inovasi = $nilaiMap[$item->kriteria_penilaian->inovasi] ?? '';
                    $kerja_sama = $nilaiMap[$item->kriteria_penilaian->kerja_sama] ?? '';
                    $disiplin = $nilaiMap[$item->kriteria_penilaian->disiplin] ?? '';
                    $inisiatif = $nilaiMap[$item->kriteria_penilaian->inisiatif] ?? '';
                    $kerajinan = $nilaiMap[$item->kriteria_penilaian->kerajinan] ?? '';
                    $sikap = $nilaiMap[$item->kriteria_penilaian->sikap] ?? '';
                }

                $rata2 = (collect($item->kriteria_penilaian)->only(['inovasi', 'kerja_sama', 'disiplin', 'inisiatif', 'kerajinan', 'sikap'])->sum() / 24) * 100;
                $total = '';
                if($rata2 >= 80 && $rata2 <= 100){
                        $total = 'A';
                    }elseif( $rata2 >= 60 && $rata2 < 80 ){
                        $total = 'B';
                    }elseif($rata < 60){
                        $total = 'C';
                    }elseif($total == 0){
                        $total = 'E';
                    }
            @endphp

                <div class="kriteria-penilaian">
                    <table>
                        <tr>
                            <td class="no">I.</td>
                            <td>Inovasi</td>
                            <td>: {{$inovasi}}</td>
                        </tr>
                        <tr>
                            <td class="no">II.</td>
                            <td>Kerjasama</td>
                            <td>: {{$kerja_sama}}</td>
                        </tr>
                        <tr>
                            <td class="no">III.</td>
                            <td>Disiplin</td>
                            <td>: {{$disiplin}}</td>
                        </tr>
                        <tr>
                            <td class="no">IV.</td>
                            <td>Inisiatif</td>
                            <td>: {{$inisiatif}}</td>
                        </tr>
                        <tr>
                            <td class="no">V.</td>
                            <td>Kerajinan</td>
                            <td>: {{$kerajinan}}</td>
                        </tr>
                        <tr>
                            <td class="no">VI.</td>
                            <td>Sikap</td>
                            <td>: {{$sikap}}</td>
                        </tr>
                        <tr>
                            <td class="no"></td>
                            <td>Rata - rata</td>
                            <td>: {{$total}}</td>
                        </tr>
                    </table>
                </div>

                <div class="tanda-tangan">
                    <table>
                        <tr>
                            <td>Makassar, {{ Carbon::now()->isoFormat('D MMMM YYYY') }}</span></td>
                        </tr>
                        <tr>
                            <td>{{ $item->lokasi->nama }}</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="data:image/png;base64, {!! base64_encode(
                                    QrCode::format('png')->size(100)->generate(url("{$item->pdf}")),
                                ) !!}" alt="QR Code">
                            </td>
                        </tr>
                        <tr>
                            <td><b>{{ $item->pembimbing_lapangan->nama }}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="page-2">
            <div class="text-top" style="text-align:center; text-transform:uppercase;">
                <h3>Lampiran <br>
                    Rincian Kegiatan
                </h3>
            </div>
            @php
                $hariPertama = $item->pulang->where('hari_pertama', true)->first();
                if ($hariPertama) {
                    $tanggalHariPertama = Carbon::parse($hariPertama->tanggal);
                    $formatHariPertama = Carbon::parse($hariPertama->tanggal)->isoFormat('D MMMM');
                    $tanggal45HariKedepan = $tanggalHariPertama->addDays(45)->isoFormat('D MMMM YYYY');
                }
            @endphp
            <div class="text-center" style="margin: 10px 0;text-transform:uppercase;">
                <h3 style="margin: 0 0;">Laporan kegiatan</h3>
                <h4 style="margin: 10px 0 5px;">Periode Tanggal {{ $formatHariPertama }} - s.d
                    {{ $tanggal45HariKedepan }}</h4>
                <table style="margin: 0 0;">
                    <tr>
                        <td style="height: 25px;">Jurusan/Prodi</td>
                        <td style="height: 25px;">:</td>
                        <td style="height: 25px;">Sistem Informasi</td>
                    </tr>
                    <tr>
                        <td style="height: 25px;">Jenjang</td>
                        <td style="height: 25px;">:</td>
                        <td style="height: 25px;">Strata Satu (S1)</td>
                    </tr>
                </table>
            </div>
            @if ($kegiatan != null)
                <table id="tabel-kegiatan" style="margin: 0 auto; width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal/Hari</th>
                            <th>Waktu Kegiatan</th>
                            <th>Rincian Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $prevDate = null;
                            $noKegiatan = 0;
                        @endphp
                        @foreach ($kegiatan as $item)
                            @php
                                if ($prevDate !== $item->tanggal) {
                                    $rowspan = $kegiatan->where('tanggal', $item->tanggal)->count();
                                    $prevDate = $item->tanggal;
                                } else {
                                    $rowspan = 0;
                                }
                                $waktuKegiatanJamMulai = Carbon::parse($item->jam_mulai)->format('H:i');
                                $waktuKegiatanJamSelesai = Carbon::parse($item->jam_selesai)->format('H:i');
                                $tanggalKegiatan = Carbon::parse($item->tanggal)->isoFormat('dddd/DD MMMM YYYY');
                            @endphp
                            <tr>
                                @if ($rowspan > 0)
                                    <td rowspan="{{ $rowspan }}">{{ $noKegiatan += 1 }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $tanggalKegiatan }}</td>
                                @endif
                                <td>{{ $waktuKegiatanJamMulai }} - {{ $waktuKegiatanJamSelesai }}</td>
                                <td>{{ $item->deskripsi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="page-break"></div>
    @endforeach
</body>
</html>
