@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Daerah</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('daerah.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select class="form-control select2 @error('id_kecamatan') is-invalid @enderror"
                                name="id_kecamatan" data-id="select-jenis-barang" id="id_kecamatan">
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
                            <label>Kelurahan</label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                name="id_kelurahan" data-id="select-jenis-barang" id="id_kelurahan">
                                <option value="">Piih kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->id }}">
                                        {{ $kelurahan->kelurahan }}</option>
                                @endforeach
                            </select>
                            @error('id_kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" id="daerah" name="daerah"
                                class="form-control @error('daerah') is-invalid @enderror"
                                placeholder="Masukan daerah" autocomplete="off">
                            @error('daerah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('daerah.index') }}">Cancel</a>
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
