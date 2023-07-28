@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit OPD</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('opd.update', $opd) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nomor OPD</label>
                            <input type="text" id="no_opd" name="no_opd"
                                class="form-control
                                @error('no_opd') is-invalid @enderror"
                                placeholder="Masukan no_opd"
                                value="{{ old('no_opd', $no_opd->no_opd) }}" data-id="input_no_opd"
                                autocomplete="off">
                            @error('no_opd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama OPD</label>
                            <select class="form-control select2 @error('id_kecamatan') is-invalid @enderror"
                                id="id_kecamatan" name="id_kecamatan" data-id="select-id_kecamatan">
                                <option value="">Pilih OPD</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option @selected($kecamatan->id == $opd->id_kecamatan) value="{{ $kecamatan->id }}">
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
