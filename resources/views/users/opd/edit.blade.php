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
                            <label>OPD</label>
                            <input type="text" id="opd" name="opd"
                                class="form-control
                                @error('opd') is-invalid @enderror"
                                placeholder="Masukan opd"
                                value="{{ old('opd', $opd->opd) }}" data-id="input_opd"
                                autocomplete="off">
                            @error('opd')
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
