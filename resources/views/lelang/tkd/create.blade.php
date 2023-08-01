@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Harga Dasar</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tkd.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                name="id_kelurahan" data-id="select-kelurahan" id="id_kelurahan">
                                <option value="">Piih Kelurahan</option>
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
                            <label>Letak</label>
                            <input type="text" id="letak" name="letak"
                                class="form-control @error('letak') is-invalid @enderror"
                                placeholder="Masukan Letak" autocomplete="off">
                            @error('letak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bidang</label>
                            <input type="text" id="bidang" name="bidang"
                                class="form-control @error('bidang') is-invalid @enderror"
                                placeholder="Masukan Bidang" autocomplete="off">
                            @error('bidang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bukti</label>
                            <input type="text" id="bukti" name="bukti"
                                class="form-control @error('bukti') is-invalid @enderror"
                                placeholder="Masukan Bukti" autocomplete="off">
                            @error('bukti')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Luas</label>
                            <input type="text" id="luas" name="luas"
                                class="form-control @error('luas') is-invalid @enderror"
                                placeholder="Masukan Luas" autocomplete="off">
                            @error('luas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Dasar</label>
                            <input type="text" id="harga_dasar" name="harga_dasar"
                                class="form-control @error('harga_dasar') is-invalid @enderror"
                                placeholder="Masukan Harga Dasar" autocomplete="off">
                            @error('harga_dasar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Masukan Keterangan" autocomplete="off">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nop</label>
                            <input type="text" id="nop" name="nop"
                                class="form-control @error('nop') is-invalid @enderror"
                                placeholder="Masukan Nop" autocomplete="off">
                            @error('nop')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('tkd.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script type="text/javascript">
        // Format mata uang saat pengguna mengetik di kolom "Nilai Penawaran"
        $('#harga_dasar').mask('000,000,000,000,000', {reverse: true});
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
