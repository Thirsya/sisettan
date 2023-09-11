@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">STS Pemenang</h2>
            <a class="btn btn-info btn-primary active bg-primary"></i>(STS) Pemenang 1</a>
            <a class="btn btn-info btn-primary active bg-primary"></i>(STS) Pemenang 2</a>
        <br><br><br>
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr style="text-align: center">
                                        <th>No Urut</th>
                                        <th>Nama</th>
                                        <th>Bukti Hak</th>
                                        <th>Luas</th>
                                        <th>Penawaran</th>
                                        <th>Tanggal Perjanjian</th>
                                        <th>Menu</th>
                                    </tr>
                                    {{-- @foreach ($stss as $key => $sts) --}}
                                        {{-- <tr>
                                            <td>{{ $daftar->no_urut }}</td>
                                            <td>{{ $daftar->nama}}</td>
                                            <td>{{ $tkd->bukti }}</td>
                                            <td>{{ $tkd->luas}}</td>
                                            <td>{{ $penawaran->nilai_penawaran}}</td>
                                            <td>
                                                <input type="date" id="tgl_perjanjian" name="tgl_perjanjian">
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <form action="{{ route('penawaran.destroy', $penawaran->id) }}"
                                                        method="POST" class="ml-2">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                            type="submit">
                                                            <i class="fas fa-times"></i> Delete </button>
                                                    </form>
                                                    <a href="#" class="btn btn-sm btn-danger btn-icon confirm-delete" type="submit">Di Gugurkan</a>
                                                    <a href="#" class="btn btn-sm btn-info btn-icon ">Cetak STS</a>
                                                    <a href="#" class="btn btn-sm btn-info btn-icon ">Cetak Pernyataan</a>
                                                    <a href="#" class="btn btn-sm btn-info btn-icon ">Cetak Perjanjian</a>
                                                </div>
                                            </td>
                                        </tr> --}}
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
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
