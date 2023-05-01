    <!-- Modal Tambah-->
    <div class="modal fade" id="add-mahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Dosen Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('mahasiswa.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nama Dosen Lapangan</label>
                                <input type="text" name="nama" class="form-control"
                                    placeholder="Masukkan Nama Mahasiswa" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Nim</label>
                                <input type="text" name="nim" class="form-control" placeholder="Masukkan Nim"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Tempat PPL</label>
                                <input type="text" name="tempat_ppl" class="form-control"
                                    placeholder="Masukkan Tempat PPL" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Dosen Pembimbing</label>
                                <input type="text" name="dosen_pembimbing" class="form-control"
                                    placeholder="Masukkan Dosen Pembimbing" required>
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

    @foreach ($dosen_pembimbing_lapangan as $point)
        @isset($point->id)
            <!-- Modal Edit-->
            <div class="modal fade" id="edit-modal-{{ $point->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Edit Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('mahasiswa.update', $point->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Nama Mahasiswa</label>
                                        <input type="text" name="nama" class="form-control"
                                          placeholder="Masukan Nama Mahasiswa"  value="{{$point->nama}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Nim</label>
                                        <input type="text" name="nim" class="form-control" placeholder="Masukkan Nim Mahasiswa"
                                        value="{{$point->nim}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="form-password-toggle">
                                            <label class="form-label">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" value="{{$point->password}}" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Tempat PPL</label>
                                        <input type="text" name="tempat_ppl" class="form-control"
                                            placeholder="Masukkan Tempat PPL Mahasiswa" value="{{$point->tempat_ppl}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Dosen Pembimbing</label>
                                        <input type="text" name="dosen_pembimbing" class="form-control"
                                            placeholder="Masukkan Dosen Pembimbing Mahasiswa" value="{{$point->dosen_pembimbing}}" required>
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
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{ route('mahasiswa.destroy', $point->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $point->id }}">
                            <div class="modal-body">
                                Anda yakin ingin menghapus Mahasiswa <b>{{ $point->nama }}</b>
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
