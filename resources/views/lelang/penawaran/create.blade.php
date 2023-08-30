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
                    <h4>Penawar : </h4>
                </div>
                <div class="card-header">
                    <h4>No Urut : </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tbody>
                                <tr style="text-align: center">
                                    <th>Bukti</th>
                                    <th>Luas</th>
                                    <th>Bidang</th>
                                    <th>Harga Dasar</th>
                                    <th>Pemenang</th>
                                    <th class="text-right" style="width: 500px; text-align: center" >Penawaran</th>
                                </tr>
                                    <tr>
                                        {{-- <td>{{ ($penawarans->currentPage() - 1) * $penawarans->perPage() + $key + 1 }}
                                        </td>
                                        <td>{{ $penawaran->total_luas }} m<sup>2</sup></td>
                                        <td>{{ $penawaran->nama }}</td>
                                        <td>{{ $penawaran->bukti }} bidang {{ $penawaran->bidang }}</td>
                                        <td>{{ number_format($penawaran->luas, 0, ',', '.') }} m<sup>2</sup></td>
                                        <td>Rp {{ number_format($penawaran->harga_dasar, 0, ',', '.') }}</td>
                                        <td>{{ 'Rp ' . number_format($penawaran->nilai_penawaran, 0, ',', '.') }}</td>
                                        <td class="text-right">
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('penawaran.edit', $penawaran->id) }}"
                                                    class="btn btn-sm btn-info btn-icon "><i
                                                        class="fas fa-edit"></i>
                                                    Edit</a>
                                                <form action="{{ route('penawaran.destroy', $penawaran->id) }}"
                                                    method="POST" class="ml-2">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token"
                                                        value="{{ csrf_token() }}">
                                                    <button class="btn btn-sm btn-danger btn-icon confirm-delete" type="submit">
                                                        <i class="fas fa-times"></i> Delete </button>
                                                </form>
                                            </div>
                                        </td> --}}
                                    </tr>
                            </tbody>
                        </table>
                        {{-- <div class="d-flex justify-content-center">
                            {{ $penawarans->withQueryString()->links() }}
                        </div> --}}
                    </div>
                <div class="card-footer text-right">
                    <a class="btn btn-primary" href="{{ route('penawaran.index')}}">Selesai</a>
                    {{-- <a class="btn btn-secondary" href="{{ route('penawaran.index') }}">Cancel</a> --}}
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
