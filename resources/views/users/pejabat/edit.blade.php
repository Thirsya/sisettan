@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Pejabat</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Pejabat</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pejabat.update', $pejabat) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Pejabat</label>
                            <input type="text" id="nama_pejabat" name="nama_pejabat"
                                class="form-control @error('pejabat') is-invalid @enderror "
                                placeholder="Masukan Nama Pejabat" value="{{ old('pejabat', $pejabat->nama_pejabat) }}"
                                data-id="input_nama_pejabat" autocomplete="off">
                            @error('pejabat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control select2 @error('id_jabatan') is-invalid @enderror"
                                id="id_jabatan" name="id_jabatan" data-id="select-id_jabatan">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatans as $jabatan)
                                    <option @selected($jabatan->id == $pejabat->id_jabatan) value="{{ $jabatan->id }}">
                                        {{ $jabatan->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>OPD</label>
                            <select class="form-control select2 @error('id_opd') is-invalid @enderror"
                                id="id_opd" name="id_opd" data-id="select-id_opd">
                                <option value="">Pilih OPD</option>
                                @foreach ($opds as $opd)
                                    <option @selected($opd->id == $pejabat->id_opd) value="{{ $opd->id }}">
                                        {{ $opd->nama_opd }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_opd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>NIP Pejabat</label>
                            <input type="text" id="nip_pejabat" name="nip_pejabat"
                                class="form-control @error('pejabat') is-invalid @enderror "
                                placeholder="Masukan NIP Pejabat" value="{{ old('pejabat', $pejabat->nip_pejabat) }}"
                                data-id="input_nip_pejabat" autocomplete="off">
                            @error('pejabat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No. SK</label>
                            <input type="text" id="no_sk" name="no_sk"
                                class="form-control @error('pejabat') is-invalid @enderror "
                                placeholder="Masukan No. SK" value="{{ old('pejabat', $pejabat->no_sk) }}"
                                data-id="input_no_sk" autocomplete="off">
                            @error('pejabat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('pejabat.index') }}">Batal</a>
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
