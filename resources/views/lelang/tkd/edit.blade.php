@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Harga Daasar</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Harga Daasar</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tkd.update', $tkd) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select class="form-control select2 @error('id_kelurahan') is-invalid @enderror"
                                id="id_kelurahan" name="id_kelurahan" data-id="select-id_kelurahan">
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option @selected($kelurahan->id == $tkd->id_kelurahan) value="{{ $kelurahan->id }}">
                                        {{ $kelurahan->kelurahan }}
                                    </option>
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
                                class="form-control @error('tkd') is-invalid @enderror "
                                placeholder="Masukan Letak" value="{{ old('tkd', $tkd->letak) }}"
                                data-id="input_letak" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bidang</label>
                            <input type="text" id="bidang" name="bidang"
                                class="form-control @error('tkd') is-invalid @enderror "
                                placeholder="Masukan Bidang" value="{{ old('tkd', $tkd->bidang) }}"
                                data-id="input_bidang" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Bukti</label>
                            <input type="text" id="bukti" name="bukti"
                                class="form-control @error('tkd') is-invalid @enderror "
                                placeholder="Masukan Bukti" value="{{ old('tkd', $tkd->bukti) }}"
                                data-id="input_bukti" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Luas</label>
                            <input type="text" id="luas" name="luas"
                                class="form-control @error('tkd') is-invalid @enderror "
                                placeholder="Masukan Luas" value="{{ old('tkd', $tkd->luas) }}"
                                data-id="input_luas" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Dasar</label>
                            <input type="text" id="harga_dasar" name="harga_dasar"
                                class="form-control @error('tkd') is-invalid @enderror "
                                placeholder="Masukan Harga Dasar" value="{{ old('tkd', $tkd->harga_dasar) }}"
                                data-id="input_harga_dasar" autocomplete="off">
                            @error('tkd')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror "
                                placeholder="Masukan Keterangan" value="{{ old('keterangan', $tkd->keterangan) }}"
                                data-id="input_keterangan" autocomplete="off">
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nop</label>
                            <input type="text" id="nop" name="nop"
                                class="form-control @error('nop') is-invalid @enderror "
                                placeholder="Masukan Nop" value="{{ old('nop', $tkd->nop) }}"
                                data-id="input_nop" autocomplete="off">
                            @error('nop')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('tkd.index') }}">Batal</a>
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
