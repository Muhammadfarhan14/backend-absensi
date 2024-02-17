@extends('Admin.Layouts.App', ['title' => 'Pembimbing Lapangan'])

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endpush

@section('isi')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Pembimbing Lapangan</h4>

        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="text-end pt-3 pt-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#add-pembimbing-lapangan">
                        <span><i class="bx bx-plus me-sm-2"></i><span class="d-none d-sm-inline-block">Tambah
                                Pembimbing Lapangan</span></span>
                    </button>
                </div>
                <div class="card-datatable table-responsive mt-3">
                    <table class="datatables-users table border-top text-center" id="pembimbing-lapangan">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->pembimbing_lapangan->nama }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <!-- Tambahkan kelas "live-switch" pada checkbox -->
                                            <input class="form-check-input switch-value" type="checkbox" role="switch"
                                                data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                data-onlabel="Active" data-offlabel="InActive"
                                                data-pembimbing-lapangan-id="{{ $item->pembimbing_lapangan->id }}"
                                                id="flexSwitchCheckChecked-{{ $item->pembimbing_lapangan->id }}"
                                                {{ $item->pembimbing_lapangan->keterangan ? 'checked' : '' }}>
                                        </div>
                                    </td>
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
            @include('Admin.pages.pembimbing-lapangan.modal')
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
            $('#pembimbing-lapangan').DataTable({
                // Scroll options
                "pageLength": 5,
                scrollX: true,
            });
        });
    </script>

        <script>
            $(document).ready(function() {
                $('.switch-value').change(function() {
                    var checkbox = $(this);
                    var isChecked = checkbox.prop('checked') == true ? 1 : 0;
                    var pembimbingLapanganId = checkbox.data('pembimbing-lapangan-id');
                    console.log(pembimbingLapanganId)
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('pembimbing_lapangan.status-update') }}',
                        data: {
                            isChecked: isChecked,
                            pembimbingLapanganId: pembimbingLapanganId
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
@endpush
