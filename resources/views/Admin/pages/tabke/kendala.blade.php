<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tabel kegiatan</title>
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

    #tabel-kendala {
        border-collapse: collapse;
        width: 100%;
    }

    #tabel-kendala th,
    #tabel-kendala td {
        padding: 8px;
        text-align: center;
        border: 1px solid #000;
    }

    #tabel-kendala th {
        background-color: #f2f2f2;
        border: 1px solid #000;
    }

    #tabel-kendala tr:hover {
        background-color: #f5f5f5;
    }



    .table {
        display: table;
        width: 24%;
    }

    .row {
        display: table-row;
    }

    .cell {
        display: table-cell;
        padding: 5px 15px;
    }

    .cell:first-child {
        width: 88px;
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
                            $text = "Kisaran Penilaian : 100 <= A>= 80 , 80 < B>= 60 , C < 60 ";
                        @endphp
                    <li>{{$text}}</li>
                </ul>
            </td>
        </tr>
    </table>

    <div>
        <div>
            <h4 style="margin: 0 auto;">Kriteria Penilaian</h4>
        </div>

        <div class="table">
            <div class="row">
                <div class="cell">I. Inovasi</div>
                <div class="cell" style="display:flex; width:20px;">: A</div>
            </div>
            <div class="row">
                <div class="cell">II. Kerjasama</div>
                <div class="cell" style="display:flex; width:20px;">: A</div>
            </div>
            <div class="row">
                <div class="cell">III. Disiplin</div>
                <div class="cell" style="display:flex; width:20px;">: A</div>
            </div>
            <div class="row">
                <div class="cell">IV. Inisiatif</div>
                <div class="cell" style="display:flex; width:20px;">: A</div>
            </div>
            <div class="row">
                <div class="cell">V. Kerajinan</div>
                <div class="cell" style="display:flex; width:20px;">: A</div>
            </div>
            <div class="row">
                <div class="cell">VI. Sikap</div>
                <div class="cell" style="display:flex; width:20px;">: A</div>
            </div>
        </div>
    </div>

    @if (Kendala::count() != null)
        <div class="">
            <h4 style="margin: 20px auto 5px;">
                Laporan Kendala:
            </h4>
        </div>
        <table id="tabel-kendala">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal/Hari</th>
                    <th>Rincian Kendala</th>
                </tr>
            </thead>
            <tbody>
                @php
                $prevDate = null;
                $noKendala = 0;
            @endphp
                @foreach ($kendala as $item)
                @php
                if ($prevDate !== $item->tanggal) {
                    $rowspan = $kendala->where('tanggal', $item->tanggal)->count();
                    $prevDate = $item->tanggal;
                } else {
                    $rowspan = 0;
                }
                $tanggalKendala = Carbon::parse($item->tanggal)->isoFormat('dddd/DD MMMM YYYY');
            @endphp
            <tr>
                @if ($rowspan > 0)
                    <td rowspan="{{ $rowspan }}">{{ $noKendala += 1 }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $tanggalKendala }}</td>
                @endif
                <td>{{ $item->deskripsi }}</td>
            </tr>
                @endforeach

            </tbody>
        </table>
    @endif
</body>

</html>
