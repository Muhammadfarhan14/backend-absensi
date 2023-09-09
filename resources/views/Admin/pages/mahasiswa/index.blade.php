@extends('Admin.Layouts.App', ['title' => 'Mahasiswa'])

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endpush

@section('isi')

@php
use App\Models\DosenPembimbing;
use App\Models\PembimbingLapangan;
use App\Models\Lokasi;
@endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Mahasiswa</h4>

        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="text-end pt-3 pt-md-0">
                  @if(Lokasi::count() != null && PembimbingLapangan::count() != null && DosenPembimbing::count() != null)
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-mahasiswa">
                    <span><i class="bx bx-plus me-sm-2"></i><span class="d-none d-sm-inline-block">Tambah
                            Mahasiswa</span></span>
                </button>
                  @endif
                </div>
                <div class="card-datatable table-responsive mt-3">
                    <table class="datatables-users table border-top" id="mahasiswa">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Nim</th>
                                <th>Username</th>
                                <th>Tempat PPL</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mhs as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->id_PPL }}</td>
                                <td>{{ $item->lokasi->nama }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#edit-modal-{{ $item->id }}"><span><i
                                                class="bx bx-edit me-sm-2"></i> <span
                                                class="d-none d-sm-inline-block">Edit</span></span>
                                    </button>
                                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#delete-modal-{{ $item->id }}"><span><i
                                                class="bx bx-trash me-sm-2"></i> <span
                                                class="d-none d-sm-inline-block">Delete</span></span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('Admin.pages.mahasiswa.modal')
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#mahasiswa').DataTable({
                // Scroll options
                scrollY: '300px',
                scrollX: true,
            });
        });
    </script>
@endpush
