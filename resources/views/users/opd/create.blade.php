@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah OPD</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('opd.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Nomor OPD</label>
                            <input type="text" id="no_opd" name="no_opd"
                                class="form-control @error('no_opd') is-invalid @enderror"
                                placeholder="Masukan Nomor OPD" autocomplete="off">
                            @error('no_opd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama OPD</label>
                            <input type="text" id="nama_opd" name="nama_opd"
                                class="form-control @error('nama_opd') is-invalid @enderror"
                                placeholder="Masukan Nama OPD" autocomplete="off">
                            @error('nama_opd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('opd.index') }}">Cancel</a>
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
