@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Kecamatan</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('kecamatan.update', $kecamatan) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <input type="text" id="kecamatan" name="kecamatan"
                                class="form-control
                                @error('kecamatan') is-invalid @enderror"
                                placeholder="Masukan Kecamatan"
                                value="{{ old('kecamatan', $kecamatan->kecamatan) }}" data-id="input_kecamatan"
                                autocomplete="off">
                            @error('kecamatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('kecamatan.index') }}">Cancel</a>
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
