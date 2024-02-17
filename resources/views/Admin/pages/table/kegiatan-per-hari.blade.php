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

    <div class="container">
        <div class="row">
            <form action="{{ route('search') }}" method="GET">
                @csrf
                <div class="col-12 d-flex my-2">
                    <select id="select-nama" class="form-select mx-3" name="nama">
                        <option selected value="">Nama</option>
                        @foreach ($mahasiswa->unique('nama') as $mhs)
                            <option value="{{ $mhs->nama }}">{{ $mhs->nama }}</option>
                        @endforeach
                    </select>
                    <select id="select-nim" class="form-select mx-3" name="nim">
                        <option selected value="">NIM</option>
                        @foreach ($mahasiswa->unique('nim') as $mhs)
                            <option value="{{ $mhs->nim }}">{{ $mhs->nim }}</option>
                        @endforeach
                    </select>
                    <select id="select-tanggal" class="form-select mx-3" name="tanggal">
                        <option selected value="">Tanggal</option>
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nim</th>
                            <th colspan="5">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>

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
