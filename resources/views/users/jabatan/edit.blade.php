@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Jabatan</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jabatan.update', $jabatan) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan"
                                class="form-control
                                @error('jabatan') is-invalid @enderror"
                                placeholder="Masukan jabatan"
                                value="{{ old('jabatan', $jabatan->jabatan) }}" data-id="input_jabatan"
                                autocomplete="off">
                            @error('jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('jabatan.index') }}">Cancel</a>
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
