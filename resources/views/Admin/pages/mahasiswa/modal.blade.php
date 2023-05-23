    <!-- Modal Tambah-->
    <div class="modal fade" id="add-mahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="{{ route('mahasiswa.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Foto Mahasiswa</label>
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
                                <label class="form-label">Nama Mahasiswa</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Masukkan Nama Mahasiswa" required>
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
                                <label class="form-label">Nim</label>
                                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan Nim"
                                    required>
                                    @error('nim')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="form-password-toggle">
                                    <label class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('password')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Tempat PPL</label>
                                <select class="form-select @error('lokasi_id') is-invalid @enderror" name="lokasi_id" required>
                                    @if ($lokasi->count() != null)
                                    @foreach ($lokasi as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                    @else
                                    <option selected disabled>Data Kosong!</option>
                                    @endif
                                  </select>
                                  @error('lokasi_id')
                                  <div class="invalid-feedback">
                                      <i class="bi bi-exclamation-circle-fill"></i>
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Dosen Pembimbing</label>
                                <select class="form-select @error('dosen_pembimbing_id') is-invalid @enderror" name="dosen_pembimbing_id" required>
                                    @if ($dosen_pembimbing->count() != null)
                                    @foreach ($dosen_pembimbing as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                    @else
                                    <option selected disabled>Data Kosong!</option>
                                    @endif
                                  </select>
                                  @error('dosen_pembimbing_id')
                                  <div class="invalid-feedback">
                                      <i class="bi bi-exclamation-circle-fill"></i>
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Pembimbing Lapangan</label>
                                <select class="form-select @error('pembimbing_lapangan_id') is-invalid @enderror" name="pembimbing_lapangan_id" required>
                                    @if ($pembimbing_lapangan->count() != null)
                                    @foreach ($pembimbing_lapangan as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                    @else
                                    <option selected disabled>Data Kosong!</option>
                                    @endif
                                  </select>
                                  @error('pembimbing_lapangan_id')
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

    @foreach ($mhs as $point)
        @isset($point->id)
            <!-- Modal Edit-->
            <div class="modal fade" id="edit-modal-{{ $point->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Edit Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form enctype="multipart/form-data" action="{{ route('mahasiswa.update', $point->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Foto Mahasiswa</label>
                                        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" value="{{$point->gambar}}">
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
                                        <label class="form-label">Nama Mahasiswa</label>
                                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                          placeholder="Masukan Nama Mahasiswa"  value="{{$point->nama}}" required>
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
                                        <label class="form-label">Nim</label>
                                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan Nim Mahasiswa"
                                        value="{{$point->nim}}" required>
                                        @error('nim')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="form-password-toggle">
                                            <label class="form-label">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                                        @error('password')
                                                        <div class="invalid-feedback">
                                                            <i class="bi bi-exclamation-circle-fill"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Tempat PPL</label>
                                        <select class="form-select @error('lokasi_id') is-invalid @enderror" name="lokasi_id" required>
                                            @if ($point->lokasi_id != null)
                                            <option value="{{$point->lokasi->id}}" selected>{{$point->lokasi->nama}}</option>
                                            @if ($lokasi->count() != null)
                                            @foreach ($lokasi as $item)
                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                            @else
                                            <option selected disabled>Data Kosong!</option>
                                            @endif

                                            @else
                                            <option selected disabled>Data Kosong!</option>
                                            @endif
                                          </select>
                                          @error('lokasi_id')
                                          <div class="invalid-feedback">
                                              <i class="bi bi-exclamation-circle-fill"></i>
                                              {{ $message }}
                                          </div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Dosen Pembimbing</label>
                                        <select class="form-select @error('dosen_pembimbing_id') is-invalid @enderror" name="dosen_pembimbing_id" required>
                                            @if ($point->dosen_pembimbing != null)
                                            <option value="{{$point->dosen_pembimbing->id}}" selected>{{$point->dosen_pembimbing->nama}}</option>
                                            @if ($dosen_pembimbing->count() != null)
                                            @foreach ($dosen_pembimbing as $item)
                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                            @else
                                            <option selected disabled>Data Kosong!</option>
                                            @endif

                                            @else
                                            <option selected disabled>Data Kosong!</option>
                                            @endif
                                          </select>
                                          @error('dosen_pembimbing_id')
                                          <div class="invalid-feedback">
                                              <i class="bi bi-exclamation-circle-fill"></i>
                                              {{ $message }}
                                          </div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label">Pembimbing Lapangan</label>
                                        <select class="form-select @error('pembimbing_lapangan_id') is-invalid @enderror" name="pembimbing_lapangan_id" required>
                                            @if ($point->pembimbing_lapangan != null)
                                            <option value="{{$point->pembimbing_lapangan->id}}" selected>{{$point->pembimbing_lapangan->nama}}</option>
                                            @endif
                                            @if ($pembimbing_lapangan->count() != null)
                                            @foreach ($pembimbing_lapangan as $item)
                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                            @endforeach
                                            @else
                                            <option selected disabled>Data Kosong!</option>
                                            @endif
                                          </select>
                                          @error('pembimbing_lapangan_id')
                                          <div class="invalid-feedback">
                                              <i class="bi bi-exclamation-circle-fill"></i>
                                              {{ $message }}
                                          </div>
                                      @enderror
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
