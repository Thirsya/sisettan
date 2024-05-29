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
                    <form action="{{ route('daftar.update', $daftar) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                id="id_kelurahan" name="id_kelurahan_disabled" data-id="select-id_kelurahan" disabled>
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option @selected($kelurahan->id == $daftar->id_kelurahan) value="{{ $kelurahan->id }}">
                                        {{ $kelurahan->kelurahan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <input type="hidden" name="id_kelurahan" value="{{ $daftar->id_kelurahan }}">
                        </div>
                        <div class="form-group">
                            <label>Nomor Urut</label>
                            <input type="text" id="no_urut" name="no_urut"
                                class="form-control @error('no_urut') is-invalid @enderror" placeholder="Masukan Nomor Urut"
                                value="{{ old('daftar', $daftar->no_urut) }}" data-id="input_no_urut" autocomplete="off"
                                readonly>
                            @error('no_urut')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror " placeholder="Masukan nama"
                                value="{{ old('daftar', $daftar->nama) }}" data-id="input_nama" autocomplete="off">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nomor Kartu Keluarga</label>
                            <input type="text" id="no_kk" name="no_kk"
                                class="form-control @error('no_kk') is-invalid @enderror "
                                placeholder="Masukan No. Kartu Keluarga" value="{{ old('daftar', $daftar->no_kk) }}"
                                data-id="input_no_kk" autocomplete="off">
                            @error('no_kk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" id="alamat" name="alamat"
                                class="form-control @error('alamat') is-invalid @enderror " placeholder="Masukan alamat"
                                value="{{ old('daftar', $daftar->alamat) }}" data-id="input_alamat" autocomplete="off">
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nomor WP</label>
                            <input type="text" id="no_wp" name="no_wp"
                                class="form-control @error('no_wp') is-invalid @enderror " placeholder="Masukan Nomor WP"
                                value="{{ old('daftar', $daftar->no_wp) }}" data-id="input_no_wp" autocomplete="off">
                            @error('no_wp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Perjanjian</label>
                            <input type="date" id="tgl_perjanjian" name="tgl_perjanjian"
                                class="form-control @error('tgl_perjanjian') is-invalid @enderror"
                                placeholder="Masukkan Tanggal Lelang"
                                value="{{ old('tgl_perjanjian', $daftar->tgl_perjanjian) }}" data-id="input_tgl_perjanjian"
                                autocomplete="off">
                            @error('tgl_perjanjian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('daftar.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#id_kelurahan').change(function() {
                var id = $(this).val();

                $.ajax({
                    url: '{{ route('getLatestNoUrut') }}',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        $('#no_urut').val(response);
                    }
                });
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
