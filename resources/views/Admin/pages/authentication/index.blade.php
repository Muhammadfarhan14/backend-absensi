@extends('Admin.Layouts.App', ['title' => 'Authentication'])

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endpush

@section('isi')
    @php
        use Carbon\Carbon;
        use App\Models\User;
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Authentication</h4>

        <div class="card">
            <div class="card-header flex-column flex-md-row">
                <div class="card-datatable table-responsive mt-3">
                    <table class="datatables-users table border-top" id="mahasiswa">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>username</th>
                                <th>nama</th>
                                <th>Token</th>
                                <th>Waktu Akses</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($token as $item)
                                @php
                                    $user = User::where('id', $item->tokenable_id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ Str::limit($item->token, 20) }}</td>
                                    <td>{{ Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY [Jam] hh:mm [Wita]') }}
                                    </td>
                                    <td>
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
            @include('Admin.pages.authentication.modal')
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
