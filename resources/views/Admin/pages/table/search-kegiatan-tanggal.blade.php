<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabel Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="container">
        <div class="row">
            <form action="{{ route('search') }}" method="GET">
                @csrf
                <div class="col-12 d-flex my-2">
                    <select id="select-nama" class="form-select mx-3" name="nama">
                        <option disabled>Nama</option>
                        @foreach ($mahasiswa->unique('nama') as $mhs)
                            <option value="{{ $mhs->nama }}">{{ $mhs->nama }}</option>
                        @endforeach
                    </select>
                    <select id="select-nim" class="form-select mx-3" name="nim">
                        <option disabled>NIM</option>
                        @foreach ($mahasiswa->unique('nim') as $mhs)
                            <option value="{{ $mhs->nim }}">{{ $mhs->nim }}</option>
                        @endforeach
                    </select>
                    <select id="select-tanggal" class="form-select mx-3" name="tanggal">
                        <option disabled>Tanggal</option>
                        @foreach ($datang->unique('tanggal') as $item)
                            <option value="{{ $item->tanggal }}">{{ $item->tanggal }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-primary w-100 mx-3">Cari</button>
                </div>
            </form>
        </div>

        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    @php
                        $rowspan = $searchMahasiswa->count();
                    @endphp
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nim</th>
                            <th colspan="{{$rowspan*5}}">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($searchMahasiswa as $item)
                            <tr>
                                <td rowspan="3">{{ $item->nama }}</td>
                                <td rowspan="3">{{ $item->nim }}</td>
                                @foreach ($selectDatang->unique('tanggal') as $data)
                                <td colspan="5">
                                    {{ Carbon::parse($data->tanggal)->isoFormat('dddd, DD MMMM YYYY') }}
                                </td>
                            @endforeach
                            </tr>
                            <tr>
                                @foreach ($selectDatang->unique('tanggal') as $data)
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                            @endforeach
                            </tr>
                            <tr>
                                @foreach ($item->kegiatan as $data)
                                    <td>{{ $data->deskripsi }}</td>
                                @endforeach
                                {{-- Add empty cells for columns 4 and 5 if data is not available --}}
                                @for ($i = count($item->kegiatan); $i < 5; $i++)
                                    <td></td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
</body>

</html>
