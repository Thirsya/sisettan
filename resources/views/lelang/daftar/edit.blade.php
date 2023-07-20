@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Pendaftar Lelang</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Pendaftar Lelang</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Tambah Data</h4>
                </div>
                <div class="card-body">
                    {{-- <form action="{{ route('daftar.update', $daftar) }}" method="post">
                        @csrf
                        @method('PUT')
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('daftar.index') }}">Batal</a>
                </div>
                </form> --}}
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
