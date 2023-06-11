<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tabel kegiatan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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

    .kriteria-penilaian .baris {
        display: flex;
        justify-content: space-between;
    }

    .kriteria-penilaian ol li p {
        width: 100px;
    }

    .tanda-tangan {
        float: right;
    }
</style>

<body>
    @php
        use Carbon\Carbon;
        use App\Models\Kegiatan;
        use App\Models\Kendala;
    @endphp
    <table style="margin: 0 auto; width:100%;text-align: center;">
        <tr>
            <td width="20%"> <img src="{{ asset('assets/img/logo -uin-alauddin.jpg') }}" width="70%" alt="">
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
                        <td>60900120016</td>
                        <td>Muiz Muharram</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <ul>
                    <li style="margin-bottom:10px;">Tempat Praktek Pengalaman Lapangan : <br> PT. Kioser Teknologi
                        Indonesia </li>
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
        <div class="kriteria-penilaian">
            <ol type="I">
                <li>
                    <div class="baris">
                        <p>Inovasi</p>
                    </div>
                </li>
                <li>
                    <div class="baris">
                        <p>Kerjasama</p>
                        <p>:</p>
                    </div>
                </li>
                <li>
                    <div class="baris">
                        <p>Disiplin</p>
                        <p>:</p>
                    </div>
                </li>
                <li>
                    <div class="baris">
                        <p>Inisiatif</p>
                        <p>:</p>
                    </div>
                </li>
                <li>
                    <div class="baris">
                        <p>Kerajinan</p>
                        <p>:</p>
                    </div>
                </li>
                <li>
                    <div class="baris">
                        <p>Sikap</p>
                        <p>:</p>
                    </div>
                </li>
                <li style="list-style-type: none;">
                    <div class="baris">
                        <p>Rata - rata</p>
                        <p>:</p>
                    </div>
                </li>
            </ol>
        </div>

        <div class="tanda-tangan">
            <div class="isi">
                <div class="alamat">
                    <p>Makassar, Desember 2021</p>
                    <p>PT. Kioser Teknologi Indonesia</p>
                </div>
                <div class="visible-print text-center">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate(url('/'))) !!} ">
                    <h4>Alfian Adyanto, S.M</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- @if (Kegiatan::count() != null)
        <h4 style="margin: 5px auto;">
            Laporan Kegiatan:
        </h4>
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
                @foreach ($data as $item)
                    @php
                        if ($prevDate !== $item->tanggal) {
                            $rowspan = $data->where('tanggal', $item->tanggal)->count();
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
    @endif --}}
</body>

</html>
