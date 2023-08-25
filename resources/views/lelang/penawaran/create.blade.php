@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Penawaran</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('penawaran.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Pendaftar</label>
                            <select class="form-control select2 @error('idfk_daftar') is-invalid @enderror"
                                name="idfk_daftar" data-id="select-pendaftar" id="idfk_daftar">
                                <option value="">Piih Pendaftar</option>
                                @foreach ($daftars as $nama)
                                    <option value="{{ $nama->id }}">
                                        {{ $nama->nama }} - {{ $nama->id_daftar }}</option>
                                @endforeach
                            </select>
                            @error('idfk_daftar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>ID Harga Dasar</label>
                            <select class="form-control select2 @error('idfk_tkd') is-invalid @enderror" name="idfk_tkd"
                                data-id="select-tkd" id="idfk_tkd">
                                <option value="">Piih Harga Dasar</option>
                                @foreach ($tkds as $id_tkd)
                                    <option value="{{ $id_tkd->id }}">
                                        {{ $id_tkd->bukti }}</option>
                                @endforeach
                            </select>
                            @error('idfk_tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Luas Bidang</label>
                            <input type="text" id="luas" name="luas"
                                class="form-control @error('luas') is-invalid @enderror" placeholder="Masukan Luas Bidang"
                                autocomplete="off" readonly>
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
                                placeholder="Masukan Harga_dasar Bidang" autocomplete="off" readonly>
                            @error('harga_dasar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nilai Penawaran</label>
                            <input type="text" id="nilai_penawaran" name="nilai_penawaran"
                                class="form-control @error('nilai_penawaran') is-invalid @enderror"
                                placeholder="Masukan Nilai Penawaran" autocomplete="off">
                            @error('nilai_penawaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea id="keterangan" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Masukkan Keterangan" rows="4" autocomplete="off">
                                @error('keterangan')
                                    {{ old('keterangan') }}
                                @enderror
                            </textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('penawaran.index') }}">Cancel</a>
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
        $(document).ready(function() {
            $('#idfk_tkd').change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '{{ route('getTkd') }}',
                        data: {
                            id: id
                        },
                        type: 'GET',
                        success: function(data) {
                            $('#luas').val(data.luas);
                            $('#harga_dasar').val(data.harga_dasar);
                        }
                    });
                } else {
                    $('#luas').val('');
                    $('#harga_dasar').val('');
                }
            });

            $('#nilai_penawaran').mask('000,000,000,000,000', {reverse: true});
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
