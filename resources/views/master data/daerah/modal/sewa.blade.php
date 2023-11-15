<form action="" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="modal-sewa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengumuman Masa Sewa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kecamatan<span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('id_kecamatan') is-invalid @enderror"
                            name="id_kecamatan" data-id="select-kecamatan" id="id_kecamatan">
                            <option value="">Piih Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}">
                                    {{ $kecamatan->kecamatan }}</option>
                            @endforeach
                        </select>
                        @error('id_kecamatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kelurahan<span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                            name="id_kelurahan" data-id="select-kelurahan" id="id_kelurahan" disabled="disable">
                            <option value="">Piih Kelurahan</option>
                        </select>
                        @error('id_kelurahan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>No Berita Acara</label>
                        <input type="text" id="noba" name="noba"
                            class="form-control @error('noba') is-invalid @enderror"
                            placeholder="Masukan Noba" autocomplete="off">
                        @error('noba')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Periode<span class="text-danger">*</span></label>
                        <input type="text" id="periode" name="periode"
                            class="form-control @error('periode') is-invalid @enderror"
                            placeholder="Masukan Periode" autocomplete="off">
                        @error('periode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tahun<span class="text-danger">*</span></label>
                        <select class="form-control select2 @error('id_tahun') is-invalid @enderror"
                            name="id_tahun" data-id="select-tahun" id="id_tahun">
                            <option value="">Piih Tahun</option>
                            {{-- @foreach ($tahuns as $tahun)
                                <option value="{{ $tahun->id }}">
                                    {{ $tahun->tahun }}</option>
                            @endforeach --}}
                        </select>
                        @error('id_tahun')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lelang<span class="text-danger">*</span></label>
                        <input type="date" id="tanggal_lelang" name="tanggal_lelang"
                            class="form-control @error('tanggal_lelang') is-invalid @enderror"
                            placeholder="Masukan Tanggal Lelang" autocomplete="off">
                        @error('tanggal_lelang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                 </div>
            </div>
        </div>
    </div>

</form>
