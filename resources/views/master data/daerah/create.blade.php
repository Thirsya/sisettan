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
                                name="id_kecamatan" data-id="select-kecamatan" id="id_kecamatan">
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
                                name="id_kelurahan" data-id="select-kelurahan" id="id_kelurahan" disabled="disable">
                                <option value="">Piih Kelurahan</option>
                            </select>
                            @error('id_kelurahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Noba</label>
                            <input type="text" id="noba" name="noba"
                                class="form-control @error('noba') is-invalid @enderror"
                                placeholder="Masukan Noba" autocomplete="off">
                            @error('noba')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <input type="text" id="periode" name="periode"
                                class="form-control @error('periode') is-invalid @enderror"
                                placeholder="Masukan Periode" autocomplete="off">
                            @error('periode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control select2 @error('id_tahun') is-invalid @enderror"
                                name="id_tahun" data-id="select-tahun" id="id_tahun">
                                <option value="">Piih Tahun</option>
                                @foreach ($tahuns as $tahun)
                                    <option value="{{ $tahun->id }}">
                                        {{ $tahun->tahun }}</option>
                                @endforeach
                            </select>
                            @error('id_tahun')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lelang</label>
                            <input type="date" id="tanggal_lelang" name="tanggal_lelang"
                                class="form-control @error('tanggal_lelang') is-invalid @enderror"
                                placeholder="Masukan Tanggal Lelang" autocomplete="off">
                            @error('tanggal_lelang')
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
    <script>
        $(document).ready(function() {
            $('#id_kecamatan').change(function() {
                if ($(this).val() == '') {
                    $('#id_kelurahan').attr('disabled', true);
                } else {
                    $('#id_kelurahan').removeAttr('disabled', false);
                }

                var kecamatanId = $(this).val();
                $.ajax({
                    url: '{{ route('getKelurahans') }}',
                    type: 'GET',
                    data: {
                        kecamatan_id: kecamatanId
                    },
                    success: function(response) {
                        $('#id_kelurahan').html('<option value="">Pilih Kelurahan</option>');
                        $.each(response.kelurahans, function(key, kelurahan) {
                            $('#id_kelurahan').append('<option value="' + kelurahan.id +
                                '">' + kelurahan.kelurahan + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Handle the error if any
                    }
                });
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
