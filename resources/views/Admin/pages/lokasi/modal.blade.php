    <!-- Modal Tambah-->
    <div class="modal fade" id="add-lokasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Tempat PPL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="{{ route('lokasi.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Foto Perusahaan</label>
                                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" required>
                                @error('gambar')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Masukkan Nama Perusahaan" required>
                                    @error('nama')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat Perusahaan"
                                    required>
                                    @error('alamat')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($lokasi as $point)
        @isset($point->id)
            <!-- Modal Edit-->
            <div class="modal fade" id="edit-modal-{{ $point->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Edit Tempat PPL</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form enctype="multipart/form-data" action="{{ route('lokasi.update', $point->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Foto Perusahaan</label>
                                        <input type="file" name="gambar" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control"
                                            value="{{$point->nama}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" value="{{$point->alamat}}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="delete-modal-{{ $point->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Tempat PPL</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{ route('lokasi.destroy', $point->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $point->id }}">
                            <div class="modal-body">
                                Anda yakin ingin menghapus Tempat PPL <b>{{ $point->nama }}</b>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Tutup</span>
                                </button>
                                <button type="submit" class="btn btn-outline-danger ml-1" id="btn-save">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Yakin</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endisset
    @endforeach
