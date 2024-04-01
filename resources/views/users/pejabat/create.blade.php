@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Pejabat</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pejabat.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Nama Pejabat</label>
                            <input type="text" id="nama_pejabat" name="nama_pejabat"
                                class="form-control @error('nama_pejabat') is-invalid @enderror"
                                placeholder="Masukan Nama pejabat" autocomplete="off">
                            @error('nama_pejabat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control select2 @error('id_jabatan') is-invalid @enderror" name="id_jabatan"
                                data-id="select-jabatan" id="id_jabatan">
                                <option value="">Piih Jabatan</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}">
                                        {{ $jabatan->jabatan }}</option>
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
                            <select class="form-control select2 @error('id_opd') is-invalid @enderror" name="id_opd"
                                data-id="select-opd" id="id_opd">
                                <option value="">Piih OPD</option>
                                @foreach ($opds as $opd)
                                    <option value="{{ $opd->id }}">
                                        {{ $opd->no_opd }}</option>
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
                                class="form-control @error('nip_pejabat') is-invalid @enderror"
                                placeholder="Masukan NIP pejabat" autocomplete="off">
                            @error('nip_pejabat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No. SK</label>
                            <input type="text" id="no_sk" name="no_sk"
                                class="form-control @error('no_sk') is-invalid @enderror" placeholder="Masukan No. SK"
                                autocomplete="off">
                            @error('no_sk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('pejabat.index') }}">Cancel</a>
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
