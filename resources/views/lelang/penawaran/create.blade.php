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
                    <h4>Penawar : {{ $daftars->nama }}</h4>
                </div>
                <div class="card-header">
                    <h4>No Urut : {{ $daftars->no_urut }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('penawaran.store') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr style="text-align: center">
                                        <th>Bukti</th>
                                        <th>Luas</th>
                                        <th>Bidang</th>
                                        <th>Harga Dasar</th>
                                        <th>Pemenang II</th>
                                        <th>Penawaran</th>
                                    </tr>
                                    @foreach ($tkds as $key => $tkd)
                                        <tr>
                                            <td>{{ $tkd->bukti }}</td>
                                            <td>{{ number_format($tkd->luas, 0, ',', '.') }} m<sup>2</sup></td>
                                            <td>{{ $tkd->bidang }}</td>
                                            <td>Rp {{ number_format($tkd->harga_dasar, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format((float) $tkd->nilai_penawaran, 0, ',', '.') }}</td>
                                            <td>
                                                <input type="text" name="nilai_penawaran[{{ $tkd->id }}]"
                                                    class="form-control" id="nilai_penawaran_{{ $tkd->id }}">
                                                <input type="hidden" name="idfk_daftar[{{ $tkd->id }}]"
                                                    value="{{ $daftars->id }}">
                                                <input type="hidden" name="idfk_tkd[{{ $tkd->id }}]"
                                                    value="{{ $tkd->id }}">
                                                <input type="hidden" name="harga_dasar[{{ $tkd->id }}]"
                                                    value="{{ $tkd->harga_dasar }}">
                                                <input type="hidden" name="luas[{{ $tkd->id }}]"
                                                    value="{{ $tkd->luas }}">
                                                <input type="hidden" name="keterangan[{{ $tkd->id }}]"
                                                    value="">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a class="btn btn-primary" href="{{ route('penawaran.index') }}">Selesai</a>
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
            $('[id^=nilai_penawaran_]').mask('000,000,000,000,000', {
                reverse: true
            });

            // Saat form disubmit, bersihkan format dari semua input nilai_penawaran
            $('form').on('submit', function() {
                $('[id^=nilai_penawaran_]').each(function() {
                    var cleanValue = $(this).val().replace(/,/g, ''); // Hapus semua tanda koma
                    $(this).val(cleanValue);
                });
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
