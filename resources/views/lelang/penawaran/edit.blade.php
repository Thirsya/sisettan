@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Penawaran</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Penawaran</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('penawaran.update', $penawaran) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Pendaftar</label>
                            <select class="form-control select2 @error('id_daftar') is-invalid @enderror"
                                id="id_daftar" name="id_daftar" data-id="select-id_daftar">
                                <option value="">Pilih Pendaftar</option>
                                @foreach ($daftars as $daftar)
                                    <option @selected($daftar->id == $daftar->id_daftar) value="{{ $daftar->id }}">
                                        {{ $daftar->daftar }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_daftar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>ID Daftar</label>
                            <input type="text" id="id_daftar" name="id_daftar"
                                class="form-control @error('penawaran') is-invalid @enderror "
                                placeholder="Masukan id_daftar" value="{{ old('penawaran', $penawaran->idfk_daftar) }}"
                                data-id="input_id_daftar" autocomplete="off">
                            @error('penawaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>ID Harga Dasar</label>
                            <select class="form-control select2 @error('harga_dasar') is-invalid @enderror"
                                id="harga_dasar" name="harga_dasar" data-id="select-harga_dasar">
                                <option value="">Pilih ID Harga Dasar</option>
                                @foreach ($tkds as $tkd)
                                    <option @selected($penawaran->id == $penawaran->id_tkd) value="{{ $penawaran->id_tkd }}">
                                        {{ $penawaran->penawaran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('harga_dasar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Luas Bidang</label>
                            <input type="text" id="luas_bidang" name="luas_bidang"
                                class="form-control @error('penawaran') is-invalid @enderror "
                                placeholder="Masukan Luas Bidang" value="{{ old('luas_bidang', $penawaran->id_tkd) }}"
                                data-id="input_id_tkd" autocomplete="off">
                            @error('penawaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nilai Penawaran</label>
                            <input type="text" id="nilai_penawaran" name="nilai_penawaran"
                                class="form-control @error('nilai_penawaran') is-invalid @enderror "
                                placeholder="Masukan Nilai Penawaran" value="{{ old('nilai_penawaran', $penawaran->nilai_penawaran) }}"
                                data-id="input_nilai_penawaran" autocomplete="off">
                            @error('nilai_penawaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror "
                                placeholder="Masukan Keterangan" value="{{ old('keterangan', $penawaran->keterangan) }}"
                                data-id="input_keterangan" autocomplete="off">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('penawaran.index') }}">Batal</a>
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
