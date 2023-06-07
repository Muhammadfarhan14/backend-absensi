<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tabel kegiatan</title>
</head>

<body>
    <table style="margin: 0 auto; width:100%;text-align: center;">
        <tr>
            <td width="20%"> <img src="{{asset('assets/img/logo -uin-alauddin.jpg')}}" width="70%" alt=""></td>
            <td>
                <table style="margin: 0 auto; width:100%;text-align: center;">
                    <tr>
                        <td><b>KEMENTERIAN AGAMA R.I.</b></td>
                    </tr>
                    <tr>
                        <td><b>UNIVERSITAS ISLAM NEGERI (UIN) ALAUDDIN MAKASSAR</b></td>
                    </tr>
                    <tr>
                        <td><b>FAKULTAS  SAINS & TEKNOLOGI</b></td>
                    </tr>
                    <tr>
                        <td>Jl. Sultan Alauddin No. 36. Romangpolong, Samata, Gowa Telp. (0411) 8221400</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr size="2" color="#000">
    <table style="width:100%;">
        <tr>
            <td style="text-align:center;"><b>LEMBAR PENILAIAN PRAKTEK PENGALAMAN LAPANGAN</b></td>
        </tr>
        <tr>
            <td>Berdasarkan Praktek Pengalaman Lapangan yang dilakukan oleh :</td>
        </tr>
        <tr>
            <td>
                <table border="1" style="width:50%; margin: 0 auto; text-align:center">
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
                    <li>Tempat Praktek Pengalaman Lapangan : </li>
                    <li>Kisaran Penilaian	:	100 ≥ A ≥ 80 ,  80 > B ≥ 60 , C < 60 </li>
                </ul>
            </td>
        </tr>
        <tr>
            <td><b>Kriteria Penilaian</b></td>
        </tr>
        <tr>
            <td>
                <ol>
                    <li type="I">Inovasi </li>
                    <li type="I">Kerjasama</li>
                    <li type="I">Disiplin</li>
                    <li type="I">Inisiatif</li>
                    <li type="I">Kerajinan</li>
                    <li type="I">Sikap</li>
                </ol>
            </td>
        </tr>
    </table>

    <table border="1" style="margin: 0 auto; width:100%;text-align: center; margin-top:10px;">
        <thead>
            <tr>
                <td>No</td>
                <td>Tanggal/Hari</td>
                <td>Waktu Kegiatan</td>
                <td>Rincian Kegiatan</td>
            </tr>
        </thead>
        <tbody>
            @php
                $prevDate = null;
                $no = 0;
            @endphp

            @foreach ($data as $item)
                @php
                    if ($prevDate !== $item->tanggal) {
                        $rowspan = $data->where('tanggal', $item->tanggal)->count();
                        $prevDate = $item->tanggal;
                    } else {
                        $rowspan = 0;
                    }
                @endphp
                <tr>
                    @if ($rowspan > 0)
                        <td rowspan="{{ $rowspan }}">{{ $no += 1 }}</td>
                        <td rowspan="{{ $rowspan }}">{{ $item->tanggal }}</td>
                    @endif
                    <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                    <td>{{ $item->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
