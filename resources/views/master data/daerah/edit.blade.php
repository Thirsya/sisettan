@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Daerah Lelang</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Daerah Lelang</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('daerah.update', $daerah) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control select2 @error('id_kecamatan') is-invalid @enderror"
                                id="id_kecamatan" name="id_kecamatan" data-id="select-id_kecamatan">
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option @selected($kecamatan->id == $daerah->id_kecamatan) value="{{ $kecamatan->id }}">
                                        {{ $kecamatan->kecamatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kecamatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                id="id_kelurahan" name="id_kelurahan" data-id="select-id_kelurahan">
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option @selected($kelurahan->id == $daerah->id_kelurahan) value="{{ $kelurahan->id }}">
                                        {{ $kelurahan->kelurahan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Noba</label>
                            <input type="text" id="noba" name="noba"
                                class="form-control @error('noba') is-invalid @enderror "
                                placeholder="Masukan Noba" value="{{ old('noba', $daerah->noba) }}"
                                data-id="input_noba" autocomplete="off">
                            @error('noba')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <input type="text" id="periode" name="periode"
                                class="form-control @error('periode') is-invalid @enderror "
                                placeholder="Masukan Periode" value="{{ old('periode', $daerah->periode) }}"
                                data-id="input_periode" autocomplete="off">
                            @error('periode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control select2 @error('thn_sts') is-invalid @enderror"
                                id="thn_sts" name="thn_sts" data-id="select-thn_sts">
                                <option value="">Pilih Tahun</option>
                                @foreach ($tahuns as $tahun)
                                    <option @selected($tahun->id == $daerah->thn_sts) value="{{ $tahun->id }}">
                                        {{ $tahun->tahun }}
                                    </option>
                                @endforeach
                            </select>
                            @error('thn_sts')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lelang</label>
                            <input type="date" id="tanggal_lelang" name="tanggal_lelang"
                                class="form-control @error('daerah') is-invalid @enderror "
                                placeholder="Masukan Tanggal Lelang" value="{{ old('daerah', $daerah->tanggal_lelang) }}"
                                data-id="input_tanggal_lelang" autocomplete="off">
                            @error('daerah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('daerah.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
