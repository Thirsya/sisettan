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
                <div class="form-group col-md-4" style=" display: flex; float: right;">
                    <input type="text" name="bukti" class="form-control" id="bukti" placeholder="Bukti Hak">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
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
                                                <div class="d-flex">
                                                    <input type="text" name="nilai_penawaran[{{ $tkd->id }}]"
                                                        class="form-control" id="nilai_penawaran_{{ $tkd->id }}">

                                                    <button type="button" class="btn btn-success ml-2 save-btn"
                                                        id="save_{{ $tkd->id }}" style="display:none;">Save</button>
                                                </div>
                                                <div class="invalid-feedback" id="feedback_{{ $tkd->id }}">
                                                    Invalid value.
                                                </div>

                                                <input type="hidden" name="idfk_daftar[{{ $tkd->id }}]"
                                                    value="{{ $daftars->id }}" id="idfk_daftar_{{ $tkd->id }}">
                                                <input type="hidden" name="idfk_tkd[{{ $tkd->id }}]"
                                                    value="{{ $tkd->id }}" id="idfk_tkd_{{ $tkd->id }}">
                                                <input type="hidden" name="harga_dasar[{{ $tkd->id }}]"
                                                    value="{{ $tkd->harga_dasar }}" id="harga_dasar_{{ $tkd->id }}">
                                                <input type="hidden" name="luas[{{ $tkd->id }}]"
                                                    value="{{ $tkd->luas }}" id="luas_{{ $tkd->id }}">
                                                <input type="hidden" name="keterangan[{{ $tkd->id }}]"
                                                    value="">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            {{-- <button type="submit" class="btn btn-success">Save</button> --}}
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
            bindEventsAndPlugins();

            function bindEventsAndPlugins() {
                $('[id^=nilai_penawaran_]').mask('000,000,000,000,000', {
                    reverse: true
                });

                $('[id^=nilai_penawaran_]').on('keyup change', function() {
                    var index = this.id.split('_').pop();
                    var hargaDasar = parseFloat($(`[name="harga_dasar[${index}]"]`).val().replace(/,/g,
                        ''));
                    var currentValue = parseFloat($(this).val().replace(/,/g, ''));

                    if (currentValue < hargaDasar) {
                        $(`#feedback_${index}`).text(
                            `Nilai Penawaran minimal Rp ${hargaDasar.toLocaleString()}`);
                        $(`#feedback_${index}`).show();
                        $(`#save_${index}`).hide();
                    } else {
                        $(`#feedback_${index}`).hide();
                        if ($(this).val()) {
                            $(`#save_${index}`).show();
                        }
                    }
                });

                $('.save-btn').on('click', function() {
                    var index = this.id.split('_').pop();

                    var data = {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'nilai_penawaran': $(`#nilai_penawaran_${index}`).val().replace(/,/g, ''),
                        'idfk_daftar': $(`#idfk_daftar_${index}`).val(),
                        'idfk_tkd': $(`#idfk_tkd_${index}`).val(),
                        'harga_dasar': $(`#harga_dasar_${index}`).val(),
                        'luas': $(`#luas_${index}`).val(),
                    };

                    $.post('/lelang/penawaran', data, function(response) {
                        if (response.success) {
                            refreshTableData();
                        } else {
                            alert(response.message);
                        }
                    });
                });
            }

            function refreshTableData() {
                $.get('/lelang/penawaran/create', function(data) {
                    $('.section').replaceWith($(data).find('.section'));
                    bindEventsAndPlugins();
                });
            }
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
